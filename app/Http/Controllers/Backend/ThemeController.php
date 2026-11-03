<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Theme;
use App\Models\User;
use Session;

use Yajra\Datatables\Datatables;
use Vinkla\Hashids\Facades\Hashids;

class ThemeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
		if(Auth::user()->can('theme')) {
			return view('backend.theme.datatable');
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
		if(Auth::user()->can('theme')) {
			return view('backend.theme.datatable');
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
		if(Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin')) {
			$themes = Theme::leftJoin('users', 'users.id', '=', 'themes.created_by')
				->select('themes.*', 'users.id as uid', 'users.name as uname');
		} else {
			$themes = Theme::leftJoin('users', 'users.id', '=', 'themes.created_by')
				->where('themes.created_by', '=', Auth::user()->id)
				->select('themes.*', 'users.id as uid', 'users.name as uname');
		}
		return Datatables::of($themes)
			->addColumn('picture', function ($theme) {
				return '<div style="width:80px; text-align:center;"><img class="img-fluid img-thumbnail" src="'.berkas($theme->picture).'" width="80"></div>';
			})
			->addColumn('active', function ($theme) {
				return $theme->active == 'Y' ? 'Active' : 'Non Active';
			})
            ->addColumn('action', function ($theme) {
				$btn = '<div style="text-align:center;">';
				$btn .= '<a href="javascript:void(0);" class="btn btn-success btn-sm btn-active" id="'.Hashids::encode($theme->id).'" title="Active"><span class="fa fa-eye" aria-hidden="true"></span> Active</a> ';
				//$btn .= '<a href="'.url('dashboard/theme/'.Hashids::encode($theme->id).'').'" class="btn btn-secondary btn-sm" title="View"><span class="fa fa-eye" aria-hidden="true"/></a> ';
				//$btn .= '<a href="'.url('dashboard/theme/'.Hashids::encode($theme->id).'/edit').'" class="btn btn-primary btn-sm" title="Edit"><span class="fa fa-pencil" aria-hidden="true"/></a> ';
				//$btn .= '<a href="'.url('dashboard/theme/'.Hashids::encode($theme->id).'').'" class="btn btn-danger btn-sm" data-delete="" title="Delete"><span class="fa fa-trash" aria-hidden="true"></span></a>';
				$btn .= '</div>';
				return $btn;
            })
			->addColumn('control', function ($theme) {
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
		if(Auth::user()->can('theme')) {
			return view('backend.theme.create');
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
		if(Auth::user()->can('theme')) {
			$this->validate($request, [
				'title' => 'required',
				'folder' => 'required',
				'picture' => 'required'
			]);
			$request->request->add([
				'created_by' => Auth::User()->id,
				'updated_by' => Auth::User()->id
			]);
			$requestData = $request->all();

			Theme::create($requestData);

			Session::flash('flash_message', 'Theme added!');

			return redirect('dashboard/theme/table');
		} else {
			return redirect('dashboard');
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
		if(Auth::user()->can('theme')) {
			$ids = Hashids::decode($id);
			$theme = Theme::findOrFail($ids[0]);

			return view('backend.theme.show', compact('theme'));
		} else {
			return redirect('dashboard');
		}
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
		if(Auth::user()->can('theme')) {
			$ids = Hashids::decode($id);
			$theme = Theme::findOrFail($ids[0]);

			return view('backend.theme.edit', compact('theme'));
		} else {
			return redirect('dashboard');
		}
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
		if(Auth::user()->can('theme')) {
			$ids = Hashids::decode($id);
			$this->validate($request, [
				'title' => 'required',
				'folder' => 'required',
				'picture' => 'required'
			]);
			$request->request->add([
				'updated_by' => Auth::User()->id
			]);
			$requestData = $request->all();

			$theme = Theme::findOrFail($ids[0]);
			$theme->update($requestData);

			Session::flash('flash_message', 'Theme updated!');

			return redirect('dashboard/theme/table');
		} else {
			return redirect('dashboard');
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
		if(Auth::user()->can('theme')) {
			$ids = Hashids::decode($id);
			Theme::destroy($ids[0]);

			Session::flash('flash_message', 'Theme deleted!');

			return redirect('dashboard/theme/table');
		} else {
			return redirect('dashboard');
		}
    }

	/**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function deleteAll(Request $request)
    {
		if(Auth::user()->can('theme')) {
			if ($request->has('id')) {
				$ids = $request->id;
				foreach($ids as $id){
					$idd = Hashids::decode($id);
					Theme::destroy($idd[0]);
				}
				Session::flash('flash_message', 'Theme deleted!');
			} else {
				Session::flash('flash_message', 'No data deleted!');
			}

			return redirect('dashboard/theme/table');
		} else {
			return redirect('dashboard');
		}
    }

	public function active(Request $request)
    {
		if(Auth::user()->can('theme')) {
			$ids = Hashids::decode($request->id);
			Theme::where('active', '=', 'Y')->update([
				'active' => 'N',
				'updated_by' => Auth::User()->id
			]);
			$theme = Theme::findOrFail($ids[0]);
			$theme->update([
				'active' => 'Y',
				'updated_by' => Auth::User()->id
			]);
			return '1';
		} else {
			return '0';
		}
    }
}
