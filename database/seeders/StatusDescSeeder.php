<?php

namespace Database\Seeders;

use App\Models\StatusDesc;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusDescSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StatusDesc::insert([
            ['name' => 'Pharmacy Manager'],
            ['name' => 'Apoteker Pendamping'],
            ['name' => 'TTK'],
            ['name' => 'Staff BM'],
            ['name' => 'Kantor Pusat'],
        ]);
    }
}
