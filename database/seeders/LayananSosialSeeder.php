<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LayananSosialSeeder extends Seeder
{
    public function run(): void
    {
        $layanan = [
            [
                'kode'        => 'FM',
                'nama'        => 'Bidang Fakir Miskin',
                'singkatan'   => 'Bidang FM',
                'jenis'       => 'bidang',
                'deskripsi'   => 'Bidang Fakir Miskin menangani program penanganan kemiskinan melalui pengecekan desil DTSEN (Data Terpadu Sosial Ekonomi Nasional) dan penerima bantuan sosial. Masyarakat dapat mengecek status dan kelayakan penerimaan bantuan sosial dari pemerintah.',
                'persyaratan' => "1. Fotokopi KTP\n2. Fotokopi KK\n3. Surat Keterangan Tidak Mampu dari Kelurahan/Desa\n4. Surat Pengantar RT/RW",
                'icon'        => 'fa-hand-holding-heart',
                'warna'       => '#e74c3c',
                'file_brosur' => null,
                'aktif'       => true,
                'urutan'      => 1,
            ],
            [
                'kode'        => 'PBS',
                'nama'        => 'Bidang Pemberdayaan Sosial',
                'singkatan'   => 'Bidang PBS',
                'jenis'       => 'bidang',
                'deskripsi'   => 'Bidang Pemberdayaan Sosial menangani pendaftaran dan tanda daftar Lembaga Kesejahteraan Sosial (LKS). LKS yang ingin mendapatkan pengakuan resmi dari Dinas Sosial dapat mengajukan permohonan melalui bidang ini.',
                'persyaratan' => "1. Akta Pendirian Lembaga/Yayasan\n2. SK Kemenkumham\n3. Struktur Organisasi\n4. Program Kerja\n5. Daftar Pengurus dan Anggota\n6. Fotokopi KTP Pengurus\n7. Profil Lembaga",
                'icon'        => 'fa-people-group',
                'warna'       => '#3498db',
                'file_brosur' => null,
                'aktif'       => true,
                'urutan'      => 2,
            ],
            [
                'kode'        => 'PJS',
                'nama'        => 'Bidang Perlindungan dan Jaminan Sosial',
                'singkatan'   => 'Bidang PJS',
                'jenis'       => 'bidang',
                'deskripsi'   => 'Bidang Perlindungan dan Jaminan Sosial menyediakan layanan Rumah Singgah bagi masyarakat dalam situasi darurat, korban bencana, atau orang terlantar yang membutuhkan tempat tinggal sementara dan perlindungan.',
                'persyaratan' => "1. Fotokopi KTP (jika ada)\n2. Surat Rujukan dari RT/RW/Kelurahan atau instansi terkait\n3. Kronologis kejadian/keterangan kondisi\n4. Kontak darurat keluarga",
                'icon'        => 'fa-shield-heart',
                'warna'       => '#9b59b6',
                'file_brosur' => null,
                'aktif'       => true,
                'urutan'      => 3,
            ],
            [
                'kode'        => 'RS',
                'nama'        => 'Bidang Rehabilitasi Sosial',
                'singkatan'   => 'Bidang Rehsos',
                'jenis'       => 'bidang',
                'deskripsi'   => 'Bidang Rehabilitasi Sosial melayani permohonan bantuan alat bantu (kaki palsu/prostesis) serta proses pengangkatan anak secara resmi sesuai peraturan perundangan yang berlaku.',
                'persyaratan' => "Untuk Kaki Palsu:\n1. Fotokopi KTP\n2. Fotokopi KK\n3. Surat Keterangan Dokter\n4. Foto kondisi anggota tubuh\n\nUntuk Pengangkatan Anak:\n1. Akta Kelahiran Anak\n2. Surat Persetujuan Orang Tua Kandung\n3. KTP & KK Calon Orang Tua Angkat\n4. Surat Keterangan Tidak Mampu Orang Tua Kandung",
                'icon'        => 'fa-person-walking-with-cane',
                'warna'       => '#e67e22',
                'file_brosur' => null,
                'aktif'       => true,
                'urutan'      => 4,
            ],
            [
                'kode'        => 'PRSPD',
                'nama'        => 'UPTD PRSPD',
                'singkatan'   => 'PRSPD',
                'jenis'       => 'uptd',
                'deskripsi'   => 'Unit Pelaksana Teknis Daerah Panti Rehabilitasi Sosial Penyandang Disabilitas (UPTD PRSPD) memberikan layanan rehabilitasi sosial, pendampingan, dan pemberdayaan bagi penyandang disabilitas fisik dan mental agar dapat hidup mandiri dan bermartabat.',
                'persyaratan' => "1. Fotokopi KTP / Akta Kelahiran\n2. Fotokopi KK\n3. Surat Keterangan Disabilitas dari Dokter/RS\n4. Surat Keterangan Tidak Mampu dari Kelurahan\n5. Foto Pemohon terbaru\n6. Surat Pengantar dari Dinsos Kab/Kota",
                'icon'        => 'fa-wheelchair',
                'warna'       => '#1abc9c',
                'file_brosur' => null,
                'aktif'       => true,
                'urutan'      => 5,
            ],
            [
                'kode'        => 'PSAA_BA',
                'nama'        => 'UPTD PSAA Budi Asih',
                'singkatan'   => 'PSAA Budi Asih',
                'jenis'       => 'uptd',
                'deskripsi'   => 'Panti Sosial Asuhan Anak (PSAA) Budi Asih memberikan layanan pengasuhan, pendidikan, dan bimbingan bagi anak terlantar, anak yatim/piatu, dan anak kurang mampu agar tumbuh dengan baik dan mendapatkan hak-haknya.',
                'persyaratan' => "1. Akta Kelahiran Anak\n2. Fotokopi KK\n3. Surat Keterangan Yatim/Piatu (jika berlaku)\n4. Surat Keterangan Tidak Mampu dari Kelurahan\n5. KTP Orang Tua/Wali\n6. Foto Anak terbaru 3x4 (2 lembar)\n7. Rapor/Surat Keterangan Sekolah",
                'icon'        => 'fa-child',
                'warna'       => '#f39c12',
                'file_brosur' => null,
                'aktif'       => true,
                'urutan'      => 6,
            ],
            [
                'kode'        => 'PSAA_HB',
                'nama'        => 'UPTD PSAA Harapan Bangsa',
                'singkatan'   => 'PSAA Harapan Bangsa',
                'jenis'       => 'uptd',
                'deskripsi'   => 'Panti Sosial Asuhan Anak (PSAA) Harapan Bangsa memberikan layanan pengasuhan, bimbingan sosial, pendidikan, dan keterampilan hidup bagi anak-anak terlantar dan kurang mampu di Provinsi Lampung.',
                'persyaratan' => "1. Akta Kelahiran Anak\n2. Fotokopi KK\n3. Surat Keterangan Yatim/Piatu (jika berlaku)\n4. Surat Keterangan Tidak Mampu dari Kelurahan\n5. KTP Orang Tua/Wali\n6. Foto Anak terbaru 3x4 (2 lembar)\n7. Rapor Terakhir / Surat Keterangan Sekolah",
                'icon'        => 'fa-children',
                'warna'       => '#16a085',
                'file_brosur' => null,
                'aktif'       => true,
                'urutan'      => 7,
            ],
            [
                'kode'        => 'PSBR',
                'nama'        => 'UPTD PSBR Radin Intan',
                'singkatan'   => 'PSBR Radin Intan',
                'jenis'       => 'uptd',
                'deskripsi'   => 'Unit Pelaksana Teknis Daerah Panti Sosial Bina Remaja (UPTD PSBR) Radin Intan memberikan layanan pembinaan, pelatihan keterampilan, dan bimbingan sosial bagi remaja putus sekolah agar siap memasuki dunia kerja.',
                'persyaratan' => "1. Fotokopi Akta Kelahiran\n2. Fotokopi KTP (jika sudah punya)\n3. Fotokopi KK\n4. Surat Keterangan Putus Sekolah\n5. Surat Keterangan Tidak Mampu dari Kelurahan/Desa\n6. Surat Pengantar RT/RW\n7. Pas Foto 3x4 (3 lembar)",
                'icon'        => 'fa-graduation-cap',
                'warna'       => '#8e44ad',
                'file_brosur' => null,
                'aktif'       => true,
                'urutan'      => 8,
            ],
            [
                'kode'        => 'PSLU',
                'nama'        => 'UPTD PSLU Tresna Werdha',
                'singkatan'   => 'PSLU Tresna Werdha',
                'jenis'       => 'uptd',
                'deskripsi'   => 'Unit Pelaksana Teknis Daerah Panti Sosial Lanjut Usia (UPTD PSLU) Tresna Werdha memberikan layanan perawatan, pembinaan, dan pelayanan sosial bagi lansia terlantar agar dapat menikmati hari tua dengan layak, nyaman, dan bermartabat.',
                'persyaratan' => "1. Fotokopi KTP / Akta Kelahiran\n2. Fotokopi KK\n3. Surat Keterangan Terlantar dari Kelurahan/Desa\n4. Surat Keterangan Sehat dari Dokter/Puskesmas\n5. Foto Lansia terbaru\n6. KTP Wali/Keluarga yang dapat dihubungi",
                'icon'        => 'fa-person-cane',
                'warna'       => '#2c3e50',
                'file_brosur' => null,
                'aktif'       => true,
                'urutan'      => 9,
            ],
        ];

        DB::table('layanan_sosial')->insert($layanan);
    }
}
