<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Video;
use App\Models\User;
use Illuminate\Support\Facades\Session;

use Yajra\Datatables\Datatables;
use Vinkla\Hashids\Facades\Hashids;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
		if(Auth::user()->can('video')) {
			return view('backend.video.datatable');
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
		if(Auth::user()->can('video')) {
			return view('backend.video.datatable');
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
		$videos = Video::leftJoin('users', 'users.id', '=', 'videos.created_by')
			->select('videos.*', 'users.id as uid', 'users.name as uname');
		return Datatables::of($videos)
			->addColumn('check', function ($video) {
				$check = '<div style="text-align:center;">
					<input type="checkbox" id="titleCheckdel" />
					<input type="hidden" class="deldata" name="id[]" value="'.Hashids::encode($video->id).'" disabled />
				</div>';
				return $check;
			})
			->addColumn('active', function ($video) {
				return $video->active == 'Y' ? 'Active' : 'Non Active';
			})
            ->addColumn('action', function ($video) {
				$btn = '<div style="text-align:center;">';
				$btn .= '<a href="'.url('dashboard/video/'.Hashids::encode($video->id).'').'" class="btn btn-secondary btn-sm" title="View"><span class="fa fa-eye" aria-hidden="true"/></a> ';
				$btn .= '<a href="'.url('dashboard/video/'.Hashids::encode($video->id).'/edit').'" class="btn btn-primary btn-sm" title="Edit"><span class="fa fa-pencil" aria-hidden="true"/></a> ';
				$btn .= '<a href="'.url('dashboard/video/'.Hashids::encode($video->id).'').'" class="btn btn-danger btn-sm" data-delete="" title="Delete"><span class="fa fa-trash" aria-hidden="true"></span></a>';
				$btn .= '</div>';
				return $btn;
            })
			->addColumn('control', function ($video) {
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
		if(Auth::user()->can('video')) {
			return view('backend.video.create');
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
		if(Auth::user()->can('video')) {
			$this->validate($request, [
				'title' => 'required',
				'youtube_url' => 'required',
				// 'youtube_id' => 'required',
				// 'picture' => 'required',
				'active' => 'required'
			]);
			$youtube_url = $request->input('youtube_url');
			 $fetch = explode("v=", $youtube_url);
                $videoid = $fetch[1];
                $explodeID = explode("&", $videoid);
                $videoidfix = $explodeID[0];
			$request->request->add([
			    'youtube_id' =>$videoidfix,
			    'picture' => 'http://img.youtube.com/vi/' . $videoidfix . '/sddefault.jpg',
				'created_by' => Auth::User()->id,
				'updated_by' => Auth::User()->id
			]);
			$requestData = $request->all();

			Video::create($requestData);

			Session::flash('flash_message', 'Video added!');

			return redirect('dashboard/video/table');
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
		if(Auth::user()->can('video')) {
			$ids = Hashids::decode($id);
			$video = Video::findOrFail($ids[0]);

			return view('backend.video.show', compact('video'));
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
		if(Auth::user()->can('video')) {
			$ids = Hashids::decode($id);
			$video = Video::findOrFail($ids[0]);

			return view('backend.video.edit', compact('video'));
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
		if(Auth::user()->can('video')) {
			$ids = Hashids::decode($id);
			$this->validate($request, [
				'title' => 'required',
				'youtube_url' => 'required',
				// 'youtube_id' => 'required',
				// 'picture' => 'required',
				'active' => 'required'
			]);
				$youtube_url = $request->input('youtube_url');
			 $fetch = explode("v=", $youtube_url);
                $videoid = $fetch[1];
                $explodeID = explode("&", $videoid);
                $videoidfix = $explodeID[0];
			$request->request->add([
				'updated_by' => Auth::User()->id,
				 'youtube_id' =>$videoidfix,
			    'picture' => 'http://img.youtube.com/vi/' . $videoidfix . '/sddefault.jpg',
			]);
			$requestData = $request->all();

			$video = Video::findOrFail($ids[0]);
			$video->update($requestData);

			Session::flash('flash_message', 'Video updated!');

			return redirect('dashboard/video/table');
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
		if(Auth::user()->can('video')) {
			$ids = Hashids::decode($id);
			Video::destroy($ids[0]);

			Session::flash('flash_message', 'Video deleted!');

			return redirect('dashboard/video/table');
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
					Video::destroy($idd[0]);
				}
				Session::flash('flash_message', 'Video deleted!');
			} else {
				Session::flash('flash_message', 'No data deleted!');
			}

			return redirect('dashboard/video/table');
		} else {
			return redirect('dashboard');
		}
    }
}
