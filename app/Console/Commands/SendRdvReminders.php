<?php

namespace App\Console\Commands;

use App\Models\RendezVous;
use App\Models\User;
use App\Notifications\RdvReminderNotification;
use Illuminate\Console\Command;

// [Houcine] Commande Artisan personnalisée - Rappels RDV J-1 - Sprint 2
// Une commande Artisan = un script PHP exécutable via le terminal
// Syntaxe d'exécution : php artisan rdv:remind
// Cette commande cherche tous les RDV confirmés pour DEMAIN
// et envoie une notification database au médecin concerné + tous les secrétaires

class SendRdvReminders extends Command
{
    // $signature = le nom de la commande tel qu'on l'appelle dans le terminal
    // Format : 'groupe:action'
    // Exemple : php artisan rdv:remind
    protected $signature = 'rdv:remind';

    // $description = texte affiché quand on fait 'php artisan list'
    // Aide les développeurs à comprendre ce que fait la commande
    protected $description = 'Envoyer des rappels pour les RDV confirmés de demain';

    // handle() = méthode principale exécutée quand la commande est appelée
    // Équivalent du main() dans d'autres langages
    public function handle(): void
    {
        // On calcule la date de demain au format Y-m-d (format MySQL)
        // now() retourne un objet Carbon (bibliothèque de dates incluse dans Laravel)
        // addDay() ajoute 1 jour, toDateString() formate en '2026-04-10'
        $tomorrow = now()->addDay()->toDateString();

        // On récupère tous les RDV de demain avec statut 'confirmé'
        // with(['patient', 'medecin']) = eager loading pour éviter le problème N+1
        // Sans eager loading : Laravel ferait une requête SQL par RDV pour charger patient/médecin
        // Avec eager loading : 1 seule requête pour tous les patients + 1 pour tous les médecins
        $rdvs = RendezVous::with(['patient', 'medecin'])
            ->where('date_rdv', $tomorrow)
            ->where('statut', 'confirmé')
            ->get();

        // Si aucun RDV demain, on affiche un message et on arrête
        // $this->info() = affiche un message en vert dans le terminal
        if ($rdvs->isEmpty()) {
            $this->info('Aucun RDV confirmé pour demain.');
            return;
        }

        // Pour chaque RDV trouvé, on envoie les notifications
        foreach ($rdvs as $rdv) {

            // Notifier le médecin responsable du RDV
            // ->notify() est disponible grâce au trait Notifiable dans User.php
            // Laravel va automatiquement appeler toDatabase() et stocker dans notifications
            if ($rdv->medecin) {
                $rdv->medecin->notify(new RdvReminderNotification($rdv));
            }

            // Notifier TOUS les secrétaires du cabinet
            // Un secrétaire doit être au courant de tous les RDV du lendemain
            // User::where('role','secretaire') récupère tous les comptes secrétaires
            // ->each() itère sur chaque secrétaire et lui envoie la notification
            User::where('role', 'secretaire')->each(function (User $user) use ($rdv) {
                $user->notify(new RdvReminderNotification($rdv));
            });

            // Afficher un message de confirmation dans le terminal pour ce RDV
            $this->info("✓ Rappel envoyé — RDV #{$rdv->id} le {$rdv->date_rdv} à {$rdv->heure_rdv}");
        }

        // Résumé final après la boucle
        $this->info("Total : {$rdvs->count()} rappel(s) envoyé(s).");
    }
}