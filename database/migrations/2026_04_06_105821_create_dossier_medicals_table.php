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
        Schema::create('dossier_medicals', function (Blueprint $table) {
            $table->id();

            // الربط الصحيح مع جدول المرضى
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');

            // المعلومات الطبية (درناهم nullable باش يقدر يخليهم خاويين إلا ماكانش مريض)
            $table->string('groupe_sanguin')->nullable(); // فصيلة الدم (O+, A-, ...)
            $table->text('allergies')->nullable(); // الحساسية
            $table->text('maladies_chroniques')->nullable(); // الأمراض السابقة / المزمنة
            $table->text('operations_chirurgicales')->nullable(); // العمليات الجراحية السابقة
            $table->text('traitement_en_cours')->nullable(); // الأدوية اللي كياخد دابا

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dossier_medicals');
    }
};
