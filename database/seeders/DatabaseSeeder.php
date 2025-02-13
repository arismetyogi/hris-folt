<?php

namespace Database\Seeders;

use App\Enums\Roles;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionsSeeder::class,
//            ProvinceSeeder::class,
//            ZipSeeder::class,
//            BankSeeder::class,
//
//            BandSeeder::class,
//            StatusDescSeeder::class,
//            GradeEselonSeeder::class,
//            RecruitmentSeeder::class,
//            EmployeeLevelSeeder::class,
//            EmployeeStatusSeeder::class,
//            AreaSeeder::class,
//            JabatanSeeder::class,
//            SubjabatanSeeder::class,
//
//            UnitBisnisSeeder::class,
//            ApotekSeeder::class,
        ]);

        User::factory(10)->state(fn() => ['created_at' => Carbon::now()->subMinute(0, 59)])->create();

        User::factory()->create([
            'name' => 'Super Admin',
            'username' => 'suadmin',
            'email' => 'suadmin@admin.com',
            'branch_id' => 52,
        ])->assignRole(Roles::SuperAdmin);

        User::factory()->create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@admin.com',
        ])->assignRole(Roles::Admin);

        User::factory(26)->unverified()->create();
    }
}
