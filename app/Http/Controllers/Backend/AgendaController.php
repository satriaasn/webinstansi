<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Agenda;
use App\Models\User;
use Session;

use Yajra\Datatables\Datatables;
use Vinkla\Hashids\Facades\Hashids;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
		if(Auth::user()->can('agenda')) {
			return view('backend.agenda.datatable');
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
		if(Auth::user()->can('agenda')) {
			return view('backend.agenda.datatable');
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
		if(Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin') || Auth::user()->hasRole('report')) {
			$agendas = Agenda::leftJoin('users', 'users.id', '=', 'agendas.created_by')
				->select('agendas.*', 'users.id as uid', 'users.name as uname');
		} else {
			$agendas = Agenda::leftJoin('users', 'users.id', '=', 'agendas.created_by')
				->where('agendas.created_by', '=', Auth::user()->id)
				->select('agendas.*', 'users.id as uid', 'users.name as uname');
		}
		return Datatables::of($agendas)
			->addColumn('check', function ($agenda) {
				$check = '<div style="text-align:center;">
					<input type="checkbox" id="titleCheckdel" />
					<input type="hidden" class="deldata" name="id[]" value="'.Hashids::encode($agenda->id).'" disabled />
				</div>';
				return $check;
			})
			->addColumn('date', function ($agenda) {
				$date = '<div style="text-align:center;">';
				$date .= date('d M Y H:i A', strtotime($agenda->start)).'<br />to<br />'.date('d M Y H:i A', strtotime($agenda->end));
				$date .= '</div>';
				return $date;
			})
            ->addColumn('action', function ($agenda) {
				$btn = '<div style="text-align:center;">';
				$btn .= '<a href="'.url('dashboard/agenda/'.Hashids::encode($agenda->id).'').'" class="btn btn-secondary btn-sm" title="View"><span class="fa fa-eye" aria-hidden="true"/></a> ';
				$btn .= '<a href="'.url('dashboard/agenda/'.Hashids::encode($agenda->id).'/edit').'" class="btn btn-primary btn-sm" title="Edit"><span class="fa fa-pencil" aria-hidden="true"/></a> ';
				$btn .= '<a href="'.url('dashboard/agenda/'.Hashids::encode($agenda->id).'').'" class="btn btn-danger btn-sm" data-delete="" title="Delete"><span class="fa fa-trash" aria-hidden="true"></span></a>';
				$btn .= '</div>';
				return $btn;
            })
			->addColumn('control', function ($agenda) {
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
		if(Auth::user()->can('agenda')) {
			return view('backend.agenda.create');
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
		if(Auth::user()->can('agenda')) {
			$this->validate($request, [
				'title' => 'required',
				'seotitle' => 'required',
				'start' => 'required',
				'end' => 'required',
				'content' => 'required'
			]);
			$request->request->add([
				'created_by' => Auth::User()->id,
				'updated_by' => Auth::User()->id
			]);
			$requestData = $request->all();

			Agenda::create($requestData);

			Session::flash('flash_message', 'Agenda added!');

			return redirect('dashboard/agenda/table');
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
		if(Auth::user()->can('agenda')) {
			$ids = Hashids::decode($id);
			$agenda = Agenda::findOrFail($ids[0]);

			return view('backend.agenda.show', compact('agenda'));
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
		if(Auth::user()->can('agenda')) {
			$ids = Hashids::decode($id);
			$agenda = Agenda::findOrFail($ids[0]);

			return view('backend.agenda.edit', compact('agenda'));
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
		if(Auth::user()->can('agenda')) {
			$ids = Hashids::decode($id);
			$this->validate($request, [
				'title' => 'required',
				'seotitle' => 'required',
				'start' => 'required',
				'end' => 'required',
				'content' => 'required'
			]);
			$request->request->add([
				'updated_by' => Auth::User()->id
			]);
			$requestData = $request->all();

			$agenda = Agenda::findOrFail($ids[0]);
			$agenda->update($requestData);

			Session::flash('flash_message', 'Agenda updated!');

			return redirect('dashboard/agenda/table');
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
		if(Auth::user()->can('agenda')) {
			$ids = Hashids::decode($id);
			Agenda::destroy($ids[0]);

			Session::flash('flash_message', 'Agenda deleted!');

			return redirect('dashboard/agenda/table');
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
		if(Auth::user()->can('agenda')) {
			if ($request->has('id')) {
				$ids = $request->id;
				foreach($ids as $id){
					$idd = Hashids::decode($id);
					Agenda::destroy($idd[0]);
				}
				Session::flash('flash_message', 'Agenda deleted!');
			} else {
				Session::flash('flash_message', 'No data deleted!');
			}

			return redirect('dashboard/agenda/table');
		} else {
			return redirect('dashboard');
		}
    }
}
