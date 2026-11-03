<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Role;
use App\Models\User;

use Yajra\Datatables\Datatables;
use Vinkla\Hashids\Facades\Hashids;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index(Request $request)
    {
		if(Auth::user()->can('users')) {
			return view('backend.users.datatable');
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
		if(Auth::user()->can('users')) {
			return view('backend.users.datatable');
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
		if (Auth::user()->hasRole('superadmin')) {
			$users = User::select('users.*');
        }
        else if (Auth::user()->hasRole('admin')) {
            $users = User::where('users.id', '!=', '1')
				->select('users.*');
        }
        else {

            $users = User::where('users.id', '=', Auth::user()->id)
                ->select('users.*');
//			$users = User::where('users.id', '!=', '1')
//				->select('users.*');
		}
		return Datatables::of($users)
			->addColumn('check', function ($user) {
				$check = '<div style="text-align:center;">
					<input type="checkbox" id="titleCheckdel" />
					<input type="hidden" class="deldata" name="id[]" value="'.Hashids::encode($user->id).'" disabled />
				</div>';
				return $check;
			})
			->addColumn('active', function ($user) {
				return $user->active == 1 ? 'Active' : 'Non Active';
			})
            ->addColumn('action', function ($user) {
				$btn = '<div style="text-align:center;">';
				$btn = '<a href="'.url('dashboard/users/'.Hashids::encode($user->id).'').'" class="btn btn-secondary btn-sm" title="View"><span class="fa fa-eye" aria-hidden="true"/></a> ';
				$btn .= '<a href="'.url('dashboard/users/'.Hashids::encode($user->id).'/edit').'" class="btn btn-primary btn-sm" title="Edit"><span class="fa fa-pencil" aria-hidden="true"/></a> ';
				if ($user->id != '1') {
				$btn .= '<a href="'.url('dashboard/users/'.Hashids::encode($user->id).'').'" class="btn btn-danger btn-sm" data-delete="" title="Delete"><span class="fa fa-trash" aria-hidden="true"></span></a>';
				}
				$btn .= '</div>';
				return $btn;
            })
			->addColumn('control', function ($user) {
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
		if(Auth::user()->can('users')) {
			if (Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin')) {
				$roles = Role::where('id', '!=', '1')->select('id', 'name', 'label')->get();
				$roles = $roles->pluck('label', 'name');

				return view('backend.users.create', compact('roles'));
			} else {
				return redirect('dashboard');
			}
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
		if(Auth::user()->can('users')) {
            $rule = [
                'username' => 'required',
                'name' => 'required',
                'email' => 'required|string|max:255|email|unique:users',
                'password' => 'required',
                'roles' => 'required'
            ];
            if ($request->hasFile('picture')) {
                $rule['picture'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
            }
            $this->validate($request, $rule);
            $request->request->add([
                'active' => 1,
                'create_user' => Auth::User()->id,
                'update_user' => Auth::User()->id
            ]);
			$data = $request->except('password');
			$data['password'] = bcrypt($request->password);

            $pictureuser = null;
            if ($request->hasFile('picture')) {
                $image = $request->file('picture');
                $hashImage = $image->hashName();
                $image->storeAs('public/uploads', $hashImage);
                $pictureuser = $hashImage;
            }

            $data['picture'] = $pictureuser;

			$user = User::create($data);

			foreach ($request->roles as $role) {
				$user->assignRole($role);
			}

			return redirect('dashboard/users')->with('flash_message', 'User added!');
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
		if(Auth::user()->can('users')) {
			$ids = Hashids::decode($id);
			$user = User::findOrFail($ids[0]);

			return view('backend.users.show', compact('user'));
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
		if(Auth::user()->can('users')) {
			$ids = Hashids::decode($id);
			if (Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin')) {
				if (Auth::user()->hasRole('superadmin')) {
					$roles = Role::select('id', 'name', 'label')->get();
				} else {
					$roles = Role::where('id', '!=', '1')->select('id', 'name', 'label')->get();
				}
				$roles = $roles->pluck('label', 'name');

				$user = User::with('roles')->select('id', 'username', 'name', 'email', 'active', 'picture')->findOrFail($ids[0]);
				$user_roles = [];
				foreach ($user->roles as $role) {
					$user_roles[] = $role->name;
				}

				return view('backend.users.edit', compact('user', 'roles', 'user_roles'));
			} else {
				if (Auth::user()->id == $ids[0]) {
					$roles = Role::where('id', '!=', '1')->select('id', 'name', 'label')->get();
					$roles = $roles->pluck('label', 'name');

					$user = User::with('roles')->select('id', 'username', 'name', 'email', 'active', 'picture')->findOrFail($ids[0]);
					$user_roles = [];
					foreach ($user->roles as $role) {
						$user_roles[] = $role->name;
					}

					return view('backend.users.edit', compact('user', 'roles', 'user_roles'));
				} else {
					return redirect('dashboard/users/'. Hashids::encode(Auth::user()->id) .'/edit');
				}
			}
		} else {
			return redirect('dashboard');
		}
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int      $id
     *
     * @return void
     */
    public function update(Request $request, $id)
    {
		if(Auth::user()->can('users')) {

			$ids = Hashids::decode($id);


            $rule = [
                'name' => 'required',
                'email' => 'required|string|max:255|email|unique:users,email,' . $ids[0],
//                'roles' => 'required'
            ];
            if ($request->hasFile('picture')) {
                $rule['picture'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
            }
            $this->validate($request, $rule);
            $request->request->add([
                'update_user' => Auth::User()->id
            ]);

			$user = User::findOrFail($ids[0]);

            $pictureuser = null;
            if ($request->hasFile('picture')) {
                $image = $request->file('picture');
                $hashImage = $image->hashName();
                $image->storeAs('public/uploads', $hashImage);
                $pictureuser = $hashImage;
            }

			if ($request->input('password') == '' || $request->input('password') == null) {
                $data = $request->except('password');
                $data['picture'] = $pictureuser;
				$user->update($data);
			} else {
				$data = $request->except('password');
				$data['password'] = bcrypt($request->password);
                $data['picture'] = $pictureuser;
				$user->update($data);
			}

            if($request->roles)
            {
                if (Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin')) {
                    $user->roles()->detach();
                    foreach ($request->roles as $role) {
                        $user->assignRole($role);
                    }
                }
            }


			return redirect('dashboard/users')->with('flash_message', 'User updated!');
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
		if(Auth::user()->can('users')) {
			$ids = Hashids::decode($id);
			User::destroy($ids[0]);

			return redirect('dashboard/users')->with('flash_message', 'User deleted!');
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
		if(Auth::user()->can('users')) {
			if ($request->has('id')) {
				$ids = $request->id;
				foreach($ids as $id){
					$idd = Hashids::decode($id);
					User::destroy($idd[0]);
				}
				return redirect('dashboard/permissions')->with('flash_message', 'User deleted!');
			} else {
				return redirect('dashboard/permissions')->with('flash_message', 'User error deleted!');
			}
		} else {
			return redirect('dashboard');
		}
    }
}
