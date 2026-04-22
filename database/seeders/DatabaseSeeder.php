<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // ضروري تزيد هاد السطر الفوق

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. حساب الأدمين (تم توحيد المودپاس باش يخدم مع زر التجريب)
        $admin = User::updateOrCreate(
            ['email' => 'admin@test.com'],
            [
                'nom' => 'Admin',
                'prenom' => 'Test',
                'role' => 'admin',
                'password' => Hash::make('12345678'),
            ]
        );

        // 2. حسابات الأطباء (5 أطباء بأسماء واقعية)
        $medecins = [
            ['prenom' => 'Ahmed', 'nom' => 'Alaoui'],
            ['prenom' => 'Sara', 'nom' => 'El Mansouri'],
            ['prenom' => 'Yassine', 'nom' => 'Tazi'],
            ['prenom' => 'Karima', 'nom' => 'Bennani'],
            ['prenom' => 'Driss', 'nom' => 'Roumani'],
        ];

        foreach ($medecins as $index => $data) {
            User::updateOrCreate(
                ['email' => "medecin" . ($index + 1) . "@test.com"],
                [
                    'prenom' => $data['prenom'],
                    'nom' => $data['nom'],
                    'role' => 'medecin',
                    'password' => Hash::make('12345678'),
                ]
            );
        }

        // 3. [الجديد] حساب الكاتبة (Secrétaire)
        User::updateOrCreate(
            ['email' => 'secretaire@test.com'],
            [
                'nom' => 'Secrétaire',
                'prenom' => 'Test',
                'role' => 'secretaire',
                'password' => Hash::make('12345678'),
            ]
        );

        // 4. [الجديد] حساب المريض ديال التجريب (Patient Test)
        $patientUser = User::updateOrCreate(
            ['email' => 'patient@test.com'],
            [
                'nom' => 'Patient',
                'prenom' => 'Test',
                'role' => 'patient',
                'password' => Hash::make('12345678'),
            ]
        );

        // نكرييو بروفايل ديال هاد المريض فـ جدول patients (إيلا ماكانش عندو)
        if (!Patient::where('user_id', $patientUser->id)->exists()) {
            Patient::factory()->create([
                'user_id' => $patientUser->id,
            ]);
        }

        // 5. نكرييو 50 مريض عشوائي للتجريب (مرتبطين بالأدمين كيفما درتي)
        if (Patient::count() <= 1) { // درنا <= 1 حيت ديجا كريينا واحد الفوق
            Patient::factory(50)->create([
                'user_id' => $admin->id,
            ]);
        }
    }
}
