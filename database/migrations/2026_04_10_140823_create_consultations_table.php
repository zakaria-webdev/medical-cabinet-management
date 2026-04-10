<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            // Zakaria : Liaison avec le système de RDV développé par Amine
            $table->foreignId('rdv_id')->constrained('rendez_vous')->onDelete('cascade');

            // Zakaria : Liaison avec mon travail du Sprint 1 (Dossier Médical)
            $table->foreignId('dossier_medical_id')->constrained('dossier_medicals')->onDelete('cascade');

            // Zakaria : Identification du médecin traitant (lié à la table users)
            $table->foreignId('medecin_id')->constrained('users')->onDelete('cascade');

            // Zakaria : Ajout des champs spécifiques à la consultation
            $table->text('compte_rendu');
            $table->date('date_consultation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
