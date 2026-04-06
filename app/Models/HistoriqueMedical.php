<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriqueMedical extends Model
{
    protected $table = 'historiques_medicaux';

    protected $fillable = [
        'patient_id', 'groupe_sanguin', 'maladies_chroniques',
        'allergies', 'operations_precedentes', 'traitements_en_cours'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
