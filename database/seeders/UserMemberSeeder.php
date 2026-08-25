<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Member;
use App\Models\Pengurus;
use App\Models\Angkatan;
use App\Models\Bidang;
use App\Models\Departemen;
use App\Models\PeriodeKepengurusan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserMemberSeeder extends Seeder
{
    public function run(): void
    {
        $generations = Angkatan::all()->keyBy('year');
        $departments = Departemen::all()->keyBy('id');
        $bidangs     = Bidang::all();

        $metaforsaPeriod   = PeriodeKepengurusan::where('cabinet_name', 'LIKE', '%MetaForsa%')->first();
        $digiswaraPeriod   = PeriodeKepengurusan::where('cabinet_name', 'LIKE', '%Digiswara%')->first();
        $raksabhinayaPeriod = PeriodeKepengurusan::where('cabinet_name', 'LIKE', '%Raksabhinaya%')->first();

        // 1. Super Admin
        $superAdmin = User::updateOrCreate(
            ['email' => 'superadmin@hmif.com'],
            [
                'password' => Hash::make('password'),
                'no_hp'    => '081223344556',
            ]
        );
        $superAdmin->syncRoles(['super-admin']);

        $gen2023 = $generations->get('2023') ?? $generations->first();
        Member::updateOrCreate(
            ['npm' => '20231310001'],
            [
                'user_id'       => $superAdmin->id,
                'generation_id' => $gen2023->id,
                'department_id' => 1,
                'full_name'     => 'Super Administrator HMIF',
                'is_active'     => true,
                'instagram_url' => 'https://instagram.com/hmif.ukri',
                'linkedin_url'  => 'https://linkedin.com/company/hmif-ukri',
            ]
        );

        // 2. Data Pengurus Setiap Kabinet
        $cabinets = [
            ['period' => $metaforsaPeriod, 'data' => $this->getMetaforsaData()],
            ['period' => $digiswaraPeriod, 'data' => $this->getDigiswaraData()],
            ['period' => $raksabhinayaPeriod, 'data' => $this->getRaksabhinayaData()],
        ];

        foreach ($cabinets as $cabinet) {
            $period = $cabinet['period'];
            if (!$period) continue;

            foreach ($cabinet['data'] as $data) {
                $user = User::updateOrCreate(
                    ['email' => $data['email']],
                    [
                        'password' => Hash::make('password'),
                        'no_hp'    => $data['phone'],
                    ]
                );

                // Assign role
                if (!$user->hasRole('pengurus')) {
                    $user->assignRole('pengurus');
                }

                // Tentukan Angkatan berdasarkan NPM (misal 20231310072 -> 2023)
                $npmYear = substr($data['nim'], 0, 4);
                $gen = $generations->get($npmYear) ?? $gen2023;

                $member = Member::updateOrCreate(
                    ['npm' => $data['nim']],
                    [
                        'user_id'       => $user->id,
                        'department_id' => $data['dept_id'],
                        'generation_id' => $gen->id,
                        'full_name'     => $data['name'],
                        'is_active'     => true,
                        'instagram_url' => $data['instagram'] ?? ('https://instagram.com/' . Str::slug($data['name'], '')),
                        'linkedin_url'  => $data['linkedin'] ?? ('https://linkedin.com/in/' . Str::slug($data['name'], '-')),
                    ]
                );

                $level = $this->determineLevel($data['pos']);
                $bidangId = $data['bid_id'] ?? null;
                if ($level === 3 && !$bidangId) {
                    $deptBidangs = $bidangs->where('department_id', $data['dept_id']);
                    $bidangId = $deptBidangs->isNotEmpty() ? $deptBidangs->random()->id : null;
                }

                $pengurus = Pengurus::updateOrCreate(
                    ['member_id' => $member->id, 'period_id' => $period->id],
                    [
                        'department_id'   => $data['dept_id'],
                        'bidang_id'       => $bidangId,
                        'position'        => $data['pos'],
                        'hierarchy_level' => $level,
                    ]
                );

                // Media Library: foto pengurus & member avatar
                if (!empty($data['img'])) {
                    $imagePath = database_path('seeders/images/' . $data['img']);

                    if (file_exists($imagePath)) {
                        if (!$pengurus->hasMedia('foto_pengurus')) {
                            $pengurus->addMedia($imagePath)
                                ->preservingOriginal()
                                ->toMediaCollection('foto_pengurus');
                        }

                        if (!$member->hasMedia('avatars')) {
                            $member->addMedia($imagePath)
                                ->preservingOriginal()
                                ->toMediaCollection('avatars');
                        }
                    }
                }
            }
        }

        // 3. Tambahan Data Anggota Mahasiswa Biasa (Role: anggota)
        $extraMembers = [
            [
                'name'      => 'Ahmad Fajar Pratama',
                'nim'       => '20241310051',
                'email'     => 'fajar.pratama@student.ukri.ac.id',
                'phone'     => '081377889901',
                'year'      => '2024',
                'dept_id'   => 2,
                'instagram' => 'https://instagram.com/ahmadfajar_pratama',
                'linkedin'  => 'https://linkedin.com/in/ahmadfajarpratama',
            ],
            [
                'name'      => 'Dian Safitri Rahayu',
                'nim'       => '20241310052',
                'email'     => 'dian.safitri@student.ukri.ac.id',
                'phone'     => '081266778892',
                'year'      => '2024',
                'dept_id'   => 3,
                'instagram' => 'https://instagram.com/diansafitri_r',
                'linkedin'  => 'https://linkedin.com/in/diansafitri',
            ],
            [
                'name'      => 'Bagas Adi Saputra',
                'nim'       => '20231310080',
                'email'     => 'bagas.adi@student.ukri.ac.id',
                'phone'     => '085755667783',
                'year'      => '2023',
                'dept_id'   => 2,
                'instagram' => 'https://instagram.com/bagas_adisaputra',
                'linkedin'  => 'https://linkedin.com/in/bagasadi',
            ],
            [
                'name'      => 'Nabila Putri Kusuma',
                'nim'       => '20251310010',
                'email'     => 'nabila.kusuma@student.ukri.ac.id',
                'phone'     => '081944556674',
                'year'      => '2025',
                'dept_id'   => 4,
                'instagram' => 'https://instagram.com/nabilaputri_k',
                'linkedin'  => 'https://linkedin.com/in/nabilaputri',
            ],
            [
                'name'      => 'Rizky Firmansyah',
                'nim'       => '20251310011',
                'email'     => 'rizky.firmansyah@student.ukri.ac.id',
                'phone'     => '087833445565',
                'year'      => '2025',
                'dept_id'   => 2,
                'instagram' => 'https://instagram.com/rizky_firmansyah',
                'linkedin'  => 'https://linkedin.com/in/rizkyfirmansyah',
            ],
        ];

        foreach ($extraMembers as $extra) {
            $u = User::updateOrCreate(
                ['email' => $extra['email']],
                [
                    'password' => Hash::make('password'),
                    'no_hp'    => $extra['phone'],
                ]
            );
            if (!$u->hasRole('anggota') && !$u->hasRole('pengurus') && !$u->hasRole('super-admin')) {
                $u->assignRole('anggota');
            }

            $gen = $generations->get($extra['year']) ?? $gen2023;
            $m = Member::updateOrCreate(
                ['npm' => $extra['nim']],
                [
                    'user_id'       => $u->id,
                    'department_id' => $extra['dept_id'],
                    'generation_id' => $gen->id,
                    'full_name'     => $extra['name'],
                    'is_active'     => true,
                    'instagram_url' => $extra['instagram'],
                    'linkedin_url'  => $extra['linkedin'],
                ]
            );

            $dummyImage = database_path('seeders/images/dummy.png');
            if (file_exists($dummyImage) && !$m->hasMedia('avatars')) {
                $m->addMedia($dummyImage)
                    ->preservingOriginal()
                    ->toMediaCollection('avatars');
            }
        }
    }

    private function determineLevel($pos): int
    {
        if (Str::contains($pos, ['Ketua', 'Wakil', 'Sekretaris', 'Bendahara', 'Kesekretariatan'])) return 1;
        if (Str::contains($pos, ['Kepala', 'Koordinator'])) return 2;
        return 3;
    }

    private function getMetaforsaData(): array
    {
        return [
            [
                'name'      => 'Naya Fitri Nazwa Nur Haliza',
                'img'       => 'naya.png',
                'nim'       => '20231310072',
                'pos'       => 'Ketua Himpunan',
                'dept_id'   => 1,
                'email'     => 'naya@hmif.com',
                'phone'     => '081298765432',
                'instagram' => 'https://instagram.com/nayafitri.n',
                'linkedin'  => 'https://linkedin.com/in/nayafitri',
            ],
            [
                'name'      => 'Mochamad Dzaki Ramadhan',
                'img'       => 'dzaki.png',
                'nim'       => '20241310012',
                'pos'       => 'Wakil Ketua Himpunan',
                'dept_id'   => 1,
                'email'     => 'dzaki@hmif.com',
                'phone'     => '081312345678',
                'instagram' => 'https://instagram.com/dzaki.ramadhan',
                'linkedin'  => 'https://linkedin.com/in/dzakiramadhan',
            ],
            [
                'name'      => 'Tania Cahyani P',
                'img'       => 'tania-mf.png',
                'nim'       => '20231310098',
                'pos'       => 'Sekretaris',
                'dept_id'   => 1,
                'email'     => 'tania.mf@hmif.com',
                'phone'     => '082187654321',
                'instagram' => 'https://instagram.com/taniacahyanip',
                'linkedin'  => 'https://linkedin.com/in/taniacahyani',
            ],
            [
                'name'      => 'Gita Nurcahyani Aggriana',
                'img'       => 'gita.png',
                'nim'       => '20231310006',
                'pos'       => 'Kesekretariatan',
                'dept_id'   => 1,
                'email'     => 'gita@hmif.com',
                'phone'     => '085712349876',
                'instagram' => 'https://instagram.com/gitanurcahyani',
                'linkedin'  => 'https://linkedin.com/in/gitanurcahyani',
            ],
            [
                'name'      => 'Melani Marnia Putri',
                'img'       => 'melani.png',
                'nim'       => '20241310042',
                'pos'       => 'Bendahara',
                'dept_id'   => 1,
                'email'     => 'melani@hmif.com',
                'phone'     => '081987654321',
                'instagram' => 'https://instagram.com/melanimarnia',
                'linkedin'  => 'https://linkedin.com/in/melanimarnia',
            ],
            [
                'name'      => 'Siti Fatimah Assyadia Rohani',
                'img'       => 'asya.png',
                'nim'       => '20241310019',
                'pos'       => 'Bendahara 2',
                'dept_id'   => 1,
                'email'     => 'asya@hmif.com',
                'phone'     => '087812345670',
                'instagram' => 'https://instagram.com/assyadiarohani',
                'linkedin'  => 'https://linkedin.com/in/assyadiarohani',
            ],
            [
                'name'      => 'Haniep Fathan Riziq',
                'img'       => 'haniep.png',
                'nim'       => '20241310011',
                'pos'       => 'Kepala Departemen Riset Dan Teknologi',
                'dept_id'   => 2,
                'email'     => 'haniep@hmif.com',
                'phone'     => '081399887766',
                'instagram' => 'https://instagram.com/haniepfathan',
                'linkedin'  => 'https://linkedin.com/in/haniepfathan',
            ],
            [
                'name'      => 'Reyfasha Fadlan Azizan',
                'img'       => 'reyfasha.png',
                'nim'       => '20241310047',
                'pos'       => 'Kepala Departemen Pengembangan Sumber Daya Manusia',
                'dept_id'   => 3,
                'email'     => 'reyfasha@hmif.com',
                'phone'     => '081288776655',
                'instagram' => 'https://instagram.com/reyfashafadlan',
                'linkedin'  => 'https://linkedin.com/in/reyfashafadlan',
            ],
            [
                'name'      => 'Maulana Yusuf',
                'img'       => 'cupe.png',
                'nim'       => '20231310008',
                'pos'       => 'Kepala Departemen Media dan Informasi',
                'dept_id'   => 4,
                'email'     => 'maulana@hmif.com',
                'phone'     => '085611223344',
                'instagram' => 'https://instagram.com/maulanayusuf_cupe',
                'linkedin'  => 'https://linkedin.com/in/maulanayusuf',
            ],
            [
                'name'      => 'Haris Ramdhani',
                'img'       => 'haris.png',
                'nim'       => '20241310020',
                'pos'       => 'Staff',
                'dept_id'   => 2,
                'bid_id'    => 1,
                'email'     => 'haris@hmif.com',
                'phone'     => '081211112222',
                'instagram' => 'https://instagram.com/harisramdhani',
                'linkedin'  => 'https://linkedin.com/in/harisramdhani',
            ],
            [
                'name'      => 'Putu Alif Milanarsa',
                'img'       => 'putu.png',
                'nim'       => '20241310021',
                'pos'       => 'Staff',
                'dept_id'   => 3,
                'bid_id'    => 3,
                'email'     => 'putu@hmif.com',
                'phone'     => '081233334444',
                'instagram' => 'https://instagram.com/putualif',
                'linkedin'  => 'https://linkedin.com/in/putualif',
            ],
            [
                'name'      => 'Alamudin Sdaka',
                'img'       => 'alam.png',
                'nim'       => '20241310022',
                'pos'       => 'Staff',
                'dept_id'   => 3,
                'bid_id'    => 4,
                'email'     => 'alam@hmif.com',
                'phone'     => '081255556666',
                'instagram' => 'https://instagram.com/alamudinsdaka',
                'linkedin'  => 'https://linkedin.com/in/alamudinsdaka',
            ],
            [
                'name'      => 'Taufiq Rahman',
                'img'       => 'pampam.png',
                'nim'       => '20241310023',
                'pos'       => 'Staff',
                'dept_id'   => 3,
                'bid_id'    => 5,
                'email'     => 'taufiq@hmif.com',
                'phone'     => '081277778888',
                'instagram' => 'https://instagram.com/taufiqrahman_pampam',
                'linkedin'  => 'https://linkedin.com/in/taufiqrahman',
            ],
            [
                'name'      => 'Chelsea Alliya',
                'img'       => 'chelsea.png',
                'nim'       => '20241310024',
                'pos'       => 'Staff',
                'dept_id'   => 4,
                'bid_id'    => 6,
                'email'     => 'chelsea@hmif.com',
                'phone'     => '081299990000',
                'instagram' => 'https://instagram.com/chelseaalliya',
                'linkedin'  => 'https://linkedin.com/in/chelseaalliya',
            ],
            [
                'name'      => 'Syahnuran Kaafii',
                'img'       => 'kaafii.png',
                'nim'       => '20241310025',
                'pos'       => 'Staff',
                'dept_id'   => 4,
                'bid_id'    => 7,
                'email'     => 'kaafii@hmif.com',
                'phone'     => '081322223333',
                'instagram' => 'https://instagram.com/syahnurankaafii',
                'linkedin'  => 'https://linkedin.com/in/syahnurankaafii',
            ],
            [
                'name'      => 'Insania Nabella',
                'img'       => 'insania.png',
                'nim'       => '20241310026',
                'pos'       => 'Staff',
                'dept_id'   => 4,
                'bid_id'    => 7,
                'email'     => 'insania@hmif.com',
                'phone'     => '081344445555',
                'instagram' => 'https://instagram.com/insanianabella',
                'linkedin'  => 'https://linkedin.com/in/insanianabella',
            ],
        ];
    }

    private function getDigiswaraData(): array
    {
        return [
            [
                'name'      => 'Chriss Hendry Choong',
                'img'       => 'acong.png',
                'nim'       => '20221310011',
                'pos'       => 'Ketua Himpunan',
                'dept_id'   => 1,
                'email'     => 'chriss@hmif.com',
                'phone'     => '081234567890',
                'instagram' => 'https://instagram.com/chrisshendry',
                'linkedin'  => 'https://linkedin.com/in/chrisshendry',
            ],
            [
                'name'      => 'Muhammad Ikhsan Kamil',
                'img'       => 'ikhsan.png',
                'nim'       => '20221310012',
                'pos'       => 'Wakil Ketua Himpunan',
                'dept_id'   => 1,
                'email'     => 'ikhsan@hmif.com',
                'phone'     => '081234567891',
                'instagram' => 'https://instagram.com/ikhsankamil',
                'linkedin'  => 'https://linkedin.com/in/ikhsankamil',
            ],
            [
                'name'      => 'Tania Cahyani Putri',
                'img'       => 'tania.png',
                'nim'       => '20221310013',
                'pos'       => 'Sekretaris',
                'dept_id'   => 1,
                'email'     => 'tania.dw@hmif.com',
                'phone'     => '081234567892',
                'instagram' => 'https://instagram.com/taniacahyaniputri',
                'linkedin'  => 'https://linkedin.com/in/taniacahyaniputri',
            ],
            [
                'name'      => 'Raka Zilva Inggia',
                'img'       => 'raka.png',
                'nim'       => '20221310010',
                'pos'       => 'Kesekretariatan',
                'dept_id'   => 1,
                'email'     => 'raka@hmif.com',
                'phone'     => '081234567893',
                'instagram' => 'https://instagram.com/rakazilva',
                'linkedin'  => 'https://linkedin.com/in/rakazilva',
            ],
            [
                'name'      => 'Siti Maisyaroh',
                'img'       => 'simai.png',
                'nim'       => '20221310014',
                'pos'       => 'Bendahara',
                'dept_id'   => 1,
                'email'     => 'simai@hmif.com',
                'phone'     => '081234567894',
                'instagram' => 'https://instagram.com/sitimaisyaroh',
                'linkedin'  => 'https://linkedin.com/in/sitimaisyaroh',
            ],
            [
                'name'      => 'Departemen RISTEK',
                'img'       => 'ristek-dw.png',
                'nim'       => '20221310001',
                'pos'       => 'Kepala Departemen Riset Dan Teknologi',
                'dept_id'   => 2,
                'email'     => 'ristek.dw@hmif.com',
                'phone'     => '081234567895',
                'instagram' => 'https://instagram.com/hmif.ristek',
                'linkedin'  => 'https://linkedin.com/company/hmif-ukri',
            ],
            [
                'name'      => 'Departemen PSDM',
                'img'       => 'psdm-dw.png',
                'nim'       => '20221310002',
                'pos'       => 'Kepala Departemen Pengembangan Sumber Daya Manusia',
                'dept_id'   => 3,
                'email'     => 'psdm.dw@hmif.com',
                'phone'     => '081234567896',
                'instagram' => 'https://instagram.com/hmif.psdm',
                'linkedin'  => 'https://linkedin.com/company/hmif-ukri',
            ],
            [
                'name'      => 'Departemen MEDFO',
                'img'       => 'kominfo-dw.png',
                'nim'       => '20221310003',
                'pos'       => 'Kepala Departemen Media Dan Informasi',
                'dept_id'   => 4,
                'email'     => 'medfo.dw@hmif.com',
                'phone'     => '081234567897',
                'instagram' => 'https://instagram.com/hmif.medfo',
                'linkedin'  => 'https://linkedin.com/company/hmif-ukri',
            ],
        ];
    }

    private function getRaksabhinayaData(): array
    {
        return [
            [
                'name'      => 'Raafi Syarahil Azhar',
                'img'       => 'dummy.png',
                'nim'       => '20221310021',
                'pos'       => 'Ketua Himpunan',
                'dept_id'   => 1,
                'email'     => 'raafi@hmif.com',
                'phone'     => '081211223341',
                'instagram' => 'https://instagram.com/raafisyarahil',
                'linkedin'  => 'https://linkedin.com/in/raafisyarahil',
            ],
            [
                'name'      => 'Saripah Nurfadilah',
                'img'       => 'dummy.png',
                'nim'       => '20221310022',
                'pos'       => 'Wakil Ketua Himpunan',
                'dept_id'   => 1,
                'email'     => 'saripah@hmif.com',
                'phone'     => '081211223342',
                'instagram' => 'https://instagram.com/saripahnur',
                'linkedin'  => 'https://linkedin.com/in/saripah',
            ],
            [
                'name'      => 'Putri Ayu Wandira',
                'img'       => 'dummy.png',
                'nim'       => '20221310023',
                'pos'       => 'Sekretaris',
                'dept_id'   => 1,
                'email'     => 'putri.ayu@hmif.com',
                'phone'     => '081211223343',
                'instagram' => 'https://instagram.com/putriayuw',
                'linkedin'  => 'https://linkedin.com/in/putriayu',
            ],
            [
                'name'      => 'Aliya Khoirunnisa',
                'img'       => 'dummy.png',
                'nim'       => '20221310024',
                'pos'       => 'Bendahara 1',
                'dept_id'   => 1,
                'email'     => 'aliya@hmif.com',
                'phone'     => '081211223344',
                'instagram' => 'https://instagram.com/aliyakhoirun',
                'linkedin'  => 'https://linkedin.com/in/aliyakhoirun',
            ],
            [
                'name'      => 'Salsa Bella Ramadhani',
                'img'       => 'dummy.png',
                'nim'       => '20221310025',
                'pos'       => 'Bendahara 2',
                'dept_id'   => 1,
                'email'     => 'salsa@hmif.com',
                'phone'     => '081211223345',
                'instagram' => 'https://instagram.com/salsabella',
                'linkedin'  => 'https://linkedin.com/in/salsabella',
            ],
            [
                'name'      => 'Leonardo Da Silva',
                'img'       => 'dummy.png',
                'nim'       => '20221310026',
                'pos'       => 'Koordinator Pendidikan',
                'dept_id'   => 2,
                'email'     => 'leo@hmif.com',
                'phone'     => '081211223346',
                'instagram' => 'https://instagram.com/leonardosilva',
                'linkedin'  => 'https://linkedin.com/in/leonardosilva',
            ],
            [
                'name'      => 'Farid Hidayat',
                'img'       => 'dummy.png',
                'nim'       => '20221310027',
                'pos'       => 'Koordinator PSDM',
                'dept_id'   => 3,
                'email'     => 'farid@hmif.com',
                'phone'     => '081211223347',
                'instagram' => 'https://instagram.com/faridhidayat',
                'linkedin'  => 'https://linkedin.com/in/faridhidayat',
            ],
            [
                'name'      => 'Zaki Mubarak',
                'img'       => 'dummy.png',
                'nim'       => '20221310028',
                'pos'       => 'Koordinator Humas',
                'dept_id'   => 4,
                'email'     => 'zaki@hmif.com',
                'phone'     => '081211223348',
                'instagram' => 'https://instagram.com/zakimubarak',
                'linkedin'  => 'https://linkedin.com/in/zakimubarak',
            ],
        ];
    }
}

