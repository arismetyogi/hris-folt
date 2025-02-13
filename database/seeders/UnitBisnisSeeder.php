<?php

namespace Database\Seeders;

use App\Models\UnitBisnis;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitBisnisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UnitBisnis::insert([
            ['id' => 1, 'code' => 3168, 'name' => 'UB Ambon', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 2, 'code' => 3102, 'name' => 'UB Balikpapan', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 3, 'code' => 3101, 'name' => 'UB Banda Aceh', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 4, 'code' => 3103, 'name' => 'UB Bandung', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 5, 'code' => 3169, 'name' => 'UB Bangka Belitung', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 6, 'code' => 3107, 'name' => 'UB Banjarmasin', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 7, 'code' => 3108, 'name' => 'UB Batam', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 8, 'code' => 3110, 'name' => 'UB Bekasi', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 9, 'code' => 3112, 'name' => 'UB Bogor', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 10, 'code' => 3148, 'name' => 'UB Cilegon', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 11, 'code' => 3114, 'name' => 'UB Cirebon', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 12, 'code' => 3116, 'name' => 'UB Denpasar', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 13, 'code' => 3113, 'name' => 'UB Depok', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 14, 'code' => 3126, 'name' => 'UB Gorontalo', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 15, 'code' => 3144, 'name' => 'UB Gresik', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 16, 'code' => 3133, 'name' => 'UB Jambi', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 17, 'code' => 3117, 'name' => 'UB Jaya I', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 18, 'code' => 3118, 'name' => 'UB Jaya II', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 19, 'code' => 3119, 'name' => 'UB Jayapura', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 20, 'code' => 3120, 'name' => 'UB Jember', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 21, 'code' => 3111, 'name' => 'UB Karawang', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 22, 'code' => 3121, 'name' => 'UB Kendari', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 23, 'code' => 3122, 'name' => 'UB Kupang', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 24, 'code' => 3123, 'name' => 'UB Lampung', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 25, 'code' => 3171, 'name' => 'UB Madura', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 26, 'code' => 3124, 'name' => 'UB Makassar', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 27, 'code' => 3125, 'name' => 'UB Malang', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 28, 'code' => 3127, 'name' => 'UB Manado', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 29, 'code' => 3129, 'name' => 'UB Mataram', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 30, 'code' => 3130, 'name' => 'UB Medan', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 31, 'code' => 3115, 'name' => 'UB Nusadua', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 32, 'code' => 3131, 'name' => 'UB Padang', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 33, 'code' => 3132, 'name' => 'UB Palangkaraya', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 34, 'code' => 3134, 'name' => 'UB Palembang', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 35, 'code' => 3135, 'name' => 'UB Palu', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 36, 'code' => 3140, 'name' => 'UB Pekalongan', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 37, 'code' => 3136, 'name' => 'UB Pekanbaru', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 38, 'code' => 3137, 'name' => 'UB Pontianak', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 39, 'code' => 3170, 'name' => 'UB Purwokerto', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 40, 'code' => 3139, 'name' => 'UB Samarinda', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 41, 'code' => 3141, 'name' => 'UB Semarang', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 42, 'code' => 3145, 'name' => 'UB Sidoarjo', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 43, 'code' => 3143, 'name' => 'UB Sorong', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 44, 'code' => 3147, 'name' => 'UB Sukabumi', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 45, 'code' => 3146, 'name' => 'UB Surabaya', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 46, 'code' => 3142, 'name' => 'UB Surakarta', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 47, 'code' => 3149, 'name' => 'UB Tangerang', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 48, 'code' => 3109, 'name' => 'UB Tanjung Pinang', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 49, 'code' => 3105, 'name' => 'UB Tasikmalaya', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 50, 'code' => 3128, 'name' => 'UB Ternate', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 51, 'code' => 3150, 'name' => 'UB Yogya', 'entity_code' => 3000, 'entity_name' => 'KFA'],
            ['id' => 52, 'code' => 3000, 'name' => 'KP KFA', 'entity_code' => 3000, 'entity_name' => 'KFA'],
        ]);
    }
}
