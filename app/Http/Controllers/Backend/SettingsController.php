<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Setting;

use Yajra\Datatables\Datatables;
use Vinkla\Hashids\Facades\Hashids;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index(Request $request)
    {
        if (Auth::user()->can('settings')) {
            return view('backend.settings.datatable');
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
        if (Auth::user()->can('settings')) {
            return view('backend.settings.datatable');
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
        $settings = Setting::leftJoin('users', 'users.id', '=', 'settings.created_by')
            ->select('settings.*', 'users.id as uid', 'users.name as uname');
        return Datatables::of($settings)
            ->addColumn('check', function ($setting) {
                $check = '<div style="text-align:center;">
					<input type="checkbox" id="titleCheckdel" />
					<input type="hidden" class="deldata" name="id[]" value="' . Hashids::encode($setting->id) . '" disabled />
				</div>';
                return $check;
            })
            ->addColumn('action', function ($setting) {
                $btn = '<div style="text-align:center;">';
                $btn .= '<a href="' . url('dashboard/settings/' . Hashids::encode($setting->id) . '') . '" class="btn btn-secondary btn-sm" title="View"><span class="fa fa-eye" aria-hidden="true"/></a> ';
                $btn .= '<a href="' . url('dashboard/settings/' . Hashids::encode($setting->id) . '/edit') . '" class="btn btn-primary btn-sm" title="Edit"><span class="fa fa-pencil" aria-hidden="true"/></a> ';
                $btn .= '<a href="' . url('dashboard/settings/' . Hashids::encode($setting->id) . '') . '" class="btn btn-danger btn-sm" data-delete="" title="Delete"><span class="fa fa-trash" aria-hidden="true"></span></a>';
                $btn .= '</div>';
                return $btn;
            })
            ->addColumn('control', function ($setting) {
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
        if (Auth::user()->can('settings')) {
            return view('backend.settings.create');
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
        if (Auth::user()->can('settings')) {
            $this->validate(
                $request,
                [
                    'key' => 'required|string|unique:settings',
                    'value' => 'required'
                ]
            );
            $requestData = $request->all();
            if ($requestData['key'] == 'favicon' || $requestData['key'] == 'logo') {
                $this->validate(
                    $request,
                    [
                        'key' => 'required|string|unique:settings',
                        'value' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                    ]
                );
            } else {
                $this->validate(
                    $request,
                    [
                        'key' => 'required|string|unique:settings',
                        'value' => 'required'
                    ]
                );
            }

            $request->request->add([
                'create_user' => Auth::User()->id,
                'update_user' => Auth::User()->id
            ]);


            if ($requestData['key'] == 'favicon' || $requestData['key'] == 'logo') {
                if ($request->hasFile('value')) {
                    $image = $request->file('value');
                    $hashImage = $image->hashName();
                    $image->storeAs('public/uploads', $hashImage);
                    $requestData['value'] = $hashImage;
                }
            }

            Setting::create($requestData);

            return redirect('dashboard/settings')->with('flash_message', 'Setting added!');
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
        if (Auth::user()->can('settings')) {
            $ids = Hashids::decode($id);
            $setting = Setting::findOrFail($ids[0]);

            return view('backend.settings.show', compact('setting'));
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
        if (Auth::user()->can('settings')) {
            $ids = Hashids::decode($id);
            $setting = Setting::findOrFail($ids[0]);

            return view('backend.settings.edit', compact('setting'));
        } else {
            return redirect('dashboard');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->can('settings')) {
            $ids = Hashids::decode($id);

//            $this->validate(
//                $request,
//                [
//                    'key' => 'required|string|unique:settings,key,' . $ids[0],
//                    'value' => 'required'
//                ]
//            );
            $requestData = $request->all();
            if ($requestData['key'] == 'favicon' || $requestData['key'] == 'logo') {
                $this->validate(
                    $request,
                    [
                        'key' => 'required|string|unique:settings,key,' . $ids[0],
                        'value' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                    ]
                );
            } else {
                $this->validate(
                    $request,
                    [
                        'key' => 'required|string|unique:settings,key,' . $ids[0],
                        'value' => 'required'
                    ]
                );
            }

            $request->request->add([
                'update_user' => Auth::User()->id
            ]);


            if ($requestData['key'] == 'favicon' || $requestData['key'] == 'logo') {
                if ($request->hasFile('value')) {
                    $image = $request->file('value');
                    $hashImage = $image->hashName();
                    $image->storeAs('public/uploads', $hashImage);
                    $requestData['value'] = $hashImage;
                }
            }


            $setting = Setting::findOrFail($ids[0]);
            $setting->update($requestData);

            return redirect('dashboard/settings')->with('flash_message', 'Setting updated!');
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
        if (Auth::user()->can('settings')) {
            $ids = Hashids::decode($id);
            Setting::destroy($ids[0]);

            return redirect('dashboard/settings')->with('flash_message', 'Setting deleted!');
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
        if (Auth::user()->can('settings')) {
            if ($request->has('id')) {
                $ids = $request->id;
                foreach ($ids as $id) {
                    $idd = Hashids::decode($id);
                    Setting::destroy($idd[0]);
                }
                return redirect('dashboard/settings')->with('flash_message', 'Setting deleted!');
            } else {
                return redirect('dashboard/settings')->with('flash_message', 'Setting error deleted!');
            }
        } else {
            return redirect('dashboard');
        }
    }
}
