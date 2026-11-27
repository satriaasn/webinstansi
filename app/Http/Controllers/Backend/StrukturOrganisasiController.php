<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\StrukturOrganisasi;
use App\Services\ImageCompressionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Session;
use Vinkla\Hashids\Facades\Hashids;
use Yajra\Datatables\Datatables;

class StrukturOrganisasiController extends Controller
{
    protected function canAccess(): bool
    {
        return Auth::check() && (Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin'));
    }

    public function index()
    {
        if (!$this->canAccess()) {
            return redirect('dashboard');
        }
        return view('backend.struktur-organisasi.datatable');
    }

    public function anyData(Request $request)
    {
        if (!$this->canAccess()) {
            return response()->json(['data' => []], 403);
        }

        $query = StrukturOrganisasi::leftJoin('struktur_organisasis as parents', 'parents.id', '=', 'struktur_organisasis.parent_id')
            ->select('struktur_organisasis.*', 'parents.jabatan as parent_jabatan');

        if ($request->filled('active') && in_array($request->get('active'), ['Y', 'N'])) {
            $query->where('struktur_organisasis.active', $request->get('active'));
        }

        return Datatables::of($query)
            ->addColumn('check', function ($item) {
                return '<div style="text-align:center;">
                    <input type="checkbox" id="titleCheckdel" />
                    <input type="hidden" class="deldata" name="id[]" value="' . Hashids::encode($item->id) . '" disabled />
                </div>';
            })
            ->addColumn('foto_preview', function ($item) {
                $url = !empty($item->foto) ? berkas($item->foto) : null;
                if ($url) {
                    return '<img src="' . $url . '" alt="" style="width:42px;height:42px;object-fit:cover;border-radius:50%;border:1px solid #cbd5e1;">';
                }
                return '<div style="width:42px;height:42px;border-radius:50%;background:#eff6ff;color:#1d4ed8;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;"><i class="fa fa-user"></i></div>';
            })
            ->addColumn('pejabat_info', function ($item) {
                $nama = $item->nama ? '<strong>' . e($item->nama) . '</strong>' : '<span class="text-muted font-italic">-</span>';
                $nip = $item->nip ? '<br><small class="text-muted">NIP. ' . e($item->nip) . '</small>' : '';
                return $nama . $nip;
            })
            ->addColumn('parent_info', function ($item) {
                return $item->parent_jabatan ? '<span class="tx-12">' . e(\Illuminate\Support\Str::limit($item->parent_jabatan, 40)) . '</span>' : '<span class="badge badge-primary">Root (Pimpinan)</span>';
            })
            ->addColumn('active', function ($item) {
                return $item->active == 'Y'
                    ? '<span class="badge badge-success">Active</span>'
                    : '<span class="badge badge-danger">Non Active</span>';
            })
            ->filterColumn('active', function ($q, $keyword) {
                $kw = strtolower(trim($keyword));
                if (str_contains($kw, 'non') || str_contains($kw, 'tidak') || $kw === 'n') {
                    $q->where('struktur_organisasis.active', 'N');
                } elseif (str_contains($kw, 'act') || str_contains($kw, 'akt') || $kw === 'y') {
                    $q->where('struktur_organisasis.active', 'Y');
                }
            })
            ->addColumn('action', function ($item) {
                $hid = Hashids::encode($item->id);
                return '<div style="text-align:center;">
                    <a href="' . url('dashboard/struktur-organisasi/' . $hid) . '" class="btn btn-secondary btn-sm" title="Preview"><span class="fa fa-eye"></span></a>
                    <a href="' . url('dashboard/struktur-organisasi/' . $hid . '/edit') . '" class="btn btn-primary btn-sm" title="Edit"><span class="fa fa-pencil"></span></a>
                    <a href="' . url('dashboard/struktur-organisasi/' . $hid) . '" class="btn btn-danger btn-sm" data-delete="" title="Delete"><span class="fa fa-trash"></span></a>
                </div>';
            })
            ->addColumn('control', function () {
                return '<div style="text-align:center;"><a href="javascript:void(0);" class="btn btn-secondary btn-sm"><span class="fa fa-plus"></span></a></div>';
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function create()
    {
        if (!$this->canAccess()) {
            return redirect('dashboard');
        }
        $parents = StrukturOrganisasi::orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
        return view('backend.struktur-organisasi.create', compact('parents'));
    }

    public function store(Request $request)
    {
        if (!$this->canAccess()) {
            return redirect('dashboard');
        }

        $this->validate($request, [
            'jabatan' => 'required|string|max:255',
            'tipe_node' => 'required|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:20480',
            'active' => 'required|in:Y,N',
        ]);

        $data = $request->only([
            'parent_id', 'jabatan', 'nama', 'nip', 'pangkat',
            'tmt_pangkat', 'tmt_jabatan', 'tipe_node', 'urutan', 'deskripsi', 'active',
        ]);
        $data['parent_id'] = $request->filled('parent_id') ? $request->input('parent_id') : null;
        $data['urutan'] = (int) $request->input('urutan', 0);
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();

        if ($request->hasFile('foto')) {
            $data['foto'] = app(ImageCompressionService::class)->uploadAndCompress($request->file('foto'));
        }

        StrukturOrganisasi::create($data);
        Cache::forget('struktur_organisasi_tree');

        Session::flash('flash_message', 'Data Struktur Organisasi berhasil ditambahkan!');
        return redirect('dashboard/struktur-organisasi/table');
    }

    public function show($id)
    {
        if (!$this->canAccess()) {
            return redirect('dashboard');
        }
        $ids = Hashids::decode($id);
        $item = StrukturOrganisasi::with(['parent', 'children'])->findOrFail($ids[0]);
        return view('backend.struktur-organisasi.show', compact('item'));
    }

    public function edit($id)
    {
        if (!$this->canAccess()) {
            return redirect('dashboard');
        }
        $ids = Hashids::decode($id);
        $item = StrukturOrganisasi::findOrFail($ids[0]);
        $parents = StrukturOrganisasi::where('id', '!=', $item->id)->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
        return view('backend.struktur-organisasi.edit', compact('item', 'parents'));
    }

    public function update(Request $request, $id)
    {
        if (!$this->canAccess()) {
            return redirect('dashboard');
        }

        $ids = Hashids::decode($id);
        $item = StrukturOrganisasi::findOrFail($ids[0]);

        $this->validate($request, [
            'jabatan' => 'required|string|max:255',
            'tipe_node' => 'required|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:20480',
            'active' => 'required|in:Y,N',
        ]);

        $data = $request->only([
            'parent_id', 'jabatan', 'nama', 'nip', 'pangkat',
            'tmt_pangkat', 'tmt_jabatan', 'tipe_node', 'urutan', 'deskripsi', 'active',
        ]);
        $data['parent_id'] = $request->filled('parent_id') ? $request->input('parent_id') : null;
        $data['urutan'] = (int) $request->input('urutan', 0);
        $data['updated_by'] = Auth::id();

        if ($request->hasFile('foto')) {
            $data['foto'] = app(ImageCompressionService::class)->uploadAndCompress($request->file('foto'));
        }

        $item->update($data);
        Cache::forget('struktur_organisasi_tree');

        Session::flash('flash_message', 'Data Struktur Organisasi berhasil diperbarui!');
        return redirect('dashboard/struktur-organisasi/table');
    }

    public function destroy($id)
    {
        if (!$this->canAccess()) {
            return redirect('dashboard');
        }
        $ids = Hashids::decode($id);
        StrukturOrganisasi::destroy($ids[0]);
        Cache::forget('struktur_organisasi_tree');

        Session::flash('flash_message', 'Data Struktur Organisasi berhasil dihapus!');
        return redirect('dashboard/struktur-organisasi/table');
    }

    public function deleteAll(Request $request)
    {
        if (!$this->canAccess()) {
            return redirect('dashboard');
        }
        if ($request->has('id')) {
            foreach ($request->id as $id) {
                $idd = Hashids::decode($id);
                if (!empty($idd[0])) {
                    StrukturOrganisasi::destroy($idd[0]);
                }
            }
            Cache::forget('struktur_organisasi_tree');
            Session::flash('flash_message', 'Data terpilih berhasil dihapus!');
        } else {
            Session::flash('flash_message', 'Tidak ada data yang dipilih!');
        }
        return redirect('dashboard/struktur-organisasi/table');
    }
}
