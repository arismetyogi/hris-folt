<?php

namespace Database\Seeders;

use App\Models\GradeEselon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradeEselonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GradeEselon::insert([
            ['grade' => 17, 'eselon' => 'II a'],
            ['grade' => 16, 'eselon' => 'II b'],
            ['grade' => 15, 'eselon' => 'II c'],
            ['grade' => 14, 'eselon' => 'III a'],
            ['grade' => 13, 'eselon' => 'III a'],
            ['grade' => 12, 'eselon' => 'III b'],
            ['grade' => 11, 'eselon' => 'III b'],
            ['grade' => 10, 'eselon' => 'IV a'],
            ['grade' => 9, 'eselon' => 'IV a'],
            ['grade' => 8, 'eselon' => 'IV b'],
            ['grade' => 7, 'eselon' => 'IV b'],
            ['grade' => 6, 'eselon' => 'Non Eselon'],
            ['grade' => 5, 'eselon' => 'Non Eselon'],
            ['grade' => 4, 'eselon' => 'Non Eselon'],
            ['grade' => 3, 'eselon' => 'Non Eselon'],
        ]);
    }
}
