<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // كريينا User بالخانات اللي كاينين عندك بصح
        $user = User::factory()->create([
            'nom' => 'Admin',
            'prenom' => 'Test',
            'email' => 'admin@test.com',
            'role' => 'admin',
        ]);

        // نكريو 50 مريض
        Patient::factory(50)->create([
            'user_id' => $user->id,
        ]);
    }
}
