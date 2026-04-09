<?php

namespace App\Mail;

use App\Models\RendezVous;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

// [Houcine] Classe Mailable - Email de confirmation de RDV - Sprint 2
// Un Mailable = une classe qui représente UN type d'email dans Laravel
// Cette classe est envoyée automatiquement quand un RDV est créé (dans store())
// Elle reçoit l'objet RendezVous et le transmet à la vue Blade de l'email
//
// Fonctionnement :
//   1. RendezVousController@store() crée le RDV
//   2. Il instancie : new RendezVousConfirme($rendezVous)
//   3. Il envoie   : Mail::to($email)->send(new RendezVousConfirme($rendezVous))
//   4. Laravel appelle envelope() pour le sujet, content() pour la vue
//   5. L'email est intercepté par Mailtrap (en développement)

class RendezVousConfirme extends Mailable
{
    // Queueable = peut être mis en file d'attente pour envoi en arrière-plan
    // SerializesModels = sérialise proprement les modèles Eloquent si mis en queue
    use Queueable, SerializesModels;

    // Le constructeur reçoit le RDV et le stocke comme propriété publique
    // IMPORTANT : propriété 'public' = automatiquement accessible dans la vue Blade
    // Sans 'public', la vue ne peut pas accéder à $rendezVous
    public function __construct(public RendezVous $rendezVous) {}

    // envelope() = définit les métadonnées de l'email (sujet, expéditeur, etc.)
    // Le sujet apparaît dans la boîte mail du destinataire
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmation de votre Rendez-Vous — Cabinet Médical',
        );
    }

    // content() = définit quelle vue Blade utiliser pour le corps de l'email
    // 'emails.rendez-vous-confirme' → resources/views/emails/rendez-vous-confirme.blade.php
    public function content(): Content
    {
        return new Content(
            view: 'emails.rendez-vous-confirme',
        );
    }

    // attachments() = fichiers joints à l'email (pièces jointes)
    // Ici aucune pièce jointe nécessaire → tableau vide
    public function attachments(): array
    {
        return [];
    }
}