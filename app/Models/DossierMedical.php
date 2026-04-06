<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DossierMedical extends Model
{
    use HasFactory;

    // تحديد اسم الجدول حيت لارافيل يقدر يقلب على dossiers_medicals
    protected $table = 'dossier_medicals';

    protected $fillable = [
        'patient_id',
        'groupe_sanguin',
        'allergies',
        'maladies_chroniques',
        'operations_chirurgicales',
        'traitement_en_cours'
    ];

    // العلاقة: الملف الطبي ينتمي لمريض
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
