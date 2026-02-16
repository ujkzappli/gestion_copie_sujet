<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Etablissement;
use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserMail;

class AdminUserController extends Controller
{
     public function index()
    {
        $users = User::with(['etablissement', 'departement'])->get(); // charger relations

        return view('admin.users.index', compact('users'));
    }

    // Formulaire création utilisateur
    public function create()
    {
        $etablissements = Etablissement::all();
        $departements = Departement::all();
        return view('admin.users.create', compact('etablissements', 'departements'));
    }

    // Création utilisateur
    public function store(Request $request)
    {
        $usersCreated = 0;
        $importErrors = [];

        // --- 1) Si on a un CSV ---
        if ($request->hasFile('csv_file')) {

            $file = $request->file('csv_file');
            $handle = fopen($file->getRealPath(), 'r');

            if (!$handle) {
                return back()->with('error', 'Impossible d’ouvrir le fichier CSV.');
            }

            // Détecter séparateur automatiquement
            $firstLine = fgets($handle);
            rewind($handle);
            $delimiter = substr_count($firstLine, ';') > substr_count($firstLine, ',') ? ';' : ',';

            $header = fgetcsv($handle, 1000, $delimiter);

            // Supprimer BOM
            $header[0] = preg_replace('/\x{FEFF}/u', '', $header[0]);

            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (count($row) <= 1 && trim($row[0]) === '') continue;

                $data = array_combine($header, $row);
                $data = array_map(fn($v) => is_string($v) ? str_replace("\u{FEFF}", '', $v) : $v, $data);

                // IDs en int
                $data['etablissement_id'] = !empty($data['etablissement_id']) ? (int) $data['etablissement_id'] : null;
                $data['departement_id'] = !empty($data['departement_id']) ? (int) $data['departement_id'] : null;

                try {
                    // Vérification unicité
                    if (User::where('email', $data['email'])->exists()) {
                        $importErrors[] = "Email déjà existant : " . $data['email'];
                        continue;
                    }
                    if (User::where('matricule_utilisateur', $data['matricule_utilisateur'])->exists()) {
                        $importErrors[] = "Matricule déjà existant : " . $data['matricule_utilisateur'];
                        continue;
                    }

                    $password = Str::random(8);

                    $user = User::create([
                        'nom_utilisateur'       => $data['nom_utilisateur'],
                        'prenom_utilisateur'    => $data['prenom_utilisateur'],
                        'email'                 => $data['email'],
                        'matricule_utilisateur' => $data['matricule_utilisateur'],
                        'type'                  => $data['type'],
                        'etablissement_id'      => $data['etablissement_id'],
                        'departement_id'        => $data['departement_id'],
                        'password'              => Hash::make($password),
                    ]);

                    Mail::to($user->email)->send(new NewUserMail($user, $password));

                    $usersCreated++;

                } catch (\Exception $e) {
                    $importErrors[] = "Erreur ligne : " . implode($delimiter, $row) . " - " . $e->getMessage();
                }
            }

            fclose($handle);
        }

        // --- 2) Création manuelle depuis le formulaire ---
        if ($request->filled('nom_utilisateur') && $request->filled('email')) {
            $request->validate([
                'nom_utilisateur' => 'required|string|max:255',
                'prenom_utilisateur' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'matricule_utilisateur' => 'required|unique:users,matricule_utilisateur',
                'type' => 'required|in:Admin,President,Enseignant,CD,CS,DA',
                'etablissement_id' => 'nullable|required_if:type,DA,CS,CD',
                'departement_id' => 'nullable|required_if:type,CD,Enseignant',
            ]);

            $password = Str::random(8);

            $user = User::create([
                'nom_utilisateur'       => $request->nom_utilisateur,
                'prenom_utilisateur'    => $request->prenom_utilisateur,
                'email'                 => $request->email,
                'matricule_utilisateur' => $request->matricule_utilisateur,
                'type'                  => $request->type,
                'etablissement_id'      => $request->etablissement_id,
                'departement_id'        => $request->departement_id,
                'password'              => Hash::make($password),
            ]);

            Mail::to($user->email)->send(new NewUserMail($user, $password));

            $usersCreated++;
        }

        return back()->with('success', "$usersCreated utilisateurs importés/créés avec succès.")
                    ->with('import_errors', $importErrors);
    }

    public function show(User $user)
    {
        // Affiche la page de détails d’un utilisateur
        return view('admin.users.show', compact('user'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé.');
    }

    public function importForm()
    {
        return view('admin.users.import');
    }

    public function importProcess(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');

        if (!$handle) {
            return back()->with('error', 'Impossible d’ouvrir le fichier.');
        }

        // Lire la première ligne pour détecter séparateur
        $firstLine = fgets($handle);
        rewind($handle); // revenir au début du fichier

        // Détecter séparateur : ; ou ,
        $delimiter = substr_count($firstLine, ';') > substr_count($firstLine, ',') ? ';' : ',';

        $header = fgetcsv($handle, 1000, $delimiter);

        // Supprimer BOM si présent
        $header[0] = preg_replace('/\x{FEFF}/u', '', $header[0]);

        $imported = 0;
        $errors = [];

        while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
            // Skip empty lines
            if (count($row) <= 1 && trim($row[0]) === '') continue;

            $data = array_combine($header, $row);

            // Supprimer BOM éventuel pour chaque valeur
            $data = array_map(function($value) {
                return is_string($value) ? str_replace("\u{FEFF}", '', $value) : $value;
            }, $data);

            // Caster IDs en int
            $data['etablissement_id'] = !empty($data['etablissement_id']) ? (int) $data['etablissement_id'] : null;
            $data['departement_id'] = !empty($data['departement_id']) ? (int) $data['departement_id'] : null;

            try {
                // Vérifier unicité
                if (User::where('email', $data['email'])->exists()) {
                    $errors[] = "Email déjà existant : " . $data['email'];
                    continue;
                }

                if (User::where('matricule_utilisateur', $data['matricule_utilisateur'])->exists()) {
                    $errors[] = "Matricule déjà existant : " . $data['matricule_utilisateur'];
                    continue;
                }

                // Génération mot de passe
                $password = \Illuminate\Support\Str::random(8);

                // Création utilisateur
                $user = User::create([
                    'nom_utilisateur'       => $data['nom_utilisateur'],
                    'prenom_utilisateur'    => $data['prenom_utilisateur'],
                    'email'                 => $data['email'],
                    'matricule_utilisateur' => $data['matricule_utilisateur'],
                    'type'                  => $data['type'],
                    'etablissement_id'      => $data['etablissement_id'],
                    'departement_id'        => $data['departement_id'],
                    'password'              => \Illuminate\Support\Facades\Hash::make($password),
                ]);

                // Envoi mail
                \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\NewUserMail($user, $password));

                $imported++;

            } catch (\Exception $e) {
                $errors[] = "Erreur ligne : " . implode($delimiter, $row) . " - " . $e->getMessage();
            }
        }

        fclose($handle);

        return redirect()->route('admin.users.create')
            ->with('success', "$imported utilisateurs importés avec succès.")
            ->with('import_errors', $errors);
    }



    // Index, edit, update, destroy peuvent être ajoutés ici
}
