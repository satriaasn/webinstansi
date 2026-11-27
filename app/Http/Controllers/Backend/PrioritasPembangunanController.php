<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PrioritasPembangunan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Session;
use Vinkla\Hashids\Facades\Hashids;
use Yajra\Datatables\Datatables;

class PrioritasPembangunanController extends Controller
{
    private function canAccess(): bool
    {
        $user = Auth::user();
        return $user && ($user->hasRole('superadmin') || $user->hasRole('admin') || $user->can('prioritas'));
    }

    public function index()
    {
        if (!$this->canAccess()) {
            return redirect('dashboard');
        }
        return view('backend.prioritas.datatable');
    }

    public function getIndex()
    {
        if (!$this->canAccess()) {
            return redirect('dashboard');
        }
        return view('backend.prioritas.datatable');
    }

    public function anyData()
    {
        if (!$this->canAccess()) {
            return response()->json(['data' => []], 403);
        }

        $items = PrioritasPembangunan::leftJoin('users', 'users.id', '=', 'prioritas_pembangunans.created_by')
            ->select('prioritas_pembangunans.*', 'users.name as uname');

        return Datatables::of($items)
            ->addColumn('check', function ($item) {
                return '<div style="text-align:center;">
                    <input type="checkbox" id="titleCheckdel" />
                    <input type="hidden" class="deldata" name="id[]" value="' . Hashids::encode($item->id) . '" disabled />
                </div>';
            })
            ->addColumn('active', function ($item) {
                return $item->active == 'Y' ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Non Active</span>';
            })
            ->filterColumn('active', function ($query, $keyword) {
                $kw = strtolower(trim($keyword));
                if (str_contains($kw, 'non') || str_contains($kw, 'tidak') || $kw === 'n' || $kw === '0') {
                    $query->where('prioritas_pembangunans.active', 'N');
                } elseif (str_contains($kw, 'act') || str_contains($kw, 'akt') || $kw === 'y' || $kw === '1') {
                    $query->where('prioritas_pembangunans.active', 'Y');
                }
            })
            ->addColumn('action', function ($item) {
                $hashId = Hashids::encode($item->id);
                $btn = '<div style="text-align:center;">';
                $btn .= '<a href="' . url('dashboard/prioritas/' . $hashId) . '" class="btn btn-secondary btn-sm" title="View"><span class="fa fa-eye" aria-hidden="true"/></a> ';
                $btn .= '<a href="' . url('dashboard/prioritas/' . $hashId . '/edit') . '" class="btn btn-primary btn-sm" title="Edit"><span class="fa fa-pencil" aria-hidden="true"/></a> ';
                $btn .= '<a href="' . url('dashboard/prioritas/' . $hashId) . '" class="btn btn-danger btn-sm" data-delete="" title="Delete"><span class="fa fa-trash" aria-hidden="true"></span></a>';
                $btn .= '</div>';
                return $btn;
            })
            ->addColumn('control', function () {
                return '<div style="text-align:center;"><a href="javascript:void(0);" class="btn btn-secondary btn-sm"><span class="fa fa-plus" /></a></div>';
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function create()
    {
        if (!$this->canAccess()) {
            return redirect('dashboard');
        }
        return view('backend.prioritas.create');
    }

    public function store(Request $request)
    {
        if (!$this->canAccess()) {
            return redirect('dashboard');
        }

        $this->validate($request, [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'urutan' => 'nullable|integer|min:0',
            'active' => 'required|in:Y,N',
        ]);

        PrioritasPembangunan::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'icon' => $request->input('icon') ?: 'fas fa-bullseye',
            'urutan' => (int) ($request->input('urutan') ?? 0),
            'active' => $request->input('active', 'Y'),
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        Cache::forget('home_prioritas');
        Session::flash('flash_message', 'Prioritas Pembangunan berhasil ditambahkan!');

        return redirect('dashboard/prioritas/table');
    }

    public function show($id)
    {
        if (!$this->canAccess()) {
            return redirect('dashboard');
        }
        $ids = Hashids::decode($id);
        $prioritas = PrioritasPembangunan::findOrFail($ids[0]);
        return view('backend.prioritas.show', compact('prioritas'));
    }

    public function edit($id)
    {
        if (!$this->canAccess()) {
            return redirect('dashboard');
        }
        $ids = Hashids::decode($id);
        $prioritas = PrioritasPembangunan::findOrFail($ids[0]);
        return view('backend.prioritas.edit', compact('prioritas'));
    }

    public function update($id, Request $request)
    {
        if (!$this->canAccess()) {
            return redirect('dashboard');
        }

        $ids = Hashids::decode($id);
        $prioritas = PrioritasPembangunan::findOrFail($ids[0]);

        $this->validate($request, [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'urutan' => 'nullable|integer|min:0',
            'active' => 'required|in:Y,N',
        ]);

        $prioritas->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'icon' => $request->input('icon') ?: 'fas fa-bullseye',
            'urutan' => (int) ($request->input('urutan') ?? 0),
            'active' => $request->input('active', 'Y'),
            'updated_by' => Auth::id(),
        ]);

        Cache::forget('home_prioritas');
        Session::flash('flash_message', 'Prioritas Pembangunan berhasil diperbarui!');

        return redirect('dashboard/prioritas/table');
    }

    public function destroy($id)
    {
        if (!$this->canAccess()) {
            return redirect('dashboard');
        }

        $ids = Hashids::decode($id);
        $prioritas = PrioritasPembangunan::findOrFail($ids[0]);
        $prioritas->delete();

        Cache::forget('home_prioritas');
        Session::flash('flash_message', 'Prioritas Pembangunan berhasil dihapus!');

        return redirect('dashboard/prioritas/table');
    }

    public function deleteAll(Request $request)
    {
        if (!$this->canAccess()) {
            return redirect('dashboard');
        }

        $ids = $request->input('id', []);
        if (is_array($ids) && count($ids) > 0) {
            foreach ($ids as $encodedId) {
                $decoded = Hashids::decode($encodedId);
                if (!empty($decoded[0])) {
                    PrioritasPembangunan::where('id', $decoded[0])->delete();
                }
            }
            Cache::forget('home_prioritas');
            Session::flash('flash_message', 'Data terpilih berhasil dihapus!');
        }

        return redirect('dashboard/prioritas/table');
    }
}
