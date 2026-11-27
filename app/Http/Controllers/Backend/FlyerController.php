<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Flyer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Session;
use Vinkla\Hashids\Facades\Hashids;
use Yajra\Datatables\Datatables;

class FlyerController extends Controller
{
    private function canAccess(): bool
    {
        $user = Auth::user();
        return $user && ($user->hasRole('superadmin') || $user->hasRole('admin') || $user->can('flyer') || $user->can('slider'));
    }

    public function index()
    {
        if (!$this->canAccess()) {
            return redirect('dashboard');
        }
        return view('backend.flyer.datatable');
    }

    public function getIndex()
    {
        if (!$this->canAccess()) {
            return redirect('dashboard');
        }
        return view('backend.flyer.datatable');
    }

    public function anyData()
    {
        if (!$this->canAccess()) {
            return response()->json(['data' => []], 403);
        }

        $items = Flyer::leftJoin('users', 'users.id', '=', 'flyers.created_by')
            ->select('flyers.*', 'users.name as uname');

        return Datatables::of($items)
            ->addColumn('check', function ($item) {
                return '<div style="text-align:center;">
                    <input type="checkbox" id="titleCheckdel" />
                    <input type="hidden" class="deldata" name="id[]" value="' . Hashids::encode($item->id) . '" disabled />
                </div>';
            })
            ->addColumn('picture_preview', function ($item) {
                $src = berkas($item->picture) ?: url('berkas/' . $item->picture);
                return '<img src="' . e($src) . '" alt="" style="height:40px;border-radius:6px;object-fit:cover;">';
            })
            ->addColumn('active', function ($item) {
                return $item->active == 'Y' ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Non Active</span>';
            })
            ->filterColumn('active', function ($query, $keyword) {
                $kw = strtolower(trim($keyword));
                if (str_contains($kw, 'non') || str_contains($kw, 'tidak') || $kw === 'n' || $kw === '0') {
                    $query->where('flyers.active', 'N');
                } elseif (str_contains($kw, 'act') || str_contains($kw, 'akt') || $kw === 'y' || $kw === '1') {
                    $query->where('flyers.active', 'Y');
                }
            })
            ->addColumn('action', function ($item) {
                $hashId = Hashids::encode($item->id);
                $btn = '<div style="text-align:center;">';
                $btn .= '<a href="' . url('dashboard/flyer/' . $hashId) . '" class="btn btn-secondary btn-sm" title="View"><span class="fa fa-eye" aria-hidden="true"/></a> ';
                $btn .= '<a href="' . url('dashboard/flyer/' . $hashId . '/edit') . '" class="btn btn-primary btn-sm" title="Edit"><span class="fa fa-pencil" aria-hidden="true"/></a> ';
                $btn .= '<a href="' . url('dashboard/flyer/' . $hashId) . '" class="btn btn-danger btn-sm" data-delete="" title="Delete"><span class="fa fa-trash" aria-hidden="true"></span></a>';
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
        return view('backend.flyer.create');
    }

    public function store(Request $request)
    {
        if (!$this->canAccess()) {
            return redirect('dashboard');
        }

        $this->validate($request, [
            'title' => 'required|string|max:255',
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:20480',
            'url' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'active' => 'required|in:Y,N',
        ]);

        $hashImage = '';
        if ($request->hasFile('picture')) {
            $hashImage = app(\App\Services\ImageCompressionService::class)->uploadAndCompress($request->file('picture'));
        }

        Flyer::create([
            'title' => $request->input('title'),
            'picture' => $hashImage,
            'url' => $request->input('url'),
            'description' => $request->input('description'),
            'active' => $request->input('active', 'Y'),
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        Cache::forget('home_flyers');
        Session::flash('flash_message', 'Flyer berhasil ditambahkan!');

        return redirect('dashboard/flyer/table');
    }

    public function show($id)
    {
        if (!$this->canAccess()) {
            return redirect('dashboard');
        }
        $ids = Hashids::decode($id);
        $flyer = Flyer::findOrFail($ids[0]);
        return view('backend.flyer.show', compact('flyer'));
    }

    public function edit($id)
    {
        if (!$this->canAccess()) {
            return redirect('dashboard');
        }
        $ids = Hashids::decode($id);
        $flyer = Flyer::findOrFail($ids[0]);
        return view('backend.flyer.edit', compact('flyer'));
    }

    public function update($id, Request $request)
    {
        if (!$this->canAccess()) {
            return redirect('dashboard');
        }

        $ids = Hashids::decode($id);
        $flyer = Flyer::findOrFail($ids[0]);

        $this->validate($request, [
            'title' => 'required|string|max:255',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:20480',
            'url' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'active' => 'required|in:Y,N',
        ]);

        $data = [
            'title' => $request->input('title'),
            'url' => $request->input('url'),
            'description' => $request->input('description'),
            'active' => $request->input('active', 'Y'),
            'updated_by' => Auth::id(),
        ];

        if ($request->hasFile('picture')) {
            $data['picture'] = app(\App\Services\ImageCompressionService::class)->uploadAndCompress($request->file('picture'));
        }

        $flyer->update($data);

        Cache::forget('home_flyers');
        Session::flash('flash_message', 'Flyer berhasil diperbarui!');

        return redirect('dashboard/flyer/table');
    }

    public function destroy($id)
    {
        if (!$this->canAccess()) {
            return redirect('dashboard');
        }

        $ids = Hashids::decode($id);
        $flyer = Flyer::findOrFail($ids[0]);
        $flyer->delete();

        Cache::forget('home_flyers');
        Session::flash('flash_message', 'Flyer berhasil dihapus!');

        return redirect('dashboard/flyer/table');
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
                    Flyer::where('id', $decoded[0])->delete();
                }
            }
            Cache::forget('home_flyers');
            Session::flash('flash_message', 'Flyer terpilih berhasil dihapus!');
        }

        return redirect('dashboard/flyer/table');
    }
}
