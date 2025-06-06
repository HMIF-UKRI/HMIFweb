<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $destinationPath = 'members';

        Storage::disk('public')->deleteDirectory($destinationPath);
        Storage::disk('public')->makeDirectory($destinationPath);

        $membersData = [
            [
                'name' => 'Chriss Hendry Choong',
                'image' => 'acong.png',
                'student_id_number' => '20221310011',
                'position' => 'Ketua Himpunan',
                'organization_period_id' => 1,
                'department_id' => 1,
            ],
            [
                'name' => 'Muhammad Ikhsan Kamil',
                'image' => 'ikhsan.png',
                'student_id_number' => '20221310012',
                'position' => 'Wakil Ketua Himpunan',
                'organization_period_id' => 1,
                'department_id' => 1,
            ],
            [
                'name' => 'Tania Cahyani Putri',
                'image' => 'tania.png',
                'student_id_number' => '20221310013',
                'position' => 'Sekretaris',
                'organization_period_id' => 1,
                'department_id' => 1,
            ],
            [
                'name' => 'Siti Maisyaroh',
                'image' => 'simai.png',
                'student_id_number' => '20221310014',
                'position' => 'Bendahara',
                'organization_period_id' => 1,
                'department_id' => 1,
            ]
        ];

        $dataToInsert = [];

        foreach ($membersData as $member) {
            $sourceFilePath = database_path('seeders/images/' . $member['image']);

            // Buat nama file baru yang lebih unik untuk menghindari konflik
            $newFileName = Str::slug($member['name']) . '.' . pathinfo($member['image'], PATHINFO_EXTENSION);
            $newFilePath = $destinationPath . '/' . $newFileName;

            // Salin file dari source ke storage
            if (file_exists($sourceFilePath)) {
                Storage::disk('public')->put($newFilePath, file_get_contents($sourceFilePath));
            }

            $dataToInsert[] = [
                'name' => $member['name'],
                'student_id_number' => $member['student_id_number'],
                'image' => $newFilePath,
                'position' => $member['position'],
                'organization_period_id' => $member['organization_period_id'],
                'department_id' => $member['department_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('members')->insert($dataToInsert);
    }
}
