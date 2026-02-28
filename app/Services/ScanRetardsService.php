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
            $this->checkAvertissementRemise($lot, $today);
            $this->checkRetardRemise($lot, $today);
        }
    }

    /**
     * Vérification du retard de récupération des copies
     * Si date_today = date_disponible + 5 jours ET date_recuperation = null
     */
    protected function checkRetardRecuperation($lot, $today)
    {
        // Si déjà récupéré, on ignore
        if ($lot->date_recuperation) return;

        $limite = $lot->date_disponible->copy()->addDays(5);

        // On vérifie si on est exactement à J+5
        if (!$today->isSameDay($limite)) return;

        // Vérifier si déjà envoyé aujourd'hui
        // $alreadySent = RetardNotification::where([
        //     'lot_copie_id' => $lot->id,
        //     'type' => 'recuperation',
        //     'sent_at' => $today
        // ])->exists();

        // if ($alreadySent) return;

        $enseignant = $lot->module->enseignant;
        $dateRemiseMax = $lot->date_disponible->copy()->addDays(14);

        // Envoi à l'enseignant uniquement
        $enseignant->notify(
            new RetardCopieNotification(
                'Rappel : Copies disponibles à la scolarité',
                "Les copies du module {$lot->module->nom} sont disponibles depuis 5 jours. Veuillez passer à la scolarité pour les récupérer afin de les corriger et renvoyer au plus tard le {$dateRemiseMax->format('d/m/Y')}.",
                'recuperation_rappel',
                [
                    'module' => $lot->module->nom,
                    'date_disponible' => $lot->date_disponible->format('d/m/Y'),
                    'date_remise_max' => $dateRemiseMax->format('d/m/Y'),
                    'jours_ecoules' => 5
                ]
            )
        );

        // Enregistrement anti-spam
        RetardNotification::create([
            'lot_copie_id' => $lot->id,
            'type' => 'recuperation',
            'sent_at' => $today,
        ]);
    }

    /**
     * Avertissement avant retard de remise
     * Si date_today = date_disponible + 10 jours ET date_remise = null
     */
    protected function checkAvertissementRemise($lot, $today)
    {
        // Si déjà remis, on ignore
        if ($lot->date_remise) return;

        $limite = $lot->date_disponible->copy()->addDays(10);

        // On vérifie si on est exactement à J+10
        if (!$today->isSameDay($limite)) return;

        // Vérifier si déjà envoyé aujourd'hui
        // $alreadySent = RetardNotification::where([
        //     'lot_copie_id' => $lot->id,
        //     'type' => 'avertissement_remise',
        //     'sent_at' => $today
        // ])->exists();

        // if ($alreadySent) return;

        $enseignant = $lot->module->enseignant;
        $dateRemiseMax = $lot->date_disponible->copy()->addDays(14);
        $joursRestants = 4; // 14 - 10 = 4 jours

        // Envoi à l'enseignant uniquement
        $enseignant->notify(
            new RetardCopieNotification(
                'Avertissement : Délai de remise des copies',
                "Vous pourriez être en retard ! Il vous reste {$joursRestants} jours pour renvoyer les copies du module {$lot->module->nom}. Date limite : {$dateRemiseMax->format('d/m/Y')}.",
                'avertissement_remise',
                [
                    'module' => $lot->module->nom,
                    'jours_restants' => $joursRestants,
                    'date_remise_max' => $dateRemiseMax->format('d/m/Y')
                ]
            )
        );

        // Enregistrement anti-spam
        // RetardNotification::create([
        //     'lot_copie_id' => $lot->id,
        //     'type' => 'avertissement_remise',
        //     'sent_at' => $today,
        // ]);
    }

    /**
     * Retard confirmé de remise des copies
     * Si date_today > date_disponible + 14 jours ET date_remise = null
     */
    protected function checkRetardRemise($lot, $today)
    {
        // Si déjà remis, on ignore
        if (!is_null($lot->date_remise)) {
            return;
        }

        $limite = $lot->date_disponible->copy()->addDays(14);

        // On vérifie si on a dépassé la limite
        if ($today->lte($limite)) return;

        // Vérifier si déjà envoyé aujourd'hui
        // $alreadySent = RetardNotification::where([
        //     'lot_copie_id' => $lot->id,
        //     'type' => 'retard_remise',
        //     'sent_at' => $today
        // ])->exists();

        // if ($alreadySent) return;

        $jours = $limite->diffInDays($today);
        $enseignant = $lot->module->enseignant;

        // Message pour l'enseignant
        $messageEnseignant = "Vous êtes en retard de {$jours} jour(s) pour la remise des copies du module {$lot->module->nom}. La date limite était le {$limite->format('d/m/Y')}. Veuillez contacter votre chef de département ou le directeur académique pour régulariser votre situation.";

        // Envoi à l'enseignant
        $enseignant->notify(
            new RetardCopieNotification(
                'URGENT : Retard de remise des copies',
                $messageEnseignant,
                'retard_remise_enseignant',
                [
                    'module' => $lot->module->nom,
                    'jours_retard' => $jours,
                    'date_limite' => $limite->format('d/m/Y')
                ]
            )
        );

        // Envoi aux DA de l'établissement
        $daUsers = User::where('type', 'DA')
            ->where('etablissement_id', $enseignant->etablissement_id)
            ->get();

        $messageDa = "L'enseignant {$enseignant->prenom_utilisateur} {$enseignant->nom_utilisateur} est en retard de {$jours} jour(s) pour la remise des copies du module {$lot->module->nom}. Date limite dépassée : {$limite->format('d/m/Y')}.";

        foreach ($daUsers as $da) {
            $da->notify(
                new RetardCopieNotification(
                    "Alerte : Enseignant en retard de remise",
                    $messageDa,
                    'retard_remise_da',
                    [
                        'enseignant_nom' => $enseignant->prenom_utilisateur . ' ' . $enseignant->nom_utilisateur,
                        'enseignant_email' => $enseignant->email,
                        'enseignant_phone' => $enseignant->full_phone ?? $enseignant->phone_number,
                        'module' => $lot->module->nom,
                        'jours_retard' => $jours,
                        'date_limite' => $limite->format('d/m/Y')
                    ]
                )
            );
        }

        // Anti-spam
        // RetardNotification::create([
        //     'lot_copie_id' => $lot->id,
        //     'type' => 'retard_remise',
        //     'sent_at' => $today,
        // ]);
    }
}