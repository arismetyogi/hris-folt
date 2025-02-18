<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jabatan::insert([
            ['name' => 'Komisaris'],
            ['name' => 'Direksi'],
            ['name' => 'Manager'],
            ['name' => 'Asman'],
            ['name' => 'Supervisor'],
            ['name' => 'Pelaksana'],
            ['name' => 'Staff BOC'],
        ]);
    }
}
