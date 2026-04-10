<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    // Zakaria : Autorisation de l'assignation de masse pour ces champs précis (Corrigé !)
    protected $fillable = [
        'rdv_id',
        'dossier_medical_id',
        'medecin_id',
        'compte_rendu',
        'date_consultation'
    ];

    // Zakaria : Relation => Une consultation appartient à un dossier médical
    public function dossierMedical()
    {
        return $this->belongsTo(DossierMedical::class);
    }

    // Zakaria : Relation => Une consultation est liée à un seul rendez-vous
    public function rendezVous()
    {
        return $this->belongsTo(RendezVous::class, 'rdv_id');
    }

    // Zakaria : Relation => Une consultation génère une seule ordonnance
    public function ordonnance()
    {
        return $this->hasOne(Ordonnance::class);
    }

    // Zakaria : Relation => Lien vers le médecin (table User)
    public function medecin()
    {
        return $this->belongsTo(User::class, 'medecin_id');
    }
}
