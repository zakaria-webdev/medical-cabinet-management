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
        Schema::create('ordonnances', function (Blueprint $table) {
            $table->id();
            // Zakaria : J'associe strictement cette ordonnance à la consultation que je viens de créer
            $table->foreignId('consultation_id')->constrained()->onDelete('cascade');

            // Zakaria : Stockage des détails des médicaments et des notes pour le patient
            $table->text('medicaments_details');
            $table->text('notes_utilisation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordonnances');
    }
};
