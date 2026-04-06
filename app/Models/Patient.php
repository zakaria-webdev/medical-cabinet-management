<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    // هادي هي اللي كانت ناقصة ودارت المشكل!
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nom',
        'prenom',
        'cin',
        'telephone',
        'date_naissance',
        'sexe',
        'adresse'
    ];

    // هادي هي الدالة اللي خاصك تزيد دابا (علاقة One-to-One)
    public function dossierMedical()
    {
        return $this->hasOne(DossierMedical::class);
    }
}
