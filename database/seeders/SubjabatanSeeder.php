<?php

namespace Database\Seeders;

use App\Models\Subjabatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subjabatan::insert([
            ['name' => 'Manager KP'],
            ['name' => 'BM'],
            ['name' => 'Asman KP'],
            ['name' => 'PhM'],
            ['name' => 'TTK'],
            ['name' => 'Supervisor KP'],
            ['name' => 'KTU'],
            ['name' => 'Pelaksana KP'],
            ['name' => 'Staff BM'],
            ['name' => 'Aping'],
        ]);
    }
}
