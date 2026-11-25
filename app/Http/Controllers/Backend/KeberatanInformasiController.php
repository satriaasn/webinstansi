<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\KeberatanInformasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\Facades\Hashids;
use Yajra\Datatables\Datatables;

class KeberatanInformasiController extends Controller
{
    private function canAccess(): bool
    {
        $user = Auth::user();
        return $user && ($user->hasRole('superadmin') || $user->hasRole('admin') || $user->can('permohonan'));
    }

    public function index()
    {
        if (!$this->canAccess()) {
            return redirect('dashboard');
        }
        return view('backend.keberatan-informasi.datatable');
    }

    public function anyData()
    {
        if (!$this->canAccess()) {
            return response()->json(['data' => []], 403);
        }

        $items = KeberatanInformasi::query()->select('keberatan_informasi.*');

        return Datatables::of($items)
            ->addColumn('check', function ($item) {
                return '<div style="text-align:center;">
                    <input type="checkbox" id="titleCheckdel" />
                    <input type="hidden" class="deldata" name="id[]" value="' . Hashids::encode($item->id) . '" disabled />
                </div>';
            })
            ->addColumn('tanggal_fmt', function ($item) {
                return $item->created_at ? $item->created_at->format('d M Y H:i') : '-';
            })
            ->addColumn('status_badge', function ($item) {
                $b = $item->status_badge;
                return '<span style="display:inline-block;padding:3px 10px;border-radius:9999px;font-size:11px;font-weight:700;background:' . $b['bg'] . ';color:' . $b['color'] . ';border:1px solid ' . $b['border'] . ';">' . e($b['label']) . '</span>';
            })
            ->addColumn('action', function ($item) {
                $hashId = Hashids::encode($item->id);
                $btn = '<div style="text-align:center;white-space:nowrap;">';
                $btn .= '<a href="' . url('dashboard/keberatan-informasi/' . $hashId) . '" class="btn btn-info btn-sm" title="Detail & Tindak Lanjut"><span class="fa fa-eye"></span> Detail</a> ';
                $btn .= '<a href="' . url('dashboard/keberatan-informasi/' . $hashId) . '" class="btn btn-danger btn-sm" data-delete="" title="Hapus"><span class="fa fa-trash"></span></a>';
                $btn .= '</div>';
                return $btn;
            })
            ->addColumn('control', function () {
                return '<div style="text-align:center;"><a href="javascript:void(0);" class="btn btn-secondary btn-sm"><span class="fa fa-plus" /></a></div>';
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function show($id)
    {
        if (!$this->canAccess()) {
            return redirect('dashboard');
        }
        $ids = Hashids::decode($id);
        $keberatan = KeberatanInformasi::findOrFail($ids[0]);
        return view('backend.keberatan-informasi.show', compact('keberatan'));
    }

    public function updateStatus($id, Request $request)
    {
        if (!$this->canAccess()) {
            return redirect('dashboard');
        }
        $ids = Hashids::decode($id);
        $keberatan = KeberatanInformasi::findOrFail($ids[0]);

        $this->validate($request, [
            'status' => 'required|in:pending,diproses,selesai,ditolak',
            'tanggapan' => 'nullable|string',
        ]);

        $keberatan->update([
            'status' => $request->input('status'),
            'tanggapan' => $request->input('tanggapan'),
            'tanggal_respon' => now(),
            'respon_oleh' => Auth::id(),
        ]);

        return redirect()->back()->with('flash_message', 'Status keberatan informasi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        if (!$this->canAccess()) {
            return redirect('dashboard');
        }
        $ids = Hashids::decode($id);
        KeberatanInformasi::findOrFail($ids[0])->delete();
        return redirect('dashboard/keberatan-informasi/table')->with('flash_message', 'Data keberatan berhasil dihapus!');
    }

    public function deleteAll(Request $request)
    {
        if (!$this->canAccess()) {
            return redirect('dashboard');
        }
        $ids = $request->input('id', []);
        if (is_array($ids)) {
            foreach ($ids as $encoded) {
                $decoded = Hashids::decode($encoded);
                if (!empty($decoded[0])) {
                    KeberatanInformasi::where('id', $decoded[0])->delete();
                }
            }
        }
        return redirect('dashboard/keberatan-informasi/table')->with('flash_message', 'Data keberatan terpilih berhasil dihapus!');
    }
}
