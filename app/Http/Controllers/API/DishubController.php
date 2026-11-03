<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DishubAkdpRoute;
use App\Models\DishubFlightSchedule;
use App\Models\DishubSectionNote;
use App\Models\DishubTerminal;
use App\Models\DishubTollRate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DishubController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $token = $request->header('x-api-token-dishub');
            $validToken = env('API_TOKEN_DISHUB', 'dishub-api-2026');

            if ($token !== $validToken) {
                return response()->json([
                    'success' => false,
                    'message' => 'Token API tidak valid atau tidak ditemukan (x-api-token-dishub).',
                ], 401);
            }

            if (!app()->environment(['local', 'development'])) {
                $allowedHosts = ['dishub.lampungprov.go.id'];

                if (!in_array($request->getHost(), $allowedHosts, true)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Akses API tidak diizinkan dari domain ini.',
                    ], 403);
                }
            }

            return $next($request);
        });
    }

    public function index(): JsonResponse
    {
        $data = [
            'flight_schedules' => DishubFlightSchedule::count(),
            'terminals' => DishubTerminal::count(),
            'akdp_routes' => DishubAkdpRoute::count(),
            'toll_rates' => DishubTollRate::count(),
            'notes' => DishubSectionNote::count(),
        ];

        return response()->json([
            'success' => true,
            'message' => 'Ringkasan layanan API Dishub Lampung.',
            'data' => $data,
            'endpoints' => [
                'flight_schedules' => url('api/dishub/flight-schedules'),
                'terminals' => url('api/dishub/terminals'),
                'akdp_routes' => url('api/dishub/akdp-routes'),
                'toll_rates' => url('api/dishub/toll-rates'),
                'notes' => url('api/dishub/notes'),
            ],
        ]);
    }

    public function flightSchedules(Request $request): JsonResponse
    {
        $query = DishubFlightSchedule::query();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('airline')) {
            $query->where('airline', 'like', '%' . $request->airline . '%');
        }

        $items = $query
            ->orderBy('data_updated_at', 'desc')
            ->orderBy('category')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->map(function (DishubFlightSchedule $item) {
                return [
                    'id' => $item->id,
                    'category' => $item->category,
                    'category_label' => $item->category === 'arrival' ? 'Arrival' : 'Departure',
                    'airline' => $item->airline,
                    'route' => $item->route,
                    'estimated_time' => $item->estimated_time,
                    'operational_days' => $item->operational_days,
                    'notes' => $item->notes,
                    'source' => $item->source,
                    'data_updated_at' => optional($item->data_updated_at)->toDateString(),
                    'sort_order' => $item->sort_order,
                ];
            });

        return $this->listResponse('Jadwal penerbangan berhasil diambil.', $items);
    }

    public function flightScheduleShow(int $id): JsonResponse
    {
        $item = DishubFlightSchedule::find($id);

        if (!$item) {
            return $this->notFound('Data jadwal penerbangan tidak ditemukan.');
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $item->id,
                'category' => $item->category,
                'category_label' => $item->category === 'arrival' ? 'Arrival' : 'Departure',
                'airline' => $item->airline,
                'route' => $item->route,
                'estimated_time' => $item->estimated_time,
                'operational_days' => $item->operational_days,
                'notes' => $item->notes,
                'source' => $item->source,
                'data_updated_at' => optional($item->data_updated_at)->toDateString(),
                'sort_order' => $item->sort_order,
            ],
        ]);
    }

    public function terminals(Request $request): JsonResponse
    {
        $query = DishubTerminal::query();

        if ($request->filled('kabupaten_kota')) {
            $query->where('kabupaten_kota', 'like', '%' . $request->kabupaten_kota . '%');
        }

        $items = $query
            ->orderBy('data_updated_at', 'desc')
            ->orderBy('kabupaten_kota')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->map(function (DishubTerminal $item) {
                return [
                    'id' => $item->id,
                    'group_no' => $item->group_no,
                    'kabupaten_kota' => $item->kabupaten_kota,
                    'nama_terminal' => $item->nama_terminal,
                    'tipe' => $item->tipe,
                    'status_operasional' => $item->status_operasional,
                    'operational_label' => $item->operational_label,
                    'koordinat_label' => $item->koordinat_label,
                    'koordinat_url' => $item->koordinat_url,
                    'data_updated_at' => optional($item->data_updated_at)->toDateString(),
                    'sort_order' => $item->sort_order,
                ];
            });

        if ($request->filled('operational_label')) {
            $wanted = strtolower($request->operational_label);
            $items = $items->filter(fn ($item) => strtolower($item['operational_label']) === $wanted)->values();
        }

        return $this->listResponse('Data terminal berhasil diambil.', $items);
    }

    public function terminalShow(int $id): JsonResponse
    {
        $item = DishubTerminal::find($id);

        if (!$item) {
            return $this->notFound('Data terminal tidak ditemukan.');
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $item->id,
                'group_no' => $item->group_no,
                'kabupaten_kota' => $item->kabupaten_kota,
                'nama_terminal' => $item->nama_terminal,
                'tipe' => $item->tipe,
                'status_operasional' => $item->status_operasional,
                'operational_label' => $item->operational_label,
                'koordinat_label' => $item->koordinat_label,
                'koordinat_url' => $item->koordinat_url,
                'data_updated_at' => optional($item->data_updated_at)->toDateString(),
                'sort_order' => $item->sort_order,
            ],
        ]);
    }

    public function akdpRoutes(Request $request): JsonResponse
    {
        $query = DishubAkdpRoute::query();

        if ($request->filled('wilayah_tujuan')) {
            $query->where('wilayah_tujuan', 'like', '%' . $request->wilayah_tujuan . '%');
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', 'like', '%' . $request->kategori . '%');
        }

        $items = $query
            ->orderBy('data_updated_at', 'desc')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->map(function (DishubAkdpRoute $item) {
                return [
                    'id' => $item->id,
                    'wilayah_tujuan' => $item->wilayah_tujuan,
                    'detail_trayek' => $item->detail_trayek,
                    'keterangan' => $item->keterangan,
                    'kategori' => $item->kategori,
                    'label_aplikasi' => $item->label_aplikasi,
                    'source' => $item->source,
                    'data_updated_at' => optional($item->data_updated_at)->toDateString(),
                    'sort_order' => $item->sort_order,
                ];
            });

        return $this->listResponse('Data trayek AKDP berhasil diambil.', $items);
    }

    public function akdpRouteShow(int $id): JsonResponse
    {
        $item = DishubAkdpRoute::find($id);

        if (!$item) {
            return $this->notFound('Data trayek AKDP tidak ditemukan.');
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $item->id,
                'wilayah_tujuan' => $item->wilayah_tujuan,
                'detail_trayek' => $item->detail_trayek,
                'keterangan' => $item->keterangan,
                'kategori' => $item->kategori,
                'label_aplikasi' => $item->label_aplikasi,
                'source' => $item->source,
                'data_updated_at' => optional($item->data_updated_at)->toDateString(),
                'sort_order' => $item->sort_order,
            ],
        ]);
    }

    public function tollRates(Request $request): JsonResponse
    {
        $query = DishubTollRate::query();

        if ($request->filled('asal_tujuan')) {
            $query->where('asal_tujuan', 'like', '%' . $request->asal_tujuan . '%');
        }

        $items = $query
            ->orderBy('data_updated_at', 'desc')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->map(function (DishubTollRate $item) {
                return [
                    'id' => $item->id,
                    'asal_tujuan' => $item->asal_tujuan,
                    'golongan_i' => $item->golongan_i,
                    'golongan_ii_iii' => $item->golongan_ii_iii,
                    'golongan_iv_v' => $item->golongan_iv_v,
                    'source' => $item->source,
                    'data_updated_at' => optional($item->data_updated_at)->toDateString(),
                    'sort_order' => $item->sort_order,
                ];
            });

        return $this->listResponse('Data tarif tol berhasil diambil.', $items);
    }

    public function tollRateShow(int $id): JsonResponse
    {
        $item = DishubTollRate::find($id);

        if (!$item) {
            return $this->notFound('Data tarif tol tidak ditemukan.');
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $item->id,
                'asal_tujuan' => $item->asal_tujuan,
                'golongan_i' => $item->golongan_i,
                'golongan_ii_iii' => $item->golongan_ii_iii,
                'golongan_iv_v' => $item->golongan_iv_v,
                'source' => $item->source,
                'data_updated_at' => optional($item->data_updated_at)->toDateString(),
                'sort_order' => $item->sort_order,
            ],
        ]);
    }

    public function notes(Request $request): JsonResponse
    {
        $query = DishubSectionNote::query();

        if ($request->filled('section')) {
            $query->where('section', $request->section);
        }

        $items = $query
            ->orderBy('section')
            ->orderBy('data_updated_at', 'desc')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->map(function (DishubSectionNote $item) {
                return [
                    'id' => $item->id,
                    'section' => $item->section,
                    'note' => $item->note,
                    'data_updated_at' => optional($item->data_updated_at)->toDateString(),
                    'sort_order' => $item->sort_order,
                ];
            });

        return $this->listResponse('Catatan dataset berhasil diambil.', $items);
    }

    public function noteShow(int $id): JsonResponse
    {
        $item = DishubSectionNote::find($id);

        if (!$item) {
            return $this->notFound('Catatan dataset tidak ditemukan.');
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $item->id,
                'section' => $item->section,
                'note' => $item->note,
                'data_updated_at' => optional($item->data_updated_at)->toDateString(),
                'sort_order' => $item->sort_order,
            ],
        ]);
    }

    protected function listResponse(string $message, $items): JsonResponse
    {
        $grouped = $items
            ->groupBy('data_updated_at')
            ->map(function ($group, $date) {
                return [
                    'date' => $date,
                    'total' => $group->count(),
                    'items' => $group->values(),
                ];
            })
            ->values();

        return response()->json([
            'success' => true,
            'message' => $message,
            'total' => $items->count(),
            'grouped_by_update_date' => $grouped,
            'data' => $items->values(),
        ]);
    }

    protected function notFound(string $message): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], 404);
    }
}
