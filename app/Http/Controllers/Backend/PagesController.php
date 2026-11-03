<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Pages;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Session;

use Yajra\Datatables\Datatables;
use Vinkla\Hashids\Facades\Hashids;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (Auth::user()->can('pages')) {
            return view('backend.pages.datatable');
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
        if (Auth::user()->can('pages')) {
            return view('backend.pages.datatable');
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
            $pages = Pages::leftJoin('users', 'users.id', '=', 'pages.created_by')
                ->select('pages.*', 'users.id as uid', 'users.name as uname');
        } else {
            $pages = Pages::leftJoin('users', 'users.id', '=', 'pages.created_by')
                ->where('pages.created_by', '=', Auth::user()->id)
                ->select('pages.*', 'users.id as uid', 'users.name as uname');
        }
        return Datatables::of($pages)
            ->addColumn('check', function ($pages) {
                $check = '<div style="text-align:center;">
					<input type="checkbox" id="titleCheckdel" />
					<input type="hidden" class="deldata" name="id[]" value="' . Hashids::encode($pages->id) . '" disabled />
				</div>';
                return $check;
            })
            ->addColumn('active', function ($pages) {
                return $pages->active == 'Y' ? 'Active' : 'Non Active';
            })
            ->addColumn('action', function ($pages) {
                $btn = '<div style="text-align:center;">';
                $btn .= '<a href="' . url('dashboard/pages/' . Hashids::encode($pages->id) . '') . '" class="btn btn-secondary btn-sm" title="View"><span class="fa fa-eye" aria-hidden="true"/></a> ';
                $btn .= '<a href="' . url('dashboard/pages/' . Hashids::encode($pages->id) . '/edit') . '" class="btn btn-primary btn-sm" title="Edit"><span class="fa fa-pencil" aria-hidden="true"/></a> ';
                $btn .= '<a href="' . url('dashboard/pages/' . Hashids::encode($pages->id) . '') . '" class="btn btn-danger btn-sm" data-delete="" title="Delete"><span class="fa fa-trash" aria-hidden="true"></span></a>';
                $btn .= '</div>';
                return $btn;
            })
            ->addColumn('control', function ($pages) {
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
        if (Auth::user()->can('pages')) {
            return view('backend.pages.create');
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

        if (Auth::user()->can('pages')) {

            $rule = [
                'title' => 'required',
                'seotitle' => 'required'
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
            Pages::create($requestData);

            Session::flash('flash_message', 'Pages added!');

            return redirect('dashboard/pages/table');
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
        if (Auth::user()->can('pages')) {
            $ids = Hashids::decode($id);
            $pages = Pages::findOrFail($ids[0]);

            return view('backend.pages.show', compact('pages'));
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
        if (Auth::user()->can('pages')) {
            $ids = Hashids::decode($id);
            $pages = Pages::findOrFail($ids[0]);

            return view('backend.pages.edit', compact('pages'));
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
        if (Auth::user()->can('pages')) {
            $ids = Hashids::decode($id);

            $rule = [
                'title' => 'required',
                'seotitle' => 'required'
            ];
            if ($request->hasFile('picture')) {
                $rule['picture'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
            }
            $this->validate($request, $rule);
            $request->request->add([
                'updated_by' => Auth::User()->id
            ]);
            $requestData = $request->all();
            if ($request->hasFile('picture')) {
                $image = $request->file('picture');
                $hashImage = $image->hashName();
                $image->storeAs('public/uploads', $hashImage);
                $requestData['picture'] = $hashImage;
            }
            $pages = Pages::findOrFail($ids[0]);
            $pages->update($requestData);

            Session::flash('flash_message', 'Pages updated!');

            return redirect('dashboard/pages/table');
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
        if (Auth::user()->can('pages')) {
            $ids = Hashids::decode($id);
            Pages::destroy($ids[0]);

            Session::flash('flash_message', 'Pages deleted!');

            return redirect('dashboard/pages/table');
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
        if (Auth::user()->can('pages')) {
            if ($request->has('id')) {
                $ids = $request->id;
                foreach ($ids as $id) {
                    $idd = Hashids::decode($id);
                    Pages::destroy($idd[0]);
                }
                Session::flash('flash_message', 'Pages deleted!');
            } else {
                Session::flash('flash_message', 'No data deleted!');
            }

            return redirect('dashboard/pages/table');
        } else {
            return redirect('dashboard');
        }
    }
}
