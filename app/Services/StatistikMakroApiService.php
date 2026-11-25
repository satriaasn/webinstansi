<?php

namespace App\Services;

use App\Models\StatistikMakro;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class StatistikMakroApiService
{
    public function sync(): array
    {
        $baseUrl = rtrim(config('services.agenda.base_url', 'https://sektrabappeda.my.id/api/v1'), '/');
        $verifySsl = (bool) config('services.agenda.verify_ssl', false);
        $apiKey = config('services.agenda.api_key');

        $client = Http::withOptions(['verify' => $verifySsl])->timeout(25);
        if (!empty($apiKey)) {
            $client = $client->withHeaders(['X-API-Key' => $apiKey]);
        }

        $response = $client->get($baseUrl . '/pusdatin/makro');

        if (!$response->successful()) {
            throw new \RuntimeException('Gagal mengambil data dari API Pusdatin Makro (HTTP ' . $response->status() . ').');
        }

        $payload = $response->json();
        $items = $payload['data'] ?? [];

        if (!is_array($items)) {
            throw new \RuntimeException('Format respon API Pusdatin Makro tidak valid.');
        }

        $isInitialEmpty = StatistikMakro::count() === 0;
        $initialSelectedCount = 0;
        $synced = 0;

        foreach ($items as $idx => $item) {
            if (empty($item['id'])) {
                continue;
            }

            $existing = StatistikMakro::where('api_id', $item['id'])->first();
            $ringkasan = $item['ringkasan'] ?? [];

            $showOnHome = $existing ? $existing->show_on_home : false;
            $urutan = $existing ? $existing->urutan : ($idx + 1);

            if ($isInitialEmpty && !empty($item['is_indikator_utama']) && $initialSelectedCount < 5) {
                $showOnHome = true;
                $initialSelectedCount++;
            }

            StatistikMakro::updateOrCreate(
                ['api_id' => $item['id']],
                [
                    'judul' => $item['judul'] ?? 'Indikator Makro',
                    'deskripsi' => $item['deskripsi'] ?? null,
                    'sektor_nama' => $item['sektor']['nama'] ?? null,
                    'kategori_nama' => $item['kategori']['nama'] ?? null,
                    'jenis_grafik' => $item['jenis_grafik'] ?? null,
                    'jenis_indikator' => $item['jenis_indikator'] ?? 'positif',
                    'is_indikator_utama' => (bool) ($item['is_indikator_utama'] ?? false),
                    'satuan' => $item['satuan'] ?? null,
                    'periode' => isset($item['periode']) ? (string) $item['periode'] : null,
                    'sumber_data' => $item['sumber_data'] ?? null,
                    'nilai_terbaru' => isset($ringkasan['nilai_terbaru']) ? (string) $ringkasan['nilai_terbaru'] : null,
                    'nilai_formatted' => $ringkasan['nilai_formatted'] ?? null,
                    'delta_formatted' => $ringkasan['delta_formatted'] ?? null,
                    'arah_perubahan' => $ringkasan['arah_perubahan'] ?? null,
                    'periode_terbaru' => $ringkasan['periode_terbaru'] ?? null,
                    'periode_pembanding' => $ringkasan['periode_pembanding'] ?? null,
                    'data_series' => $item['data_series'] ?? [],
                    'show_on_home' => $showOnHome,
                    'urutan' => $urutan,
                    'synced_at' => now(),
                ]
            );

            $synced++;
        }

        Cache::forget('home_statistik_makro');

        return [
            'synced' => $synced,
            'total_in_db' => StatistikMakro::count(),
        ];
    }
}
