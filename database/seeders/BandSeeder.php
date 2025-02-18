<?php

namespace Database\Seeders;

use App\Models\Band;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Band::insert([
            ['name' => 'BOC'],
            ['name' => 'STAFF BOC'],
            ['name' => 'BOD-1'],
            ['name' => 'BOD-2'],
            ['name' => 'BOD-3'],
            ['name' => 'BOD-4'],
            ['name' => 'BOD-5'],
        ]);
    }
}
