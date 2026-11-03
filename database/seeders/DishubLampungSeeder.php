<?php

namespace Database\Seeders;

use App\Models\DishubAkdpRoute;
use App\Models\DishubFlightSchedule;
use App\Models\DishubSectionNote;
use App\Models\DishubTerminal;
use App\Models\DishubTollRate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DishubLampungSeeder extends Seeder
{
    public function run(): void
    {
        $today = Carbon::today()->toDateString();

        DishubFlightSchedule::truncate();
        DishubTerminal::truncate();
        DishubAkdpRoute::truncate();
        DishubTollRate::truncate();
        DishubSectionNote::truncate();

        $flightRows = [
            ['arrival', 'Citilink Indonesia', 'Jakarta', '10.00 & 14.30', 'Setiap Hari'],
            ['arrival', 'Air Asia', 'Jakarta', '10.00 & 17.00', 'Setiap Hari'],
            ['arrival', 'Air Asia', 'Jakarta', '13.5', 'Sen, Sel, Rab, Jum, Sab, Min'],
            ['arrival', 'Air Asia', 'Jakarta', '18.05', 'Sel, Kam, Sab, Min'],
            ['arrival', 'Lion Air', 'Jakarta', '11.35, 12.40, 19.40', 'Setiap Hari'],
            ['arrival', 'Lion Air', 'Jakarta', '17.05', 'Setiap Hari'],
            ['arrival', 'Lion Air', 'Jakarta', '14.4', 'Sel, Rab, Jum, Min'],
            ['arrival', 'Garuda Indonesia', 'Jakarta', '13.25 & 18.40', 'Setiap Hari'],
            ['arrival', 'Garuda Indonesia', 'Jakarta', '12.1', 'Sabtu'],
            ['arrival', 'Garuda Indonesia', 'Jakarta', '13.05', 'Kamis'],
            ['arrival', 'Super Air Jet', 'Jakarta', '7.25', 'Sel, Rab, Min'],
            ['arrival', 'Super Air Jet', 'Batam', '11.45', 'Sen, Rab, Jum, Sab'],
            ['arrival', 'Super Air Jet', 'Batam', '18.05', 'Sel, Rab, Kam, Min'],
            ['arrival', 'Susi Air', 'Krui', '13.1', 'Jumat'],
            ['departure', 'Citilink Indonesia', 'Jakarta', '10.00 & 14.30', 'Setiap Hari'],
            ['departure', 'Air Asia', 'Jakarta', '10.00 & 17.00', 'Setiap Hari'],
            ['departure', 'Air Asia', 'Jakarta', '13.5', 'Sen, Sel, Rab, Jum, Sab, Min'],
            ['departure', 'Air Asia', 'Jakarta', '18.05', 'Sel, Kam, Sab, Min'],
            ['departure', 'Lion Air', 'Jakarta', '11.35, 12.40, 19.40', 'Setiap Hari'],
            ['departure', 'Lion Air', 'Jakarta', '17.05', 'Setiap Hari'],
            ['departure', 'Lion Air', 'Jakarta', '14.4', 'Sel, Rab, Jum, Min'],
            ['departure', 'Garuda Indonesia', 'Jakarta', '13.25 & 18.40', 'Setiap Hari'],
            ['departure', 'Garuda Indonesia', 'Jakarta', '12.1', 'Sabtu'],
            ['departure', 'Garuda Indonesia', 'Jakarta', '13.05', 'Kamis'],
            ['departure', 'Super Air Jet', 'Jakarta', '7.25', 'Sel, Rab, Min'],
            ['departure', 'Super Air Jet', 'Batam', '11.45', 'Sen, Rab, Jum, Sab'],
            ['departure', 'Super Air Jet', 'Batam', '18.05', 'Sel, Rab, Kam, Min'],
            ['departure', 'Susi Air', 'Krui', '13.1', 'Jumat'],
        ];

        foreach ($flightRows as $index => $row) {
            DishubFlightSchedule::create([
                'category' => $row[0],
                'airline' => $row[1],
                'route' => $row[2],
                'estimated_time' => $row[3],
                'operational_days' => $row[4],
                'source' => 'Infografis Jadwal Angkasa Pura',
                'data_updated_at' => $today,
                'sort_order' => $index + 1,
            ]);
        }

        $terminals = [
            [1, 'Bandar Lampung', 'Rajabasa', 'A', 'BPTD Kemenhub (Aktif)', 'Lokasi'],
            [1, 'Bandar Lampung', 'Kemiling', 'C', 'Tidak Beroperasi (Dishub Kota)', 'Lokasi'],
            [1, 'Bandar Lampung', 'Panjang', 'C', 'Tidak Beroperasi (Dishub Kota)', 'Lokasi'],
            [1, 'Bandar Lampung', 'Pasar Bawah', 'C', 'Tidak Beroperasi (Dishub Kota)', 'Lokasi'],
            [1, 'Bandar Lampung', 'Sukaraja', 'C', 'Tidak Beroperasi (Dishub Kota)', 'Lokasi'],
            [2, 'Lampung Selatan', 'Pasar Kalianda', 'C', 'Dishub Kab. Lamsel (Aktif)', 'Lokasi'],
            [2, 'Lampung Selatan', 'Bunut', 'C', 'Tidak Beroperasi (Dishub Kab)', 'Lokasi'],
            [2, 'Lampung Selatan', 'Bakauheni', 'B', 'Lahan ASDP (Dishub Prov)', 'Lokasi'],
            [3, 'Tanggamus', 'Kota Agung', 'B', 'Tidak Beroperasi (Dishub Prov)', 'Lokasi'],
            [4, 'Metro', 'Mulyojati', 'B', 'Dishub Prov (Aktif)', 'Lokasi'],
            [4, 'Metro', '16 C', 'C', 'Tidak Beroperasi', 'Lokasi'],
            [5, 'Lampung Tengah', 'Betan Subing', 'A', 'Tidak Beroperasi (Kemenhub)', 'Lokasi'],
            [5, 'Lampung Tengah', 'Pasar Bandar Jaya', 'C', 'Dishub Kab. Lamteng (Aktif)', 'Lokasi'],
            [5, 'Lampung Tengah', 'Gaya Baru', 'B', 'Dishub Prov (Aktif)', 'Lokasi'],
            [6, 'Lampung Utara', 'Simpang Propau', 'B', 'Dishub Prov (Aktif)', 'Lokasi'],
            [6, 'Lampung Utara', 'Pasar Kota', 'C', 'Dishub Kab. Lamut (Aktif)', 'Lokasi'],
            [6, 'Lampung Utara', 'Ps. Sentral Kotabumi', 'C', 'Dishub Kab. Lamut (Aktif)', 'Lokasi'],
            [6, 'Lampung Utara', 'Pasar Dekon', 'C', 'Dishub Kab. Lamut (Aktif)', 'Lokasi'],
            [7, 'Tulang Bawang', 'Menggala', 'B', 'Dishub Prov (Aktif)', 'Lokasi'],
            [7, 'Tulang Bawang', 'Unit II', 'C', 'Tidak Ada Terminal (Dishub Kab)', 'Lokasi'],
            [8, 'Lampung Barat', 'Liwa', 'B', 'Dishub Prov (Aktif)', 'Lokasi'],
            [8, 'Lampung Barat', 'Sekincau', 'C', 'Tidak Beroperasi (Dishub Kab)', 'Lokasi'],
            [9, 'Lampung Timur', 'Mataram Baru', 'B', 'Belum Diserahkan ke Prov', 'Lokasi'],
            [10, 'Way Kanan', 'Baradatu', 'B', 'Belum Diserahkan ke Prov', 'Lokasi'],
            [11, 'Pesawaran', 'Gedong Tataan', '-', 'Kawasan Informal', 'Lokasi'],
            [11, 'Pesawaran', 'Negeri Sakti', '-', 'Kawasan Informal', 'Lokasi'],
            [11, 'Pesawaran', 'Hanura', '-', 'Kawasan Informal', 'Lokasi'],
            [12, 'T. Bawang Barat', 'Mulyo Asri', 'B', 'Belum Beroperasi (Dishub Prov)', 'Lokasi'],
            [13, 'Pringsewu', 'Gadingrejo', 'B', 'Dishub Prov (Aktif)', 'Lokasi'],
            [14, 'Mesuji', 'Simpang Pematang', '-', 'Kawasan Informal', 'Lokasi'],
            [15, 'Pesisir Barat', 'Way Batu', 'C', 'Dishub Kab. Pesbar (Aktif)', 'Lokasi'],
            [15, 'Pesisir Barat', 'Lemong', 'B', 'Belum Diserahkan ke Prov', 'Lokasi'],
        ];

        foreach ($terminals as $index => $row) {
            DishubTerminal::create([
                'group_no' => $row[0],
                'kabupaten_kota' => $row[1],
                'nama_terminal' => $row[2],
                'tipe' => $row[3],
                'status_operasional' => $row[4],
                'koordinat_label' => $row[5],
                'data_updated_at' => $today,
                'sort_order' => $index + 1,
            ]);
        }

        $routes = [
            ['Way Kanan', 'Ter. Rajabasa - Ter. Bandar Jaya - Ter. Kotabumi - Bukit Kemuning - Baradatu - Sp. Empat - Bahuga', 'PP', null, null],
            ['Way Kanan', 'Ter. Rajabasa - Ter. Bandar Jaya - Ter. Kotabumi - Bukit Kemuning - Baradatu - Sp. Empat - Kasui', 'PP', null, null],
            ['Way Kanan', 'Ter. Rajabasa - Ter. Bandar Jaya - Ter. Kotabumi - Ketapang - Negeriratu - Gng. Labuhan - Baradatu - Sp. Empat - Blambangan Umpu', 'PP', null, null],
            ['Way Kanan', 'Ter. Rajabasa - Ter. Bandar Jaya - Ter. Kotabumi - Ketapang - Negeriratu - Negara Tulang Bawang - Pakuan Ratu', 'PP', null, null],
            ['Mesuji', 'Ter. Rajabasa - Ter. Bandar Jaya - Gunung Batin - Panaragan Jaya - Ter. Menggala - Unit II - Sp. Penawar - Mesuji', 'PP', null, null],
            ['Tulang Bawang', 'Ter. Rajabasa - Ter. Bandar Jaya - Gunung Batin - Ter. Menggala - Unit II - Tulang Bawang - Sp. Penawar - Rawajitu', 'PP', null, null],
            ['Tulang Bawang', 'Ter. Rajabasa - Bandar Jaya - Gn. Banting - Daya Murni - Panaragan Jaya - Ter. Menggala', 'PP', null, null],
            ['Pesisir Barat', 'Ter. Rajabasa - Ter. Pringsewu - Talang Padang - Ter. Kota Agung - Wonosobo - Siging - Biha - Ter. Krui', 'PP', null, null],
            ['Pesisir Barat', 'Ter. Rajabasa - Ter. Bandar Jaya - Ter. Kotabumi - Bukit Kemuning - Sumber Jaya - Liwa - Ter. Krui', 'PP', null, null],
            ['Lampung Barat', 'Ter. Rajabasa - Ter. Bandar Jaya - Ter. Kotabumi - Bukit Kemuning - Sumber Jaya - Ter. Liwa', 'PP', null, null],
            ['Lampung Tengah', 'Ter. Rajabasa - Tegineneng - Ter. Mulyojati (Metro) - Kota Gajah - Seputih Banyak - Rumbia - Seputih Surabaya', 'PP', null, null],
            ['Lampung Tengah', 'Ter. Rajabasa - Ter. Mulyojati (Metro) - Kota Gajah - Seputih Raman - Rumbia - Gaya Baru', 'PP', null, null],
            ['Lampung Selatan', 'Ter. Rajabasa - Ter. Panjang - Pelabuhan Bakauheni', 'PP', null, null],
            ['Lampung Selatan', 'Ter. Rajabasa - Toll Kotabaru (Itera) - Ter. Eksekutif Bakauheni', 'PP', 'Jalur Cepat/Via Tol', 'Jalur Cepat/Via Tol'],
            ['Lintas Timur', 'Unit II - Menggala - Sp. Randu - Sukadana - Jepara - Semarang Baru - Ter. Bungur - Ketapang - Bakauheni', 'PP', 'Rute Lintas Kabupaten', 'Rute Lintas Kabupaten'],
            ['Lampung Timur', 'Ter. Rajabasa - Ter. Mulyojati (Metro) - Sukadana - Way Jepara - Sribawono - Labuhan Maringgai', 'PP', null, null],
            ['Lampung Timur', 'Ter. Rajabasa - Jl. Tirtayasa - Sp. Pugung Raharjo - Sribawono - Way Jepara - Sukadana', 'PP', null, null],
            ['Lintas Tengah', 'Pakuan Ratu - Sp. TL Randu - Ter. Menggala - Gng. Batin - Ter. Bandar Jaya - Kota Gajah - Sukadana - Labuhan Maringgai', 'PP', 'Rute Lintas Kabupaten', 'Rute Lintas Kabupaten'],
            ['Lampung Timur', 'Ter. Rajabasa - Jabung', 'PP', null, null],
            ['Metro', 'Ter. Rajabasa - Tegineneng - Ter. Mulyojati (Metro)', 'PP', null, null],
            ['Lampung Utara', 'Ter. Rajabasa - Ter. Bandar Jaya - Ter. Kotabumi', 'PP', null, null],
            ['Tanggamus', 'Ter. Rajabasa - Ter. Pringsewu - Talang Padang - Ter. Kota Agung', 'PP', null, null],
        ];

        foreach ($routes as $index => $row) {
            DishubAkdpRoute::create([
                'wilayah_tujuan' => $row[0],
                'detail_trayek' => $row[1],
                'keterangan' => $row[2],
                'kategori' => $row[3],
                'label_aplikasi' => $row[4],
                'source' => 'Inventaris Data Dinas Perhubungan Provinsi Lampung',
                'data_updated_at' => $today,
                'sort_order' => $index + 1,
            ]);
        }

        $tollRates = [
            ['Bakauheni Selatan ↔ Bakauheni Utara', 'Rp 7.500', 'Rp 11.500', 'Rp 15.500'],
            ['Bakauheni Selatan ↔ Kalianda', 'Rp 26.500', 'Rp 39.500', 'Rp 52.500'],
            ['Bakauheni Selatan ↔ Sidomulyo', 'Rp 38.500', 'Rp 57.500', 'Rp 76.500'],
            ['Bakauheni Selatan ↔ Lematang', 'Rp 79.500', 'Rp 119.500', 'Rp 159.000'],
            ['Bakauheni Selatan ↔ Kotabaru', 'Rp 85.000', 'Rp 127.500', 'Rp 170.000'],
            ['Bakauheni Selatan ↔ Natar', 'Rp 108.500', 'Rp 162.500', 'Rp 216.500'],
            ['Bakauheni Selatan ↔ Tegineneng Timur', 'Rp 124.500', 'Rp 187.000', 'Rp 249.000'],
            ['Bakauheni Selatan ↔ Gunung Sugih', 'Rp 150.500', 'Rp 226.000', 'Rp 301.500'],
            ['Bakauheni Selatan ↔ Terbanggi Besar', 'Rp 166.500', 'Rp 249.500', 'Rp 332.500'],
        ];

        foreach ($tollRates as $index => $row) {
            DishubTollRate::create([
                'asal_tujuan' => $row[0],
                'golongan_i' => $row[1],
                'golongan_ii_iii' => $row[2],
                'golongan_iv_v' => $row[3],
                'source' => 'SK Menteri PU No. 1066/KPTS/M/2025',
                'data_updated_at' => $today,
                'sort_order' => $index + 1,
            ]);
        }

        $notes = [
            ['flight_schedule', 'Jadwal merujuk pada data operasional dalam 1 minggu Maret 2026.', 1],
            ['flight_schedule', 'Beberapa keberangkatan memiliki selisih waktu 5-10 menit tergantung hari penerbangan.', 2],
            ['flight_schedule', 'Sumber: Infografis Jadwal Angkasa Pura.', 3],
            ['terminal', 'Khusus Terminal Bakauheni, lokasi diletakkan di dalam area pelabuhan karena pengelolaan berada di lahan ASDP namun operasional terminal oleh Dishub.', 1],
            ['akdp_route', 'PP = Pulang Pergi.', 1],
            ['akdp_route', 'No. 14 adalah rute khusus via Tol Kotabaru, ini perlu label "Jalur Cepat/Via Tol".', 2],
            ['akdp_route', 'Sebagian besar rute melewati Terminal Bandar Jaya dan Terminal Kotabumi.', 3],
            ['akdp_route', 'No. 15 dan 18 termasuk kategori "Rute Lintas Kabupaten".', 4],
            ['toll_rate', 'Golongan I: Sedan, Jeep, Pick Up/Truk Kecil, dan Bus.', 1],
            ['toll_rate', 'Golongan II: Truk dengan 2 gandar.', 2],
            ['toll_rate', 'Golongan III: Truk dengan 3 gandar.', 3],
            ['toll_rate', 'Golongan IV: Truk dengan 4 gandar.', 4],
            ['toll_rate', 'Golongan V: Truk dengan 5 gandar atau lebih.', 5],
        ];

        foreach ($notes as $note) {
            DishubSectionNote::create([
                'section' => $note[0],
                'note' => $note[1],
                'data_updated_at' => $today,
                'sort_order' => $note[2],
            ]);
        }
    }
}
