<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordonnance extends Model
{
    use HasFactory;

    // Zakaria : Sécurisation des champs pour l'ordonnance (Corrigé !)
    protected $fillable = [
        'consultation_id',
        'medicaments_details',
        'notes_utilisation'
    ];

    // Zakaria : Relation Inverse => L'ordonnance appartient à une consultation spécifique
    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }
} 
