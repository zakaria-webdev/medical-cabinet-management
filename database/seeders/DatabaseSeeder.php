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
        // كنستعملو updateOrCreate باش إيلا كان موجود يبدلو، وإيلا ماكانش يكريه
        $user = User::updateOrCreate(
            ['email' => 'admin@test.com'], // كنقلبو بهاد الإيميل
            [
                'nom' => 'Admin',
                'prenom' => 'Test',
                'role' => 'admin',
                'password' => Hash::make('12345678'), // دابا حددنا المودپاس بزز
            ]
        );

        // نكريو المرضى غير إيلا كانت الداتابيز خاوية (باش مايتزادوش بزاف فكل مرة)
        if (Patient::count() == 0) {
            Patient::factory(50)->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
