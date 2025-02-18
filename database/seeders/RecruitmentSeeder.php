<?php

namespace Database\Seeders;

use App\Models\Recruitment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecruitmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Recruitment::insert([
            ['name' => 'Pembukaan Apotek Baru'],
            ['name' => 'Pengganti Pegawai Resign'],
            ['name' => 'Pengganti Pegawai Pensiun'],
        ]);
    }
}
