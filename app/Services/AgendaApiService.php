<?php

namespace App\Services;

use App\Models\Agenda;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AgendaApiService
{
    protected string $baseUrl;
    protected ?string $apiKey;
    protected bool $verifySsl;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.agenda.base_url', env('AGENDA_API_URL', 'https://sektrabappeda.my.id/api/v1')), '/');
        $this->apiKey = config('services.agenda.api_key', env('AGENDA_API_KEY'));
        $this->verifySsl = (bool) config('services.agenda.verify_ssl', env('AGENDA_API_VERIFY_SSL', false));
    }

    /**
     * Create configured HTTP client instance.
     */
    protected function getClient()
    {
        $headers = [
            'Accept' => 'application/json',
            'User-Agent' => 'WebInstansiBappeda/1.0',
        ];

        if (!empty($this->apiKey)) {
            $headers['X-API-KEY'] = $this->apiKey;
            $headers['Authorization'] = 'Bearer ' . $this->apiKey;
        }

        $client = Http::withHeaders($headers)->timeout(20);

        if (!$this->verifySsl) {
            $client = $client->withoutVerifying();
        }

        return $client;
    }

    /**
     * Fetch paginated agendas from API.
     */
    public function fetchAgendas(array $params = []): ?array
    {
        try {
            $response = $this->getClient()->get("{$this->baseUrl}/agenda", $params);
            if ($response->successful()) {
                return $response->json();
            }

            Log::warning('AgendaApiService::fetchAgendas failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        } catch (\Throwable $e) {
            Log::error('AgendaApiService::fetchAgendas exception: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Fetch upcoming agendas.
     */
    public function fetchUpcoming(int $limit = 10): ?array
    {
        try {
            $response = $this->getClient()->get("{$this->baseUrl}/agenda/upcoming", [
                'limit' => $limit,
            ]);
            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Throwable $e) {
            Log::error('AgendaApiService::fetchUpcoming exception: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Fetch today's agendas.
     */
    public function fetchToday(): ?array
    {
        try {
            $response = $this->getClient()->get("{$this->baseUrl}/agenda/today");
            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Throwable $e) {
            Log::error('AgendaApiService::fetchToday exception: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Fetch detail of an agenda by UUID.
     */
    public function fetchDetail(string $id): ?array
    {
        try {
            $response = $this->getClient()->get("{$this->baseUrl}/agenda/{$id}");
            if ($response->successful()) {
                $json = $response->json();
                return $json['data'] ?? null;
            }
        } catch (\Throwable $e) {
            Log::error("AgendaApiService::fetchDetail exception for {$id}: " . $e->getMessage());
        }

        return null;
    }

    /**
     * Sync a single API agenda item into the local database.
     */
    public function syncItem(array $item): ?Agenda
    {
        if (empty($item['id']) || empty($item['judul'])) {
            return null;
        }

        $apiId = (string) $item['id'];
        $title = trim($item['judul']);

        // Check if existing record by api_id
        $agenda = Agenda::where('api_id', $apiId)->first();

        // Calculate start & end datetime
        $tanggal = !empty($item['tanggal']) ? $item['tanggal'] : date('Y-m-d');
        $waktuMulai = !empty($item['waktu_mulai']) ? $item['waktu_mulai'] : '08:00';
        $waktuSelesai = !empty($item['waktu_selesai']) ? $item['waktu_selesai'] : null;

        try {
            $start = Carbon::parse("{$tanggal} {$waktuMulai}")->format('Y-m-d H:i:s');
        } catch (\Throwable) {
            $start = date('Y-m-d 08:00:00');
        }

        if ($waktuSelesai) {
            try {
                $end = Carbon::parse("{$tanggal} {$waktuSelesai}")->format('Y-m-d H:i:s');
            } catch (\Throwable) {
                $end = Carbon::parse($start)->addHours(2)->format('Y-m-d H:i:s');
            }
        } else {
            $end = Carbon::parse($start)->addHours(2)->format('Y-m-d H:i:s');
        }

        // Generate safe unique seotitle
        if (!$agenda) {
            $baseSlug = Str::limit(Str::slug($title), 180, '');
            if (empty($baseSlug)) {
                $baseSlug = 'agenda-' . substr($apiId, 0, 8);
            }
            $slug = $baseSlug;
            $counter = 1;
            while (Agenda::where('seotitle', $slug)->exists()) {
                $slug = Str::limit($baseSlug, 160, '') . '-' . substr($apiId, 0, 6) . ($counter > 1 ? "-{$counter}" : '');
                $counter++;
            }
            $agenda = new Agenda();
            $agenda->api_id = $apiId;
            $agenda->seotitle = $slug;
            $agenda->created_by = 1;
        }

        // Location data
        $lokasi = !empty($item['lokasi']) ? trim($item['lokasi']) : null;

        // Content / Deskripsi
        $deskripsi = !empty($item['deskripsi']) ? trim($item['deskripsi']) : null;
        if (!empty($deskripsi)) {
            $content = $deskripsi;
        } else {
            // When API deskripsi is empty, provide a clean structured placeholder content
            $content = $lokasi ? "<p>Kegiatan diselenggarakan di: <strong>{$lokasi}</strong>.</p>" : "<p>Agenda resmi Bappeda Provinsi Lampung.</p>";
        }

        // Metadata JSON for rich agenda details
        $metadata = [
            'sumber_agenda_raw' => $item['sumber_agenda'] ?? null,
            'sumber_agenda_label' => $item['sumber_agenda_label'] ?? null,
            'nomor_agenda_gubernur' => $item['nomor_agenda_gubernur'] ?? null,
            'tanggal_formatted' => $item['tanggal_formatted'] ?? null,
            'waktu_formatted' => $item['waktu_formatted'] ?? null,
            'peserta_count' => $item['peserta_count'] ?? count($item['peserta'] ?? []),
            'peserta' => $item['peserta'] ?? [],
            'bidang_terkait' => $item['bidang_terkait'] ?? [],
            'creator' => $item['creator'] ?? null,
            'surat_masuk' => $item['surat_masuk'] ?? null,
            'synced_at' => now()->toIso8601String(),
        ];

        $agenda->title = $title;
        $agenda->start = $start;
        $agenda->end = $end;
        $agenda->allday = 0;
        $agenda->content = $content;
        $agenda->location = $lokasi;
        $agenda->pakaian = !empty($item['pakaian']) ? trim($item['pakaian']) : null;
        $agenda->penyelenggara = !empty($item['penyelenggara']) ? trim($item['penyelenggara']) : 'Badan Perencanaan Pembangunan Daerah Provinsi Lampung';
        $agenda->sumber_agenda = $item['sumber_agenda_label'] ?? $item['sumber_agenda'] ?? 'Internal Bappeda';
        $agenda->status_waktu = $item['status_waktu'] ?? null;
        $agenda->metadata = $metadata;
        $agenda->color = '#1A56DB';
        $agenda->active = 'Y';
        $agenda->updated_by = 1;

        $agenda->save();

        return $agenda;
    }

    /**
     * Sync recent or upcoming agendas.
     *
     * @param int $pages Number of pages to sync
     * @param int $perPage Items per page
     * @return array [ 'synced' => int, 'errors' => int ]
     */
    public function syncRecent(int $pages = 3, int $perPage = 30): array
    {
        $synced = 0;
        $errors = 0;

        for ($page = 1; $page <= $pages; $page++) {
            $result = $this->fetchAgendas([
                'page' => $page,
                'per_page' => $perPage,
                'sort_by' => 'tanggal',
                'sort_dir' => 'desc',
            ]);

            if (empty($result['data']) || !is_array($result['data'])) {
                break;
            }

            foreach ($result['data'] as $item) {
                try {
                    if ($this->syncItem($item)) {
                        $synced++;
                    }
                } catch (\Throwable $e) {
                    $errors++;
                    Log::error("Failed to sync agenda item: " . $e->getMessage(), ['item' => $item]);
                }
            }

            // If we reached the last page
            $pagination = $result['pagination'] ?? [];
            if (!empty($pagination['total_pages']) && $page >= $pagination['total_pages']) {
                break;
            }
        }

        // Also ensure upcoming agendas are fetched and updated
        $upcoming = $this->fetchUpcoming(20);
        if (!empty($upcoming['data']) && is_array($upcoming['data'])) {
            foreach ($upcoming['data'] as $item) {
                try {
                    $this->syncItem($item);
                } catch (\Throwable) {
                    // Ignore duplicate sync errors
                }
            }
        }

        // Clear relevant caches
        $this->clearCaches();

        return [
            'synced' => $synced,
            'errors' => $errors,
        ];
    }

    /**
     * Sync all agendas from API.
     */
    public function syncAll(): array
    {
        // Set high page count, loop will break when last page is reached
        return $this->syncRecent(50, 50);
    }

    /**
     * Clear caches associated with agendas.
     */
    public function clearCaches(): void
    {
        Cache::forget('home_latest_agendas_v2');
        for ($i = 1; $i <= 10; $i++) {
            Cache::forget("agenda_{$i}_0");
        }
    }
}
