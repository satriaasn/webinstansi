<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Permission;

use Yajra\Datatables\Datatables;
use Vinkla\Hashids\Facades\Hashids;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index(Request $request)
    {
		if(Auth::user()->can('permissions')) {
			return view('backend.permissions.datatable');
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
		if(Auth::user()->can('permissions')) {
			return view('backend.permissions.datatable');
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
		$permissions = Permission::leftJoin('users', 'users.id', '=', 'permissions.created_by')
			->select('permissions.*', 'users.id as uid', 'users.name as uname');
		return Datatables::of($permissions)
			->addColumn('check', function ($permission) {
				$check = '<div style="text-align:center;">
					<input type="checkbox" id="titleCheckdel" />
					<input type="hidden" class="deldata" name="id[]" value="'.Hashids::encode($permission->id).'" disabled />
				</div>';
				return $check;
			})
            ->addColumn('action', function ($permission) {
				$btn = '<div style="text-align:center;">';
				$btn = '<a href="'.url('dashboard/permissions/'.Hashids::encode($permission->id).'').'" class="btn btn-secondary btn-sm" title="View"><span class="fa fa-eye" aria-hidden="true"/></a> ';
				$btn .= '<a href="'.url('dashboard/permissions/'.Hashids::encode($permission->id).'/edit').'" class="btn btn-primary btn-sm" title="Edit"><span class="fa fa-pencil" aria-hidden="true"/></a> ';
				$btn .= '<a href="'.url('dashboard/permissions/'.Hashids::encode($permission->id).'').'" class="btn btn-danger btn-sm" data-delete="" title="Delete"><span class="fa fa-trash" aria-hidden="true"></span></a>';
				$btn .= '</div>';
				return $btn;
            })
			->addColumn('control', function ($permission) {
				$check = '<div style="text-align:center;"><a href="javascript:void(0);" class="btn btn-secondary btn-sm"><span class="fa fa-plus" /></a></div>';
				return $check;
			})
			->escapeColumns([])
			->make(true);
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
		if(Auth::user()->can('permissions')) {
			return view('backend.permissions.create');
		} else {
			return redirect('dashboard');
		}
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function store(Request $request)
    {
		if(Auth::user()->can('permissions')) {
			$this->validate($request, ['name' => 'required']);

			$request->request->add([
				'create_user' => Auth::User()->id,
				'update_user' => Auth::User()->id
			]);
			Permission::create($request->all());

			return redirect('dashboard/permissions')->with('flash_message', 'Permission added!');
		} else {
			return redirect('dashboard');
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function show($id)
    {
		if(Auth::user()->can('permissions')) {
			$ids = Hashids::decode($id);
			$permission = Permission::findOrFail($ids[0]);

			return view('backend.permissions.show', compact('permission'));
		} else {
			return redirect('dashboard');
		}
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function edit($id)
    {
		if(Auth::user()->can('permissions')) {
			$ids = Hashids::decode($id);
			$permission = Permission::findOrFail($ids[0]);

			return view('backend.permissions.edit', compact('permission'));
		} else {
			return redirect('dashboard');
		}
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return void
     */
    public function update(Request $request, $id)
    {
		if(Auth::user()->can('permissions')) {
			$this->validate($request, ['name' => 'required']);

			$ids = Hashids::decode($id);
			$permission = Permission::findOrFail($ids[0]);
			$request->request->add([
				'update_user' => Auth::User()->id
			]);
			$permission->update($request->all());

			return redirect('dashboard/permissions')->with('flash_message', 'Permission updated!');
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
    public function destroy($id)
    {
		if(Auth::user()->can('permissions')) {
			$ids = Hashids::decode($id);
			Permission::destroy($ids[0]);

			return redirect('dashboard/permissions')->with('flash_message', 'Permission deleted!');
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
		if(Auth::user()->can('permissions')) {
			if ($request->has('id')) {
				$ids = $request->id;
				foreach($ids as $id){
					$idd = Hashids::decode($id);
					Permission::destroy($idd[0]);
				}
				return redirect('dashboard/permissions')->with('flash_message', 'Permission deleted!');
			} else {
				return redirect('dashboard/permissions')->with('flash_message', 'Permission error deleted!');
			}
		} else {
			return redirect('dashboard');
		}
    }
}
