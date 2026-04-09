<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// [Houcine] Migration - Création de la table notifications - Sprint 2
// Laravel utilise cette table pour stocker toutes les notifications
// de type 'database' (canal database dans via() de chaque classe Notification)
// Cette structure est le standard officiel Laravel - ne pas modifier les noms de colonnes
// car le système de notifications interne de Laravel s'attend exactement à cette structure

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {

            // UUID comme clé primaire (et non auto-increment integer)
            // Laravel génère automatiquement un UUID unique pour chaque notification
            // Avantage : les IDs ne sont pas devinables (sécurité)
            $table->uuid('id')->primary();

            // Nom complet de la classe Notification qui a créé cette entrée
            // Exemple : "App\Notifications\RdvReminderNotification"
            // Permet à Laravel de savoir quel type de notification c'est
            $table->string('type');

            // morphs() crée deux colonnes polymorphiques :
            //   - notifiable_type : le modèle concerné ex: "App\Models\User"
            //   - notifiable_id   : l'ID de cet utilisateur ex: 5
            // Cela permet d'envoyer des notifications à n'importe quel modèle
            // pas seulement User (extensible à Patient, Medecin, etc.)
            $table->morphs('notifiable');

            // Données JSON de la notification
            // Contient le tableau retourné par toDatabase() dans la classe Notification
            // Exemple stocké : {"rdv_id":3,"patient":"Alami Youssef","message":"Rappel..."}
            $table->text('data');

            // NULL = notification non lue, timestamp = date/heure de lecture
            // Utilisé pour distinguer les notifications lues des non-lues
            // dans la cloche de notifications (badge rouge)
            $table->timestamp('read_at')->nullable();

            // created_at et updated_at standards Laravel
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Supprime la table si on rollback cette migration
        // php artisan migrate:rollback
        Schema::dropIfExists('notifications');
    }
};