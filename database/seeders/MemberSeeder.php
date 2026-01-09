<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $destinationPath = 'members';

        Storage::disk('public')->deleteDirectory($destinationPath);
        Storage::disk('public')->makeDirectory($destinationPath);

        $dataToInsert = [];

        $metaforsaMembers = [
            ['name' => 'Naya Fitri Nazwa Nur Haliza', 'img' => 'naya.png', 'nim' => '20231310072', 'pos' => 'Ketua Himpunan', 'dept' => 1],
            ['name' => 'Mochamad Dzaki Ramadhan', 'img' => 'dzaki.png', 'nim' => '20241310012', 'pos' => 'Wakil Ketua Himpunan', 'dept' => 1],
            ['name' => 'Tania Cahyani P', 'img' => 'tania-mf.png', 'nim' => '20231310098', 'pos' => 'Sekretaris', 'dept' => 1],
            ['name' => 'Gita Nurcahyani Aggriana', 'img' => 'gita.png', 'nim' => '20231310006', 'pos' => 'Kesekretariatan', 'dept' => 1],
            ['name' => 'Melani Marnia Putri', 'img' => 'melani.png', 'nim' => '20241310042', 'pos' => 'Bendahara', 'dept' => 1],
            ['name' => 'Siti Fatimah Assyadia Rohani', 'img' => 'asya.png', 'nim' => '20241310019', 'pos' => 'Bendahara 2', 'dept' => 1],
        ];
        foreach ($metaforsaMembers as $m) {
            $dataToInsert[] = $this->prepareData($m, 1, $destinationPath);
        }

        $digiswaraMembers = [
            ['name' => 'Chriss Hendry Choong', 'img' => 'acong.png', 'nim' => '20221310011', 'pos' => 'Ketua Himpunan', 'dept' => 1],
            ['name' => 'Muhammad Ikhsan Kamil', 'img' => 'ikhsan.png', 'nim' => '20221310012', 'pos' => 'Wakil Ketua Himpunan', 'dept' => 1],
            ['name' => 'Tania Cahyani Putri', 'img' => 'tania.png', 'nim' => '20221310013', 'pos' => 'Sekretaris', 'dept' => 1],
            ['name' => 'Siti Maisyaroh', 'img' => 'simai.png', 'nim' => '20221310014', 'pos' => 'Bendahara', 'dept' => 1],
        ];
        foreach ($digiswaraMembers as $m) {
            $dataToInsert[] = $this->prepareData($m, 2, $destinationPath);
        }

        $raksabhinayaStructure = [
            ['pos' => 'Ketua Himpunan', 'dept' => 1],
            ['pos' => 'Wakil Ketua Himpunan', 'dept' => 1],
            ['pos' => 'Sekretaris', 'dept' => 1],
            ['pos' => 'Bendahara', 'dept' => 1],
            ['pos' => 'Kepala Departemen Kaderisasi', 'dept' => 2],
            ['pos' => 'Staff Departemen Kaderisasi', 'dept' => 2],
        ];
        foreach ($raksabhinayaStructure as $s) {
            $fakeMember = [
                'name' => $faker->name,
                'img'  => 'dummy.png',
                'nim'  => $faker->unique()->numerify('202213100##'),
                'pos'  => $s['pos'],
                'dept' => $s['dept']
            ];
            $dataToInsert[] = $this->prepareData($fakeMember, 3, $destinationPath);
        }

        DB::table('members')->insert($dataToInsert);
    }

    private function prepareData($member, $periodId, $destinationPath)
    {
        $extension = pathinfo($member['img'], PATHINFO_EXTENSION) ?: 'png';
        $newFileName = Str::slug($member['name']) . '.' . $extension;
        $newFilePath = $destinationPath . '/' . $newFileName;

        $sourceFilePath = database_path('seeders/images/' . $member['img']);

        if (file_exists($sourceFilePath)) {
            Storage::disk('public')->put($newFilePath, file_get_contents($sourceFilePath));
        }

        return [
            'name'                   => $member['name'],
            'student_id_number'      => $member['nim'],
            'image'                  => $newFilePath,
            'position'               => $member['pos'],
            'organization_period_id' => $periodId,
            'department_id'          => $member['dept'],
            'created_at'             => now(),
            'updated_at'             => now(),
        ];
    }
}
