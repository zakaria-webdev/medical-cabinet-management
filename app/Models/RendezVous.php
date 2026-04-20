<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RendezVous extends Model
{
    
    protected $table = 'rendez_vous';

    protected $fillable = [
        'patient_id', 'medecin_id',
        'date_rdv', 'heure_rdv',
        'statut', 'motif',
    ];

    protected $casts = [
        'date_rdv' => 'date',
    ];

    // RDV appartient à un patient
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    // RDV appartient à un médecin (User avec rôle médecin)
    public function medecin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'medecin_id');
    }
}