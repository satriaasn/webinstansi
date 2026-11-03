<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Role;
use App\Models\Permission;

use Yajra\Datatables\Datatables;
use Vinkla\Hashids\Facades\Hashids;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index(Request $request)
    {
		if(Auth::user()->can('roles')) {
			return view('backend.roles.datatable');
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
		if(Auth::user()->can('roles')) {
			return view('backend.roles.datatable');
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
		$roles = Role::leftJoin('users', 'users.id', '=', 'roles.created_by')
			->select('roles.*', 'users.id as uid', 'users.name as uname');
		return Datatables::of($roles)
			->addColumn('check', function ($role) {
				$check = '<div style="text-align:center;">
					<input type="checkbox" id="titleCheckdel" />
					<input type="hidden" class="deldata" name="id[]" value="'.Hashids::encode($role->id).'" disabled />
				</div>';
				return $check;
			})
            ->addColumn('action', function ($role) {
				$btn = '<div style="text-align:center;">';
				$btn = '<a href="'.url('dashboard/roles/'.Hashids::encode($role->id).'').'" class="btn btn-secondary btn-sm" title="View"><span class="fa fa-eye" aria-hidden="true"/></a> ';
				$btn .= '<a href="'.url('dashboard/roles/'.Hashids::encode($role->id).'/edit').'" class="btn btn-primary btn-sm" title="Edit"><span class="fa fa-pencil" aria-hidden="true"/></a> ';
				$btn .= '<a href="'.url('dashboard/roles/'.Hashids::encode($role->id).'').'" class="btn btn-danger btn-sm" data-delete="" title="Delete"><span class="fa fa-trash" aria-hidden="true"></span></a>';
				$btn .= '</div>';
				return $btn;
            })
			->addColumn('control', function ($role) {
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
		if(Auth::user()->can('roles')) {
			$permissions = Permission::select('id', 'name', 'label')->get()->pluck('label', 'name');

			return view('backend.roles.create', compact('permissions'));
		} else {
			return redirect('dashboard');
		}
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function store(Request $request)
    {
		if(Auth::user()->can('roles')) {
			$this->validate($request, ['name' => 'required']);

			$request->request->add([
				'create_user' => Auth::User()->id,
				'update_user' => Auth::User()->id
			]);
			$role = Role::create($request->all());
			$role->permissions()->detach();

			if ($request->has('permissions')) {
				foreach ($request->permissions as $permission_name) {
					$permission = Permission::whereName($permission_name)->first();
					$role->givePermissionTo($permission);
				}
			}

			return redirect('dashboard/roles')->with('flash_message', 'Role added!');
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
		if(Auth::user()->can('roles')) {
			$ids = Hashids::decode($id);
			$role = Role::findOrFail($ids[0]);

			return view('backend.roles.show', compact('role'));
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
		if(Auth::user()->can('roles')) {
			$ids = Hashids::decode($id);
			$role = Role::findOrFail($ids[0]);
			$permissions = Permission::select('id', 'name', 'label')->get()->pluck('label', 'name');

			return view('backend.roles.edit', compact('role', 'permissions'));
		} else {
			return redirect('dashboard');
		}
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return void
     */
    public function update(Request $request, $id)
    {
		if(Auth::user()->can('roles')) {
			$this->validate($request, ['name' => 'required']);

			$ids = Hashids::decode($id);
			$role = Role::findOrFail($ids[0]);
			$request->request->add([
				'update_user' => Auth::User()->id
			]);
			$role->update($request->all());
			$role->permissions()->detach();

			if ($request->has('permissions')) {
				foreach ($request->permissions as $permission_name) {
					$permission = Permission::whereName($permission_name)->first();
					$role->givePermissionTo($permission);
				}
			}

			return redirect('dashboard/roles')->with('flash_message', 'Role updated!');
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
		if(Auth::user()->can('roles')) {
			$ids = Hashids::decode($id);
			Role::destroy($ids[0]);

			return redirect('dashboard/roles')->with('flash_message', 'Role deleted!');
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
		if(Auth::user()->can('roles')) {
			if ($request->has('id')) {
				$ids = $request->id;
				foreach($ids as $id){
					$idd = Hashids::decode($id);
					Role::destroy($idd[0]);
				}
				return redirect('dashboard/roles')->with('flash_message', 'Role deleted!');
			} else {
				return redirect('dashboard/roles')->with('flash_message', 'Role error deleted!');
			}
		} else {
			return redirect('dashboard');
		}
    }
}
