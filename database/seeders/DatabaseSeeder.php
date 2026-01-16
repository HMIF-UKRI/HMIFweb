<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class, // Roles & Permissions dulu
            MasterDataSeeder::class,     // Dept, Bidang, Angkatan, Categories
            PeriodSeeder::class,         // Periode Kepengurusan
            UserMemberSeeder::class,     // Users, Members, Pengurus
        ]);
    }
}
