<?php

namespace Database\Seeders;

use App\Models\EmployeeLevel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmployeeLevel::insert([
            ['name' => 'D1'],
            ['name' => 'D2'],
            ['name' => 'D3'],
            ['name' => 'C1'],
            ['name' => 'C2'],
            ['name' => 'C3'],
            ['name' => 'C4'],
            ['name' => 'B1'],
            ['name' => 'B2'],
            ['name' => 'B3'],
            ['name' => 'B4'],
            ['name' => 'A1'],
            ['name' => 'A2'],
            ['name' => 'A3'],
            ['name' => 'A4'],
        ]);
    }
}
