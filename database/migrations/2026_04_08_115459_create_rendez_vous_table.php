<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rendez_vous', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('medecin_id')->constrained('users')->onDelete('cascade');
            $table->date('date_rdv');
            $table->time('heure_rdv');
            $table->enum('statut', ['en_attente','confirmé','annulé','terminé'])->default('en_attente');
            $table->text('motif')->nullable();
            $table->unique(['medecin_id','date_rdv','heure_rdv']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rendez_vous');
    }
};
