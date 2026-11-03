<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\DishubAkdpRoute;
use App\Models\DishubFlightSchedule;
use App\Models\DishubSectionNote;
use App\Models\DishubTerminal;
use App\Models\DishubTollRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Session;
use Vinkla\Hashids\Facades\Hashids;
use Yajra\Datatables\Datatables;

class DishubDataController extends Controller
{
    protected function ensureAuthorized()
    {
        if (!Auth::check() || (!Auth::user()->hasRole('superadmin') && !Auth::user()->hasRole('admin'))) {
            abort(403);
        }
    }

    protected function modules(): array
    {
        return [
            'jadwal-penerbangan' => [
                'title' => 'Jadwal Penerbangan',
                'slug' => 'jadwal-penerbangan',
                'model' => DishubFlightSchedule::class,
                'table' => 'dishub_flight_schedules',
                'order' => [['data_updated_at', 'desc'], ['category', 'asc'], ['sort_order', 'asc'], ['id', 'asc']],
                'fields' => [
                    ['name' => 'category', 'label' => 'Kategori', 'type' => 'select', 'options' => ['arrival' => 'Arrival', 'departure' => 'Departure'], 'required' => true],
                    ['name' => 'airline', 'label' => 'Maskapai', 'type' => 'text', 'required' => true],
                    ['name' => 'route', 'label' => 'Asal / Tujuan', 'type' => 'text', 'required' => true],
                    ['name' => 'estimated_time', 'label' => 'Jam Estimasi', 'type' => 'text', 'required' => true],
                    ['name' => 'operational_days', 'label' => 'Hari Operasional', 'type' => 'text', 'required' => true],
                    ['name' => 'notes', 'label' => 'Catatan', 'type' => 'textarea'],
                    ['name' => 'source', 'label' => 'Sumber', 'type' => 'text'],
                    ['name' => 'data_updated_at', 'label' => 'Tanggal Update Data', 'type' => 'date', 'required' => true],
                    ['name' => 'sort_order', 'label' => 'Urutan', 'type' => 'number', 'help' => 'Opsional. Jika dikosongkan, sistem akan menempatkan data otomatis di urutan paling akhir pada tanggal update yang sama.'],
                ],
                'columns' => [
                    ['data' => 'category_badge', 'name' => 'category', 'label' => 'Kategori'],
                    ['data' => 'airline', 'name' => 'airline', 'label' => 'Maskapai'],
                    ['data' => 'route', 'name' => 'route', 'label' => 'Asal / Tujuan'],
                    ['data' => 'estimated_time', 'name' => 'estimated_time', 'label' => 'Jam Estimasi'],
                    ['data' => 'operational_days', 'name' => 'operational_days', 'label' => 'Hari Operasional'],
                    ['data' => 'data_updated_at_formatted', 'name' => 'data_updated_at', 'label' => 'Tanggal Update'],
                ],
                'rules' => [
                    'category' => 'required|in:arrival,departure',
                    'airline' => 'required|string|max:255',
                    'route' => 'required|string|max:255',
                    'estimated_time' => 'required|string|max:255',
                    'operational_days' => 'required|string|max:255',
                    'notes' => 'nullable|string',
                    'source' => 'nullable|string|max:255',
                    'data_updated_at' => 'required|date',
                    'sort_order' => 'nullable|integer|min:0',
                ],
            ],
            'terminal' => [
                'title' => 'Lokasi Terminal',
                'slug' => 'terminal',
                'model' => DishubTerminal::class,
                'table' => 'dishub_terminals',
                'order' => [['data_updated_at', 'desc'], ['kabupaten_kota', 'asc'], ['sort_order', 'asc'], ['id', 'asc']],
                'fields' => [
                    ['name' => 'group_no', 'label' => 'Nomor Grup', 'type' => 'number'],
                    ['name' => 'kabupaten_kota', 'label' => 'Kabupaten / Kota', 'type' => 'text', 'required' => true],
                    ['name' => 'nama_terminal', 'label' => 'Nama Terminal', 'type' => 'text', 'required' => true],
                    ['name' => 'tipe', 'label' => 'Tipe', 'type' => 'text'],
                    ['name' => 'status_operasional', 'label' => 'Status Operasional / Pengelola', 'type' => 'textarea', 'required' => true],
                    ['name' => 'koordinat_label', 'label' => 'Label Koordinat', 'type' => 'text'],
                    ['name' => 'koordinat_url', 'label' => 'URL Koordinat', 'type' => 'text'],
                    ['name' => 'data_updated_at', 'label' => 'Tanggal Update Data', 'type' => 'date', 'required' => true],
                    ['name' => 'sort_order', 'label' => 'Urutan', 'type' => 'number', 'help' => 'Opsional. Jika kosong, sistem akan mengurutkan otomatis di bagian akhir tanggal update yang sama.'],
                ],
                'columns' => [
                    ['data' => 'kabupaten_kota', 'name' => 'kabupaten_kota', 'label' => 'Kabupaten / Kota'],
                    ['data' => 'nama_terminal', 'name' => 'nama_terminal', 'label' => 'Nama Terminal'],
                    ['data' => 'tipe', 'name' => 'tipe', 'label' => 'Tipe'],
                    ['data' => 'operational_badge', 'name' => 'status_operasional', 'label' => 'Label Status'],
                    ['data' => 'status_operasional', 'name' => 'status_operasional', 'label' => 'Status'],
                    ['data' => 'data_updated_at_formatted', 'name' => 'data_updated_at', 'label' => 'Tanggal Update'],
                ],
                'rules' => [
                    'group_no' => 'nullable|integer|min:1',
                    'kabupaten_kota' => 'required|string|max:255',
                    'nama_terminal' => 'required|string|max:255',
                    'tipe' => 'nullable|string|max:20',
                    'status_operasional' => 'required|string',
                    'koordinat_label' => 'nullable|string|max:255',
                    'koordinat_url' => 'nullable|string|max:255',
                    'data_updated_at' => 'required|date',
                    'sort_order' => 'nullable|integer|min:0',
                ],
            ],
            'trayek-akdp' => [
                'title' => 'Trayek AKDP',
                'slug' => 'trayek-akdp',
                'model' => DishubAkdpRoute::class,
                'table' => 'dishub_akdp_routes',
                'order' => [['data_updated_at', 'desc'], ['sort_order', 'asc'], ['id', 'asc']],
                'fields' => [
                    ['name' => 'wilayah_tujuan', 'label' => 'Wilayah Tujuan', 'type' => 'text', 'required' => true],
                    ['name' => 'detail_trayek', 'label' => 'Detail Trayek', 'type' => 'textarea', 'required' => true],
                    ['name' => 'keterangan', 'label' => 'Keterangan', 'type' => 'text'],
                    ['name' => 'kategori', 'label' => 'Kategori', 'type' => 'text'],
                    ['name' => 'label_aplikasi', 'label' => 'Label Aplikasi', 'type' => 'text'],
                    ['name' => 'source', 'label' => 'Sumber', 'type' => 'text'],
                    ['name' => 'data_updated_at', 'label' => 'Tanggal Update Data', 'type' => 'date', 'required' => true],
                    ['name' => 'sort_order', 'label' => 'Urutan', 'type' => 'number', 'help' => 'Opsional. Jika kosong, sistem menaruh data otomatis di urutan paling akhir untuk tanggal update tersebut.'],
                ],
                'columns' => [
                    ['data' => 'wilayah_tujuan', 'name' => 'wilayah_tujuan', 'label' => 'Wilayah Tujuan'],
                    ['data' => 'detail_trayek', 'name' => 'detail_trayek', 'label' => 'Detail Trayek'],
                    ['data' => 'keterangan', 'name' => 'keterangan', 'label' => 'Ket.'],
                    ['data' => 'kategori', 'name' => 'kategori', 'label' => 'Kategori'],
                    ['data' => 'data_updated_at_formatted', 'name' => 'data_updated_at', 'label' => 'Tanggal Update'],
                ],
                'rules' => [
                    'wilayah_tujuan' => 'required|string|max:255',
                    'detail_trayek' => 'required|string',
                    'keterangan' => 'nullable|string|max:100',
                    'kategori' => 'nullable|string|max:100',
                    'label_aplikasi' => 'nullable|string|max:100',
                    'source' => 'nullable|string|max:255',
                    'data_updated_at' => 'required|date',
                    'sort_order' => 'nullable|integer|min:0',
                ],
            ],
            'tarif-tol' => [
                'title' => 'Tarif Tol',
                'slug' => 'tarif-tol',
                'model' => DishubTollRate::class,
                'table' => 'dishub_toll_rates',
                'order' => [['data_updated_at', 'desc'], ['sort_order', 'asc'], ['id', 'asc']],
                'fields' => [
                    ['name' => 'asal_tujuan', 'label' => 'Asal / Tujuan', 'type' => 'text', 'required' => true],
                    ['name' => 'golongan_i', 'label' => 'Golongan I', 'type' => 'text', 'required' => true],
                    ['name' => 'golongan_ii_iii', 'label' => 'Golongan II & III', 'type' => 'text', 'required' => true],
                    ['name' => 'golongan_iv_v', 'label' => 'Golongan IV & V', 'type' => 'text', 'required' => true],
                    ['name' => 'source', 'label' => 'Sumber', 'type' => 'text'],
                    ['name' => 'data_updated_at', 'label' => 'Tanggal Update Data', 'type' => 'date', 'required' => true],
                    ['name' => 'sort_order', 'label' => 'Urutan', 'type' => 'number', 'help' => 'Opsional. Sistem akan memberi urutan otomatis jika tidak diisi.'],
                ],
                'columns' => [
                    ['data' => 'asal_tujuan', 'name' => 'asal_tujuan', 'label' => 'Asal / Tujuan'],
                    ['data' => 'golongan_i', 'name' => 'golongan_i', 'label' => 'Golongan I'],
                    ['data' => 'golongan_ii_iii', 'name' => 'golongan_ii_iii', 'label' => 'Golongan II & III'],
                    ['data' => 'golongan_iv_v', 'name' => 'golongan_iv_v', 'label' => 'Golongan IV & V'],
                    ['data' => 'data_updated_at_formatted', 'name' => 'data_updated_at', 'label' => 'Tanggal Update'],
                ],
                'rules' => [
                    'asal_tujuan' => 'required|string|max:255',
                    'golongan_i' => 'required|string|max:100',
                    'golongan_ii_iii' => 'required|string|max:100',
                    'golongan_iv_v' => 'required|string|max:100',
                    'source' => 'nullable|string|max:255',
                    'data_updated_at' => 'required|date',
                    'sort_order' => 'nullable|integer|min:0',
                ],
            ],
            'catatan' => [
                'title' => 'Catatan Dataset',
                'slug' => 'catatan',
                'model' => DishubSectionNote::class,
                'table' => 'dishub_section_notes',
                'order' => [['section', 'asc'], ['data_updated_at', 'desc'], ['sort_order', 'asc'], ['id', 'asc']],
                'fields' => [
                    ['name' => 'section', 'label' => 'Bagian', 'type' => 'select', 'options' => [
                        'flight_schedule' => 'Jadwal Penerbangan',
                        'terminal' => 'Lokasi Terminal',
                        'akdp_route' => 'Trayek AKDP',
                        'toll_rate' => 'Tarif Tol',
                    ], 'required' => true],
                    ['name' => 'note', 'label' => 'Catatan', 'type' => 'textarea', 'required' => true],
                    ['name' => 'data_updated_at', 'label' => 'Tanggal Update Data', 'type' => 'date', 'required' => true],
                    ['name' => 'sort_order', 'label' => 'Urutan', 'type' => 'number', 'help' => 'Opsional. Sistem akan mengisi otomatis jika dikosongkan.'],
                ],
                'columns' => [
                    ['data' => 'section_label', 'name' => 'section', 'label' => 'Bagian'],
                    ['data' => 'note', 'name' => 'note', 'label' => 'Catatan'],
                    ['data' => 'data_updated_at_formatted', 'name' => 'data_updated_at', 'label' => 'Tanggal Update'],
                ],
                'rules' => [
                    'section' => 'required|in:flight_schedule,terminal,akdp_route,toll_rate',
                    'note' => 'required|string',
                    'data_updated_at' => 'required|date',
                    'sort_order' => 'nullable|integer|min:0',
                ],
            ],
        ];
    }

    protected function module(string $module): array
    {
        $modules = $this->modules();

        abort_unless(isset($modules[$module]), 404);

        return $modules[$module];
    }

    protected function modelInstance(array $module)
    {
        return app($module['model']);
    }

    public function index(string $module)
    {
        $this->ensureAuthorized();

        return view('backend.dishub.datatable', ['module' => $this->module($module)]);
    }

    public function anyData(string $module)
    {
        $this->ensureAuthorized();

        $moduleConfig = $this->module($module);
        $query = $this->modelInstance($moduleConfig)->newQuery();

        foreach ($moduleConfig['order'] as $order) {
            $query->orderBy($order[0], $order[1]);
        }

        return Datatables::of($query)
            ->addColumn('check', function ($row) {
                return '<div style="text-align:center;">
                    <input type="checkbox" id="titleCheckdel" />
                    <input type="hidden" class="deldata" name="id[]" value="' . Hashids::encode($row->id) . '" disabled />
                </div>';
            })
            ->addColumn('category_badge', function ($row) {
                if (!isset($row->category)) {
                    return '';
                }

                $label = $row->category === 'arrival' ? 'Arrival' : 'Departure';
                $class = $row->category === 'arrival' ? 'success' : 'primary';

                return '<span class="badge badge-' . $class . '">' . $label . '</span>';
            })
            ->addColumn('section_label', function ($row) {
                $labels = [
                    'flight_schedule' => 'Jadwal Penerbangan',
                    'terminal' => 'Lokasi Terminal',
                    'akdp_route' => 'Trayek AKDP',
                    'toll_rate' => 'Tarif Tol',
                ];

                return $labels[$row->section] ?? $row->section;
            })
            ->addColumn('operational_badge', function ($row) {
                if (!isset($row->status_operasional)) {
                    return '';
                }

                return '<span class="badge badge-' . $row->operational_badge . '">' . $row->operational_label . '</span>';
            })
            ->addColumn('data_updated_at_formatted', function ($row) {
                return optional($row->data_updated_at)->format('d-m-Y') ?: '-';
            })
            ->addColumn('action', function ($row) use ($moduleConfig) {
                $base = url('dashboard/dishub/' . $moduleConfig['slug']);
                $id = Hashids::encode($row->id);

                return '<div style="text-align:center;">'
                    . '<a href="' . $base . '/' . $id . '" class="btn btn-secondary btn-sm" title="View"><span class="fa fa-eye" aria-hidden="true"></span></a> '
                    . '<a href="' . $base . '/' . $id . '/edit" class="btn btn-primary btn-sm" title="Edit"><span class="fa fa-pencil" aria-hidden="true"></span></a> '
                    . '<a href="' . $base . '/' . $id . '" class="btn btn-danger btn-sm" data-delete="" title="Delete"><span class="fa fa-trash" aria-hidden="true"></span></a>'
                    . '</div>';
            })
            ->addColumn('control', function () {
                return '<div style="text-align:center;"><a href="javascript:void(0);" class="btn btn-secondary btn-sm"><span class="fa fa-plus"></span></a></div>';
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function create(string $module)
    {
        $this->ensureAuthorized();

        return view('backend.dishub.form', [
            'module' => $this->module($module),
            'item' => null,
            'method' => 'POST',
            'action' => url('dashboard/dishub/' . $module),
        ]);
    }

    public function store(string $module, Request $request)
    {
        $this->ensureAuthorized();

        $moduleConfig = $this->module($module);
        $validated = $request->validate($moduleConfig['rules']);
        $validated = $this->prepareRequestData($moduleConfig, $validated);

        $this->modelInstance($moduleConfig)->create($validated);

        Session::flash('flash_message', $moduleConfig['title'] . ' berhasil ditambahkan.');

        return redirect('dashboard/dishub/' . $module . '/table');
    }

    public function show(string $module, string $id)
    {
        $this->ensureAuthorized();

        $moduleConfig = $this->module($module);
        $item = $this->findItem($moduleConfig, $id);

        return view('backend.dishub.show', compact('moduleConfig', 'item'))->with('module', $moduleConfig);
    }

    public function edit(string $module, string $id)
    {
        $this->ensureAuthorized();

        $moduleConfig = $this->module($module);
        $item = $this->findItem($moduleConfig, $id);

        return view('backend.dishub.form', [
            'module' => $moduleConfig,
            'item' => $item,
            'method' => 'PATCH',
            'action' => url('dashboard/dishub/' . $module . '/' . $id),
        ]);
    }

    public function update(string $module, string $id, Request $request)
    {
        $this->ensureAuthorized();

        $moduleConfig = $this->module($module);
        $validated = $request->validate($moduleConfig['rules']);
        $validated = $this->prepareRequestData($moduleConfig, $validated, $id);
        $item = $this->findItem($moduleConfig, $id);
        $item->update($validated);

        Session::flash('flash_message', $moduleConfig['title'] . ' berhasil diperbarui.');

        return redirect('dashboard/dishub/' . $module . '/table');
    }

    public function destroy(string $module, string $id)
    {
        $this->ensureAuthorized();

        $moduleConfig = $this->module($module);
        $item = $this->findItem($moduleConfig, $id);
        $item->delete();

        Session::flash('flash_message', $moduleConfig['title'] . ' berhasil dihapus.');

        return redirect('dashboard/dishub/' . $module . '/table');
    }

    public function deleteAll(string $module, Request $request)
    {
        $this->ensureAuthorized();

        $moduleConfig = $this->module($module);
        $model = $this->modelInstance($moduleConfig);
        $ids = $request->input('id', []);

        foreach ($ids as $encodedId) {
            $decoded = Hashids::decode($encodedId);
            if (!empty($decoded[0])) {
                $model->newQuery()->where('id', $decoded[0])->delete();
            }
        }

        Session::flash('flash_message', $moduleConfig['title'] . ' terpilih berhasil dihapus.');

        return redirect('dashboard/dishub/' . $module . '/table');
    }

    protected function findItem(array $moduleConfig, string $id)
    {
        $decoded = Hashids::decode($id);
        abort_if(empty($decoded[0]), 404);

        return $this->modelInstance($moduleConfig)->findOrFail($decoded[0]);
    }

    protected function prepareRequestData(array $moduleConfig, array $validated, ?string $encodedId = null): array
    {
        if (!empty($validated['data_updated_at'])) {
            $validated['data_updated_at'] = Carbon::parse($validated['data_updated_at'])->toDateString();
        }

        if ($validated['sort_order'] === null || $validated['sort_order'] === '') {
            $validated['sort_order'] = $this->resolveNextSortOrder($moduleConfig, $validated, $encodedId);
        }

        return $validated;
    }

    protected function resolveNextSortOrder(array $moduleConfig, array $validated, ?string $encodedId = null): int
    {
        $query = $this->modelInstance($moduleConfig)->newQuery()
            ->whereDate('data_updated_at', $validated['data_updated_at']);

        if (isset($validated['category'])) {
            $query->where('category', $validated['category']);
        }

        if (isset($validated['section'])) {
            $query->where('section', $validated['section']);
        }

        if ($encodedId !== null) {
            $decoded = Hashids::decode($encodedId);
            if (!empty($decoded[0])) {
                $query->where('id', '!=', $decoded[0]);
            }
        }

        return ((int) $query->max('sort_order')) + 1;
    }
}
