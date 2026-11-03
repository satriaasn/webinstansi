<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\PendaftaranLayanan;
use Session;

use Yajra\Datatables\Datatables;
use Vinkla\Hashids\Facades\Hashids;

class PendaftarSosialController extends Controller
{
    public function index()
    {
        if (Auth::user()->can('pendaftar-sosial') || Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin')) {
            return view('backend.pendaftar-sosial.datatable');
        } else {
            return redirect('dashboard');
        }
    }

    public function getIndex()
    {
        if (Auth::user()->can('pendaftar-sosial') || Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin')) {
            return view('backend.pendaftar-sosial.datatable');
        } else {
            return redirect('dashboard');
        }
    }

    public function anyData()
    {
        $pendaftar = PendaftaranLayanan::with('layanan')->select('pendaftaran_layanan.*');
        return Datatables::of($pendaftar)
            ->addColumn('check', function ($row) {
                $check = '<div style="text-align:center;">
					<input type="checkbox" id="titleCheckdel" />
					<input type="hidden" class="deldata" name="id[]" value="' . Hashids::encode($row->id) . '" disabled />
				</div>';
                return $check;
            })
            ->addColumn('layanan_nama', function ($row) {
                return $row->layanan->nama ?? '-';
            })
            ->editColumn('status', function ($row) {
                $badge = $row->status_badge;
                return '<span class="badge badge-'.$badge.'">'.$row->status_label.'</span>';
            })
            ->addColumn('action', function ($row) {
                $btn = '<div style="text-align:center;">';
                $btn .= '<a href="' . url('dashboard/pendaftar-sosial/' . Hashids::encode($row->id) . '') . '" class="btn btn-secondary btn-sm" title="View"><span class="fa fa-eye" aria-hidden="true"/></a> ';
                $btn .= '<a href="' . url('dashboard/pendaftar-sosial/' . Hashids::encode($row->id) . '/edit') . '" class="btn btn-primary btn-sm" title="Edit Status/Catatan"><span class="fa fa-pencil" aria-hidden="true"/></a> ';
                $btn .= '<a href="' . url('dashboard/pendaftar-sosial/' . Hashids::encode($row->id) . '') . '" class="btn btn-danger btn-sm" data-delete="" title="Delete"><span class="fa fa-trash" aria-hidden="true"></span></a>';
                $btn .= '</div>';
                return $btn;
            })
            ->addColumn('control', function ($row) {
                $check = '<div style="text-align:center;"><a href="javascript:void(0);" class="btn btn-secondary btn-sm"><span class="fa fa-plus" /></a></div>';
                return $check;
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function show($id)
    {
        if (Auth::user()->can('pendaftar-sosial') || Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin')) {
            $ids = Hashids::decode($id);
            $pendaftaran = PendaftaranLayanan::with('layanan')->findOrFail($ids[0]);
            return view('backend.pendaftar-sosial.show', compact('pendaftaran'));
        } else {
            return redirect('dashboard');
        }
    }

    public function edit($id)
    {
        if (Auth::user()->can('pendaftar-sosial') || Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin')) {
            $ids = Hashids::decode($id);
            $pendaftaran = PendaftaranLayanan::findOrFail($ids[0]);
            return view('backend.pendaftar-sosial.edit', compact('pendaftaran'));
        } else {
            return redirect('dashboard');
        }
    }

    public function update($id, Request $request)
    {
        if (Auth::user()->can('pendaftar-sosial') || Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin')) {
            $ids = Hashids::decode($id);

            $rule = [
                'status' => 'required',
            ];
            $this->validate($request, $rule);
            
            $pendaftaran = PendaftaranLayanan::findOrFail($ids[0]);
            $pendaftaran->update([
                'status' => $request->status,
                'catatan_petugas' => $request->catatan_petugas,
            ]);

            Session::flash('flash_message', 'Status Pendaftaran Layanan diperbarui!');

            return redirect('dashboard/pendaftar-sosial/table');
        } else {
            return redirect('dashboard');
        }
    }

    public function destroy($id)
    {
        if (Auth::user()->can('pendaftar-sosial') || Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin')) {
            $ids = Hashids::decode($id);
            PendaftaranLayanan::destroy($ids[0]);

            Session::flash('flash_message', 'Pendaftaran dihapus!');

            return redirect('dashboard/pendaftar-sosial/table');
        } else {
            return redirect('dashboard');
        }
    }

    public function deleteAll(Request $request)
    {
        if (Auth::user()->can('pendaftar-sosial') || Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin')) {
            if ($request->has('id')) {
                $ids = $request->id;
                foreach ($ids as $id) {
                    $idd = Hashids::decode($id);
                    PendaftaranLayanan::destroy($idd[0]);
                }
                Session::flash('flash_message', 'Data deleted!');
            } else {
                Session::flash('flash_message', 'No data deleted!');
            }

            return redirect('dashboard/pendaftar-sosial/table');
        } else {
            return redirect('dashboard');
        }
    }
}
