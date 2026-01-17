<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Member;
use App\Models\Pengurus;
use App\Models\Angkatan;
use App\Models\Bidang;
use App\Models\PeriodeKepengurusan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserMemberSeeder extends Seeder
{
    public function run(): void
    {
        $gen2024 = Angkatan::where('year', '2024')->first();

        $metaforsaPeriod = PeriodeKepengurusan::where('cabinet_name', 'LIKE', '%MetaForsa%')->first();
        $digiswaraPeriod = PeriodeKepengurusan::where('cabinet_name', 'LIKE', '%Digiswara%')->first();
        $raksabhinayaPeriod = PeriodeKepengurusan::where('cabinet_name', 'LIKE', '%Raksabhinaya%')->first();

        $bidangList = Bidang::all();

        $cabinets = [
            ['period' => $metaforsaPeriod, 'data' => $this->getMetaforsaData()],
            ['period' => $digiswaraPeriod, 'data' => $this->getDigiswaraData()],
            ['period' => $raksabhinayaPeriod, 'data' => $this->getRaksabhinayaData()],
        ];

        foreach ($cabinets as $cabinet) {
            $period = $cabinet['period'];

            if (!$period) continue;

            foreach ($cabinet['data'] as $data) {
                $firstName = Str::lower(explode(' ', trim($data['name']))[0]);
                $email = $firstName . '@hmif.com';

                $user = User::firstOrCreate(
                    ['email' => $email],
                    [
                        'password' => Hash::make('password'),
                        'no_hp' => '08' . fake()->numerify('##########'),
                    ]
                );
                $user->assignRole('pengurus');

                $member = Member::updateOrCreate(
                    ['npm' => $data['nim']],
                    [
                        'user_id' => $user->id,
                        'department_id' => $data['dept_id'],
                        'generation_id' => $gen2024->id,
                        'full_name' => $data['name'],
                        'is_active' => true,
                    ]
                );

                $level = $this->determineLevel($data['pos']);
                $bidangId = ($level === 3) ? $bidangList->random()->id : null;

                $pengurus = Pengurus::updateOrCreate(
                    ['member_id' => $member->id, 'period_id' => $period->id],
                    [
                        'department_id' => $data['dept_id'],
                        'bidang_id' => $bidangId,
                        'position' => $data['pos'],
                        'hierarchy_level' => $level,
                    ]
                );

                if (!empty($data['img'])) {
                    $imagePath = database_path('seeders/images/' . $data['img']);

                    if (file_exists($imagePath) && !$pengurus->hasMedia('foto_pengurus')) {
                        $pengurus->addMedia($imagePath)
                            ->preservingOriginal()
                            ->toMediaCollection('foto_pengurus');
                    }
                }
            }
        }
    }

    private function determineLevel($pos)
    {
        if (Str::contains($pos, ['Ketua', 'Wakil', 'Sekretaris', 'Bendahara', 'Kesekretariatan'])) return 1;
        if (Str::contains($pos, ['Kepala', 'Koordinator'])) return 2;
        return 3;
    }

    private function getMetaforsaData()
    {
        return [
            ['name' => 'Naya Fitri Nazwa Nur Haliza', 'img' => 'naya.png', 'nim' => '20231310072', 'pos' => 'Ketua Himpunan', 'dept_id' => 1],
            ['name' => 'Mochamad Dzaki Ramadhan', 'img' => 'dzaki.png', 'nim' => '20241310012', 'pos' => 'Wakil Ketua Himpunan', 'dept_id' => 1],
            ['name' => 'Tania Cahyani P', 'img' => 'tania-mf.png', 'nim' => '20231310098', 'pos' => 'Sekretaris', 'dept_id' => 1],
            ['name' => 'Gita Nurcahyani Aggriana', 'img' => 'gita.png', 'nim' => '20231310006', 'pos' => 'Kesekretariatan', 'dept_id' => 1],
            ['name' => 'Melani Marnia Putri', 'img' => 'melani.png', 'nim' => '20241310042', 'pos' => 'Bendahara', 'dept_id' => 1],
            ['name' => 'Siti Fatimah Assyadia Rohani', 'img' => 'asya.png', 'nim' => '20241310019', 'pos' => 'Bendahara 2', 'dept_id' => 1],
            ['name' => 'Haniep Fathan Riziq', 'img' => 'haniep.png', 'nim' => '20241310011', 'pos' => 'Kepala Departemen Riset Dan Teknologi', 'dept_id' => 2],
            ['name' => 'Reyfasha Fadlan Azizan', 'img' => 'reyfasha.png', 'nim' => '20241310047', 'pos' => 'Kepala Departemen Pengembangan Sumber Daya Manusia', 'dept_id' => 2],
            ['name' => 'Maulana Yusuf', 'img' => 'cupe.png', 'nim' => '20231310008', 'pos' => 'Kepala Departemen Media dan Informasi', 'dept_id' => 2],
        ];
    }

    private function getDigiswaraData()
    {
        return [
            ['name' => 'Chriss Hendry Choong', 'img' => 'acong.png', 'nim' => '20221310011', 'pos' => 'Ketua Himpunan', 'dept_id' => 1],
            ['name' => 'Muhammad Ikhsan Kamil', 'img' => 'ikhsan.png', 'nim' => '20221310012', 'pos' => 'Wakil Ketua Himpunan', 'dept_id' => 1],
            ['name' => 'Tania Cahyani Putri', 'img' => 'tania.png', 'nim' => '20221310013', 'pos' => 'Sekretaris', 'dept_id' => 1],
            ['name' => 'Raka Zilva Inggia', 'img' => 'raka.png', 'nim' => '20221310010', 'pos' => 'Kesekretariatan', 'dept_id' => 1],
            ['name' => 'Siti Maisyaroh', 'img' => 'simai.png', 'nim' => '20221310014', 'pos' => 'Bendahara', 'dept_id' => 1],
            ['name' => 'Departemen RISTEK', 'img' => 'ristek-dw.png', 'nim' => '20221310001', 'pos' => 'Kepala Departemen Riset Dan Teknologi', 'dept_id' => 2],
            ['name' => 'Departemen PSDM', 'img' => 'psdm-dw.png', 'nim' => '20221310002', 'pos' => 'Kepala Departemen Pengembangan Sumber Daya Manusia', 'dept_id' => 2],
            ['name' => 'Departemen MEDFO', 'img' => 'kominfo-dw.png', 'nim' => '20221310003', 'pos' => 'Kepala Departemen Media Dan Informasi', 'dept_id' => 2],
        ];
    }

    private function getRaksabhinayaData()
    {
        return [
            ['name' => 'Raafi Syarahil Azhar', 'img' => null, 'nim' => '20221310021', 'pos' => 'Ketua Himpunan', 'dept_id' => 1],
            ['name' => 'Saripah', 'img' => null, 'nim' => '20221310022', 'pos' => 'Sekretaris', 'dept_id' => 1],
            ['name' => 'Putri', 'img' => null, 'nim' => '20221310023', 'pos' => 'Sekretaris', 'dept_id' => 1],
            ['name' => 'Aliya', 'img' => null, 'nim' => '20221310024', 'pos' => 'Bendahara 1', 'dept_id' => 1],
            ['name' => 'Salsa', 'img' => null, 'nim' => '20221310025', 'pos' => 'Bendahara 2', 'dept_id' => 1],
            ['name' => 'Leo', 'img' => null, 'nim' => '20221310026', 'pos' => 'Koordinator Pendidikan', 'dept_id' => 2],
            ['name' => 'Farid', 'img' => null, 'nim' => '20221310027', 'pos' => 'Koordinator PSDM', 'dept_id' => 2],
            ['name' => 'Zaki', 'img' => null, 'nim' => '20221310028', 'pos' => 'Koordinator Humas', 'dept_id' => 2],
        ];
    }
}
