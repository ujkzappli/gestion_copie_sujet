<?php

namespace App\Services;

use App\Models\LotCopie;
use App\Models\User;
use App\Models\RetardNotification;
use App\Notifications\RetardCopieNotification;
use Carbon\Carbon;

class ScanRetardsService
{
    public function scan(): void
    {
        $today = Carbon::today();

        // On récupère tous les lots
        $lots = LotCopie::with([
            'module.enseignant',
            'module.semestre.options.departement.etablissement'
        ])->get();

        foreach ($lots as $lot) {

            $this->checkRetardRecuperation($lot, $today);
            $this->checkRetardRemise($lot, $today);

        }
    }


    protected function checkRetardRecuperation($lot, $today)
    {
        $limite = $lot->date_disponible->copy()->addDays(2);

        if ($today->lte($limite)) return;

        $alreadySent = RetardNotification::where([
            'lot_copie_id' => $lot->id,
            'type' => 'recuperation',
            'sent_at' => $today
        ])->exists();

        if ($alreadySent) return;

        $jours = $limite->diffInDays($today);

        $enseignant = $lot->module->enseignant;

        $message = "Vos copies du module {$lot->module->nom} sont disponibles depuis le "
            . $lot->date_disponible->format('d/m/Y')
            . ". Vous êtes en retard de {$jours} jour(s). "
            . "Veuillez contacter votre chef de département ou le directeur académique.";

        // Envoi à l'enseignant
        $enseignant->notify(
            new RetardCopieNotification(
                'Retard de récupération des copies',
                $message
            )
        );

        // Envoi aux DA de l'établissement
        $daUsers = User::where('type', 'DA')
            ->where('etablissement_id', $enseignant->etablissement_id)
            ->get();

        foreach ($daUsers as $da) {
            $da->notify(
                new RetardCopieNotification(
                    "Enseignant en retard : {$enseignant->prenom_utilisateur} {$enseignant->nom_utilisateur}",
                    "L'enseignant du module {$lot->module->nom} est en retard de {$jours} jour(s). "
                    . "Contactez-le via Whatsapp: wa.me/{$enseignant->phone_number} ou mail: {$enseignant->email}"
                )
            );
        }

        // Enregistrement anti-spam
        RetardNotification::create([
            'lot_copie_id' => $lot->id,
            'type' => 'recuperation',
            'sent_at' => $today,
        ]);
    }



    protected function checkRetardRemise($lot, $today)
    {
        if (!$lot->date_recuperation || !$lot->date_remise) return;

        $limite = $lot->date_disponible->copy()->addDays(14);

        if ($today->lte($limite)) return;

        $alreadySent = RetardNotification::where([
            'lot_copie_id' => $lot->id,
            'type' => 'remise',
            'sent_at' => $today
        ])->exists();

        if ($alreadySent) return;

        $jours = $limite->diffInDays($today);

        $enseignant = $lot->module->enseignant;

        $message = "Vous devez remettre vos notes du module {$lot->module->nom}. "
            . "Vous êtes en retard de {$jours} jour(s). "
            . "Veuillez contacter votre chef de département ou le directeur académique "
            . "pour remettre vos notes ou envoyer la version scannée.";

        // Envoi à l'enseignant
        $enseignant->notify(
            new RetardCopieNotification(
                'Retard de remise des notes',
                $message
            )
        );

        // Envoi aux DA de l'établissement
        $daUsers = User::where('type', 'DA')
            ->where('etablissement_id', $enseignant->etablissement_id)
            ->get();

        foreach ($daUsers as $da) {
            $da->notify(
                new RetardCopieNotification(
                    "Enseignant en retard : {$enseignant->prenom_utilisateur} {$enseignant->nom_utilisateur}",
                    "L'enseignant du module {$lot->module->nom} est en retard de remise de {$jours} jour(s). "
                    . "Contactez-le via Whatsapp: wa.me/{$enseignant->full_phone} ou mail: {$enseignant->email}"
                )
            );
        }

        // Anti-spam
        RetardNotification::create([
            'lot_copie_id' => $lot->id,
            'type' => 'remise',
            'sent_at' => $today,
        ]);
    }

}
