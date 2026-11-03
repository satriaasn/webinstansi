<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Pegawai;
use App\Models\User;
use Session;

use Yajra\Datatables\Datatables;
use Vinkla\Hashids\Facades\Hashids;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
		if(Auth::user()->can('pegawai')) {
			return view('backend.pegawai.datatable');
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
		if(Auth::user()->can('pegawai')) {
			return view('backend.pegawai.datatable');
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
		$pegawais = Pegawai::leftJoin('users', 'users.id', '=', 'pegawais.created_by')
			->select('pegawais.*', 'users.id as uid', 'users.name as uname');
		return Datatables::of($pegawais)
			->addColumn('check', function ($pegawai) {
				$check = '<div style="text-align:center;">
					<input type="checkbox" id="titleCheckdel" />
					<input type="hidden" class="deldata" name="id[]" value="'.Hashids::encode($pegawai->id).'" disabled />
				</div>';
				return $check;
			})
			->addColumn('nama_pegawai', function ($pegawai) {
				return '<strong>' . $pegawai->nip . '</strong><br />' . $pegawai->nama_pegawai;
			})
            ->addColumn('active', function ($pegawai) {
				return $pegawai->active == 'Y' ? 'Active' : 'Non Active';
			})
            ->addColumn('action', function ($pegawai) {
				$btn = '<div style="text-align:center;">';
				$btn .= '<a href="'.url('dashboard/pegawai/'.Hashids::encode($pegawai->id).'').'" class="btn btn-secondary btn-sm" title="View"><span class="fa fa-eye" aria-hidden="true"/></a> ';
				$btn .= '<a href="'.url('dashboard/pegawai/'.Hashids::encode($pegawai->id).'/edit').'" class="btn btn-primary btn-sm" title="Edit"><span class="fa fa-pencil" aria-hidden="true"/></a> ';
				$btn .= '<a href="'.url('dashboard/pegawai/'.Hashids::encode($pegawai->id).'').'" class="btn btn-danger btn-sm" data-delete="" title="Delete"><span class="fa fa-trash" aria-hidden="true"></span></a>';
				$btn .= '</div>';
				return $btn;
            })
			->addColumn('control', function ($pegawai) {
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
		if(Auth::user()->can('pegawai')) {
			return view('backend.pegawai.create');
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
		if(Auth::user()->can('pegawai')) {

			$rule = [
                'klasifikasi_pegawai' => 'required',
				'nip' => 'required',
				'nama_pegawai' => 'required'
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

			Pegawai::create($requestData);

			Session::flash('flash_message', 'Pegawai added!');

			return redirect('dashboard/pegawai/table');
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
		if(Auth::user()->can('pegawai')) {
			$ids = Hashids::decode($id);
			$pegawai = Pegawai::findOrFail($ids[0]);

			return view('backend.pegawai.show', compact('pegawai'));
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
		if(Auth::user()->can('pegawai')) {
			$ids = Hashids::decode($id);
			$pegawai = Pegawai::findOrFail($ids[0]);

			return view('backend.pegawai.edit', compact('pegawai'));
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
		if(Auth::user()->can('pegawai')) {
			$ids = Hashids::decode($id);
			
			$rule = [
                'klasifikasi_pegawai' => 'required',
				'nip' => 'required',
				'nama_pegawai' => 'required',
				'active' => 'required'
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
           
			$pegawai = Pegawai::findOrFail($ids[0]);
			$pegawai->update($requestData);

			Session::flash('flash_message', 'Pegawai updated!');

			return redirect('dashboard/pegawai/table');
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
		if(Auth::user()->can('pegawai')) {
			$ids = Hashids::decode($id);
			Pegawai::destroy($ids[0]);

			Session::flash('flash_message', 'Pegawai deleted!');

			return redirect('dashboard/pegawai/table');
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
		if(Auth::user()->can('video')) {
			if ($request->has('id')) {
				$ids = $request->id;
				foreach($ids as $id){
					$idd = Hashids::decode($id);
					Pegawai::destroy($idd[0]);
				}
				Session::flash('flash_message', 'Pegawai deleted!');
			} else {
				Session::flash('flash_message', 'No data deleted!');
			}

			return redirect('dashboard/pegawai/table');
		} else {
			return redirect('dashboard');
		}
    }
}
