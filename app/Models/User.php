<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
// Authenticatable = donne au User les capacités login/logout/session
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // $fillable = liste blanche des colonnes acceptées via User::create([...])
    // SÉCURITÉ : si un hacker envoie 'role=admin' dans le formulaire
    // et que 'role' n'est PAS ici → Laravel l'ignore automatiquement
    protected $fillable = [
        'nom',       // ← était 'name', on corrige selon le diagramme de classes
        'prenom',    // ← nouveau champ
        'email',
        'password',
        'role',      // ← nouveau champ (admin/medecin/secretaire/patient)
    ];

    // $hidden = ces colonnes ne s'affichent JAMAIS dans les réponses JSON
    // même si tu fais $user->toArray() ou return $user en API
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // casts = conversions automatiques de types
    // 'hashed' → Laravel hashera automatiquement le password à l'écriture (Laravel 10+)
    // On a SUPPRIMÉ 'email_verified_at' car cette colonne n'existe plus dans la migration
    protected $casts = [
        'password' => 'hashed',
    ];

    // =============================================
    // RELATIONS ELOQUENT
    // =============================================

    // Un User (patient) a UN profil dans la table 'patients'
    // hasOne = la clé étrangère (user_id) est dans la table patients, pas ici
    // Donc User "possède" Patient → hasOne
    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    // Un médecin (User) a PLUSIEURS rendez-vous
    // 'medecin_id' = on précise la FK car elle ne s'appelle pas 'user_id'
    public function rendezVous()
    {
        return $this->hasMany(RendezVous::class, 'medecin_id');
    }

    // =============================================
    // HELPERS DE RÔLE
    // =============================================
    // Ces méthodes seront utilisées dans les vues et controllers
    // ex: @if(auth()->user()->isAdmin()) → afficher bouton supprimer
    // Amine va les utiliser aussi dans son middleware CheckRole

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isMedecin(): bool
    {
        return $this->role === 'medecin';
    }

    public function isPatient(): bool
    {
        return $this->role === 'patient';
    }

    public function isSecretaire(): bool
    {
        return $this->role === 'secretaire';
    }
}