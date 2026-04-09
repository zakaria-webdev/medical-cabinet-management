<?php

namespace App\Notifications;

use App\Models\RendezVous;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

// [Houcine] Classe de notification pour les rappels de rendez-vous - Sprint 2
// Cette classe définit UNE notification spécifique : le rappel RDV J-1
// Laravel permet de créer autant de classes de notification que nécessaire
// Chaque classe hérite de Notification et définit :
//   - via()        → quel canal utiliser (database, mail, sms, etc.)
//   - toDatabase() → les données à stocker quand le canal est 'database'

class RdvReminderNotification extends Notification
{
    // Queueable = cette notification peut être mise en file d'attente (queue)
    // pour être envoyée en arrière-plan sans bloquer la requête HTTP
    // Ici on n'utilise pas de queue, mais c'est une bonne pratique de l'inclure
    use Queueable;

    // Le constructeur reçoit le RDV concerné
    // 'public RendezVous $rendezVous' = propriété publique créée automatiquement (PHP 8)
    // On en a besoin pour accéder aux données du RDV dans toDatabase()
    public function __construct(public RendezVous $rendezVous) {}

    // via() = définit les canaux de livraison de la notification
    // On retourne ['database'] → la notification sera stockée dans la table 'notifications'
    // Autres canaux possibles : 'mail', 'broadcast', 'vonage' (SMS)
    // On utilise 'database' car pas besoin de configurer un serveur mail
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    // toDatabase() = définit les données JSON stockées dans la colonne 'data'
    // de la table notifications
    // $notifiable = l'utilisateur qui reçoit la notification (User model)
    // On retourne un tableau associatif → automatiquement converti en JSON par Laravel
    public function toDatabase(object $notifiable): array
    {
        return [
            // ID du RDV pour pouvoir créer un lien vers ce RDV si besoin
            'rdv_id'    => $this->rendezVous->id,

            // Nom complet du patient (relation patient() du modèle RendezVous)
            // $this->rendezVous->patient accède au modèle Patient lié via patient_id
            'patient'   => $this->rendezVous->patient->nom
                           . ' ' . $this->rendezVous->patient->prenom,

            // Date formatée en français (d/m/Y) pour l'affichage dans la vue
            // date_rdv est casté en Carbon dans RendezVous.php donc ->format() fonctionne
            'date_rdv'  => $this->rendezVous->date_rdv->format('d/m/Y'),

            // Heure du RDV telle qu'elle est stockée en base (HH:MM:SS)
            'heure_rdv' => $this->rendezVous->heure_rdv,

            // Motif peut être null (nullable dans la migration) → affiché si présent
            'motif'     => $this->rendezVous->motif,

            // Message lisible affiché dans la cloche de notification
            'message'   => 'Rappel: RDV demain avec '
                           . $this->rendezVous->patient->nom
                           . ' ' . $this->rendezVous->patient->prenom,
        ];
    }
}