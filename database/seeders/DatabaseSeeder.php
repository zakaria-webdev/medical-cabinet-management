<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient; // ضروري تزيد هاد السطر الفوق

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // هاد السطر كيكريي 50 مريض
        Patient::factory(50)->create();
    }
}
