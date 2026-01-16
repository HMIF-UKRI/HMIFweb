<?php

namespace Database\Seeders;

use App\Models\Angkatan;
use App\Models\Departemen;
use App\Models\Member;
use App\Models\Pengurus;
use App\Models\PeriodeKepengurusan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserMemberSeeder extends Seeder
{
    public function run(): void
    {
        $dept = Departemen::first();
        $gen = Angkatan::first();
        $period = PeriodeKepengurusan::first();

        $adminUser = User::create([
            'email' => 'admin@organisasi.com',
            'password' => Hash::make('password'),
            'no_hp' => '08123456789',
        ]);

        $adminUser->assignRole('super-admin');

        $adminMember = Member::create([
            'user_id' => $adminUser->id,
            'department_id' => $dept->id,
            'generation_id' => $gen->id,
            'full_name' => 'Administrator Utama',
            'npm' => '20240001',
            'is_active' => true,
        ]);

        $adminMember->addMediaFromUrl('https://i.pravatar.cc/300?u=admin')
            ->toMediaCollection('avatars');

        // Jadikan Pengurus (Kepala Departemen)
        Pengurus::create([
            'member_id' => $adminMember->id,
            'period_id' => $period->id,
            'department_id' => $dept->id,
            'bidang_id' => null,
            'hierarchy_level' => 1,
            'position' => 'Kepala Departemen',
        ]);

        User::factory(10)->create()->each(function ($user) use ($dept, $gen) {
            $user->assignRole('anggota');

            $member = Member::create([
                'user_id' => $user->id,
                'department_id' => $dept->id,
                'generation_id' => $gen->id,
                'full_name' => fake()->name(),
                'npm' => fake()->unique()->numerify('2024####'),
                'is_active' => true,
            ]);

            $member->addMediaFromUrl('https://i.pravatar.cc/300?u=' . $user->email)
                ->toMediaCollection('avatars');
        });
    }
}
