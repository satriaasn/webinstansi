<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Gallery;
use App\Models\Album;
use App\Models\User;
use Session;

use Yajra\Datatables\Datatables;
use Vinkla\Hashids\Facades\Hashids;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (Auth::user()->can('gallery')) {
            return view('backend.gallery.datatable');
        } else {
            return redirect('dashboard');
        }
    }

    /**
     * Displays datatables front end view
     *
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        if (Auth::user()->can('gallery')) {
            return view('backend.gallery.datatable');
        } else {
            return redirect('dashboard');
        }
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData()
    {
        if (Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin')) {
            $gallerys = Gallery::leftJoin('users', 'users.id', '=', 'gallerys.created_by')
                ->leftJoin('albums', 'albums.id', '=', 'gallerys.album_id')
                ->select('gallerys.*', 'users.id as uid', 'users.name as uname', 'albums.id as aid', 'albums.title as atitle');
        } else {
            $gallerys = Gallery::leftJoin('users', 'users.id', '=', 'gallerys.created_by')
                ->leftJoin('albums', 'albums.id', '=', 'gallerys.album_id')
                ->where('gallerys.created_by', '=', Auth::user()->id)
                ->select('gallerys.*', 'users.id as uid', 'users.name as uname', 'albums.id as aid', 'albums.title as atitle');
        }
        return Datatables::of($gallerys)
            ->addColumn('check', function ($gallery) {
                $check = '<div style="text-align:center;">
					<input type="checkbox" id="titleCheckdel" />
					<input type="hidden" class="deldata" name="id[]" value="' . Hashids::encode($gallery->id) . '" disabled />
				</div>';
                return $check;
            })
            ->addColumn('active', function ($gallery) {
                return $gallery->active == 'Y' ? 'Active' : 'Non Active';
            })
            ->addColumn('action', function ($gallery) {
                $btn = '<div style="text-align:center;">';
                $btn .= '<a href="' . url('dashboard/gallery/' . Hashids::encode($gallery->id) . '') . '" class="btn btn-secondary btn-sm" title="View"><span class="fa fa-eye" aria-hidden="true"/></a> ';
                $btn .= '<a href="' . url('dashboard/gallery/' . Hashids::encode($gallery->id) . '/edit') . '" class="btn btn-primary btn-sm" title="Edit"><span class="fa fa-pencil" aria-hidden="true"/></a> ';
                $btn .= '<a href="' . url('dashboard/gallery/' . Hashids::encode($gallery->id) . '') . '" class="btn btn-danger btn-sm" data-delete="" title="Delete"><span class="fa fa-trash" aria-hidden="true"></span></a>';
                $btn .= '</div>';
                return $btn;
            })
            ->addColumn('control', function ($gallery) {
                $check = '<div style="text-align:center;"><a href="javascript:void(0);" class="btn btn-secondary btn-sm"><span class="fa fa-plus" /></a></div>';
                return $check;
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if (Auth::user()->can('gallery')) {
            $albums = Album::where('active', '=', 'Y')->get();

            return view('backend.gallery.create', compact('albums'));
        } else {
            return redirect('dashboard');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        if (Auth::user()->can('gallery')) {
            $this->validate($request, [
                'album_id' => 'required',
                'title' => 'required',
                'seotitle' => 'required',
                'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);
            $request->request->add([
                'created_by' => Auth::User()->id,
                'updated_by' => Auth::User()->id
            ]);
            $requestData = $request->all();
            if ($request->hasFile('picture')) {
                $image = $request->file('picture');
                $hashImage = $image->hashName();
                $image->storeAs('public/uploads', $hashImage);
                $requestData['picture'] = $hashImage;
            }

            Gallery::create($requestData);

            Session::flash('flash_message', 'Gallery added!');

            return redirect('dashboard/gallery/table');
        } else {
            return redirect('dashboard');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        if (Auth::user()->can('gallery')) {
            $ids = Hashids::decode($id);
            $gallery = Gallery::findOrFail($ids[0]);

            return view('backend.gallery.show', compact('gallery'));
        } else {
            return redirect('dashboard');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        if (Auth::user()->can('gallery')) {
            $ids = Hashids::decode($id);
            $gallery = Gallery::findOrFail($ids[0]);
            $albums = Album::where('active', '=', 'Y')->get();

            return view('backend.gallery.edit', compact('gallery', 'albums'));
        } else {
            return redirect('dashboard');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        if (Auth::user()->can('gallery')) {
            $ids = Hashids::decode($id);
            $rule = [
                'album_id' => 'required',
                'title' => 'required',
                'seotitle' => 'required',

            ];
            if ($request->hasFile('picture')) {
                $rule['picture'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
            }
            $this->validate($request, $rule);
            $request->request->add([
                'created_by' => Auth::User()->id,
                'updated_by' => Auth::User()->id
            ]);
            $requestData = $request->all();
            if ($request->hasFile('picture')) {
                $image = $request->file('picture');
                $hashImage = $image->hashName();
                $image->storeAs('public/uploads', $hashImage);
                $requestData['picture'] = $hashImage;
            }

            $gallery = Gallery::findOrFail($ids[0]);
            $gallery->update($requestData);

            Session::flash('flash_message', 'Gallery updated!');

            return redirect('dashboard/gallery/table');
        } else {
            return redirect('dashboard');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        if (Auth::user()->can('gallery')) {
            $ids = Hashids::decode($id);
            Gallery::destroy($ids[0]);

            Session::flash('flash_message', 'Gallery deleted!');

            return redirect('dashboard/gallery/table');
        } else {
            return redirect('dashboard');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return void
     */
    public function deleteAll(Request $request)
    {
        if (Auth::user()->can('gallery')) {
            if ($request->has('id')) {
                $ids = $request->id;
                foreach ($ids as $id) {
                    $idd = Hashids::decode($id);
                    Gallery::destroy($idd[0]);
                }
                Session::flash('flash_message', 'Gallery deleted!');
            } else {
                Session::flash('flash_message', 'No data deleted!');
            }

            return redirect('dashboard/gallery/table');
        } else {
            return redirect('dashboard');
        }
    }
}
