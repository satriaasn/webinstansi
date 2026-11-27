<?php

namespace Database\Seeders;

use App\Models\StrukturOrganisasi;
use Illuminate\Database\Seeder;

class StrukturOrganisasiSeeder extends Seeder
{
    public function run(): void
    {
        if (StrukturOrganisasi::count() > 0) {
            return;
        }

        // 1. Kepala Badan (Root)
        $kepala = StrukturOrganisasi::create([
            'parent_id' => null,
            'jabatan' => 'KEPALA BADAN',
            'nama' => 'Dr. ANANG RISGIYANTO, S.K.M., M.Kes.',
            'nip' => '19750731 200003 1 002',
            'pangkat' => 'PEMBINA UTAMA MADYA (IV/d)',
            'tmt_pangkat' => '06-10-2021',
            'tmt_jabatan' => '18-09-2025',
            'tipe_node' => 'pimpinan',
            'urutan' => 1,
            'active' => 'Y',
        ]);

        // 2. Sekretaris (Branching right under Kepala Badan)
        $sekretaris = StrukturOrganisasi::create([
            'parent_id' => $kepala->id,
            'jabatan' => 'SEKRETARIS',
            'nama' => 'ANDI ARAFAT, S.T., M.E.',
            'nip' => '19740707 200212 1 008',
            'pangkat' => 'PEMBINA TK I (IV/b)',
            'tmt_pangkat' => '01-08-2024',
            'tmt_jabatan' => '25-04-2025',
            'tipe_node' => 'sekretaris',
            'urutan' => 1,
            'active' => 'Y',
        ]);

        // Children of Sekretaris
        StrukturOrganisasi::create([
            'parent_id' => $sekretaris->id,
            'jabatan' => 'KASUBBAG UMUM DAN KEPEGAWAIAN',
            'nama' => 'CIK MARYA, S.E., M.M.',
            'nip' => '19691026 199203 2 002',
            'pangkat' => 'PEMBINA (IV/a)',
            'tmt_pangkat' => '01-04-2023',
            'tmt_jabatan' => '11-10-2024',
            'tipe_node' => 'kasubbag',
            'urutan' => 1,
            'active' => 'Y',
        ]);

        StrukturOrganisasi::create([
            'parent_id' => $sekretaris->id,
            'jabatan' => 'KASUBBAG KEUANGAN DAN ASET',
            'nama' => 'NORMA YUNITA, S.IP., M.M.',
            'nip' => '19780612 199803 2 003',
            'pangkat' => 'PENATA TK I (III/d)',
            'tmt_pangkat' => '01-04-2023',
            'tmt_jabatan' => '11-10-2024',
            'tipe_node' => 'kasubbag',
            'urutan' => 2,
            'active' => 'Y',
        ]);

        StrukturOrganisasi::create([
            'parent_id' => $sekretaris->id,
            'jabatan' => 'KELOMPOK JABATAN FUNGSIONAL/PELAKSANA',
            'tipe_node' => 'fungsional',
            'urutan' => 3,
            'active' => 'Y',
        ]);

        // 3. Kepala UPTD & 4 Kabid under Kepala Badan
        $uptd = StrukturOrganisasi::create([
            'parent_id' => $kepala->id,
            'jabatan' => 'KEPALA UNIT PELAYANAN TEKNIS DAERAH PUSAT DATA & INFORMASI PEMBANGUNAN DAERAH',
            'nama' => 'YASIR WIJAYA, S.Si., M.Si.',
            'nip' => '19840505 201003 1 002',
            'pangkat' => 'PEMBINA (IV/a)',
            'tmt_pangkat' => '01-10-2025',
            'tmt_jabatan' => '03-09-2026',
            'tipe_node' => 'uptd',
            'urutan' => 2,
            'active' => 'Y',
        ]);

        // Children of UPTD
        StrukturOrganisasi::create([
            'parent_id' => $uptd->id,
            'jabatan' => 'KEPALA SEKSI DATA GEOSPASIAL',
            'nama' => 'M. RIDUWAN PASRA, S.E., M.BA.',
            'nip' => '19821024 201001 1 012',
            'pangkat' => 'PEMBINA (IV/a)',
            'tmt_pangkat' => '01-04-2024',
            'tmt_jabatan' => '08-04-2020',
            'tipe_node' => 'kasi',
            'urutan' => 1,
            'active' => 'Y',
        ]);

        StrukturOrganisasi::create([
            'parent_id' => $uptd->id,
            'jabatan' => 'KEPALA SEKSI DATA STATISTIK',
            'nama' => 'SYAIFUL RAHMAT, S.E., M.E., MIDS.',
            'nip' => '19811225 201001 1 022',
            'pangkat' => 'PENATA TK I (III/d)',
            'tmt_pangkat' => '01-02-2025',
            'tmt_jabatan' => '02-06-2025',
            'tipe_node' => 'kasi',
            'urutan' => 2,
            'active' => 'Y',
        ]);

        StrukturOrganisasi::create([
            'parent_id' => $uptd->id,
            'jabatan' => 'KEPALA SUB BAGIAN TATA USAHA',
            'nama' => 'YULIYANA, S.T., M.M.',
            'nip' => '19781230 200903 2 002',
            'pangkat' => 'PEMBINA (IV/a)',
            'tmt_pangkat' => '01-10-2024',
            'tmt_jabatan' => '02-02-2021',
            'tipe_node' => 'kasi',
            'urutan' => 3,
            'active' => 'Y',
        ]);

        StrukturOrganisasi::create([
            'parent_id' => $uptd->id,
            'jabatan' => 'KELOMPOK JABATAN FUNGSIONAL/PELAKSANA',
            'tipe_node' => 'fungsional',
            'urutan' => 4,
            'active' => 'Y',
        ]);

        // 4 Kabids
        $kabids = [
            [
                'jabatan' => 'KABID PERENCANAAN MAKRO, PENGENDALIAN DAN EVALUASI PEMBANGUNAN',
                'nama' => 'MEYDIANDRA EKA PUTRA, S.P., M.IP.',
                'nip' => '19730514 199803 1 007',
                'pangkat' => 'PEMBINA TK I (IV/b)',
                'tmt_pangkat' => '01-04-2016',
                'tmt_jabatan' => '25-04-2025',
                'urutan' => 3,
            ],
            [
                'jabatan' => 'KABID PERENCANAAN PEREKONOMIAN',
                'nama' => 'ENDANG WAHYUNI, S.T., M.Si.',
                'nip' => '19750617 200003 2 001',
                'pangkat' => 'PEMBINA (IV/a)',
                'tmt_pangkat' => '01-04-2022',
                'tmt_jabatan' => '13-01-2023',
                'urutan' => 4,
            ],
            [
                'jabatan' => 'KABID PERENCANAAN PEMERINTAHAN DAN PEMBANGUNAN MANUSIA',
                'nama' => 'M. AZIZ SATRIYA JAYA, S.E., M.Si.',
                'nip' => '19780203 200501 1 004',
                'pangkat' => 'PEMBINA TK I (IV/b)',
                'tmt_pangkat' => '01-04-2025',
                'tmt_jabatan' => '20-09-2024',
                'urutan' => 5,
            ],
            [
                'jabatan' => 'KABID PERENCANAAN INFRASTRUKTUR DAN KEWILAYAHAN',
                'nama' => 'Ir. IDA SUSANTI S., S.T., M.T.',
                'nip' => '19741009 200604 2 005',
                'pangkat' => 'PEMBINA TK I (IV/b)',
                'tmt_pangkat' => '01-02-2024',
                'tmt_jabatan' => '19-06-2026',
                'urutan' => 6,
            ],
        ];

        foreach ($kabids as $k) {
            $kabid = StrukturOrganisasi::create(array_merge($k, [
                'parent_id' => $kepala->id,
                'tipe_node' => 'kabid',
                'active' => 'Y',
            ]));

            StrukturOrganisasi::create([
                'parent_id' => $kabid->id,
                'jabatan' => 'KELOMPOK JABATAN FUNGSIONAL/PELAKSANA',
                'tipe_node' => 'fungsional',
                'urutan' => 1,
                'active' => 'Y',
            ]);
        }
    }
}
