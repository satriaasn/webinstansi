<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Spatie\Activitylog\Models\Activity;

use Yajra\Datatables\Datatables;
use Vinkla\Hashids\Facades\Hashids;

class ActivityLogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index(Request $request)
    {
		if(Auth::user()->can('users')) {
			return view('backend.activitylogs.datatable');
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
			return view('backend.activitylogs.datatable');
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
		$activitylogs = Activity::leftJoin('users', 'users.id', '=', 'activity_log.causer_id')
			->select('activity_log.*', 'users.id as uid', 'users.name as uname');
		return Datatables::of($activitylogs)
			->addColumn('check', function ($activitylog) {
				$check = '<div style="text-align:center;">
					<input type="checkbox" id="titleCheckdel" />
					<input type="hidden" class="deldata" name="id[]" value="'.Hashids::encode($activitylog->id).'" disabled />
				</div>';
				return $check;
			})
            ->addColumn('action', function ($activitylog) {
				$btn = '<div style="text-align:center;"><a href="'.url('dashboard/activitylogs/'.Hashids::encode($activitylog->id).'').'" class="btn btn-secondary btn-sm" title="View"><span class="fa fa-eye" aria-hidden="true"/></a></div>';
				return $btn;
            })
			->addColumn('control', function ($activitylog) {
				$check = '<div style="text-align:center;"><a href="javascript:void(0);" class="btn btn-secondary btn-sm"><span class="fa fa-plus" /></a></div>';
				return $check;
			})
			->escapeColumns([])
			->make(true);
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
		if(Auth::user()->can('users')) {
			$ids = Hashids::decode($id);
			$activitylog = Activity::findOrFail($ids[0]);

			return view('backend.activitylogs.show', compact('activitylog'));
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
		if(Auth::user()->can('users')) {
			$ids = Hashids::decode($id);
			Activity::destroy($ids[0]);

			return redirect('dashboard/activitylogs')->with('flash_message', 'Activity deleted!');
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
					Activity::destroy($idd[0]);
				}
				return redirect('dashboard/activitylogs')->with('flash_message', 'Activity deleted!');
			} else {
				return redirect('dashboard/activitylogs')->with('flash_message', 'Activity error deleted!');
			}
		} else {
			return redirect('dashboard');
		}
    }
}
