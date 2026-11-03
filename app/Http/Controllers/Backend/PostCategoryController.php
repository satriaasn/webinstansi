<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\PostCategory;
use App\Models\User;
use Session;

use Yajra\Datatables\Datatables;
use Vinkla\Hashids\Facades\Hashids;

class PostCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
		if(Auth::user()->can('postcategory')) {
			return view('backend.post-category.datatable');
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
		if(Auth::user()->can('postcategory')) {
			return view('backend.post-category.datatable');
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
			$postcategorys = PostCategory::leftJoin('users', 'users.id', '=', 'post_categorys.created_by')
				->select('post_categorys.*', 'users.id as uid', 'users.name as uname');
		} else {
			$postcategorys = PostCategory::leftJoin('users', 'users.id', '=', 'post_categorys.created_by')
				->where('post_categorys.created_by', '=', Auth::user()->id)
				->select('post_categorys.*', 'users.id as uid', 'users.name as uname');
		}
		return Datatables::of($postcategorys)
			->addColumn('check', function ($postcategory) {
				$check = '<div style="text-align:center;">
					<input type="checkbox" id="titleCheckdel" />
					<input type="hidden" class="deldata" name="id[]" value="'.Hashids::encode($postcategory->id).'" disabled />
				</div>';
				return $check;
			})
			->addColumn('active', function ($postcategory) {
				return $postcategory->active == 'Y' ? 'Active' : 'Non Active';
			})
            ->addColumn('action', function ($postcategory) {
				$btn = '<div style="text-align:center;">';
				$btn .= '<a href="'.url('dashboard/post-category/'.Hashids::encode($postcategory->id).'').'" class="btn btn-secondary btn-sm" title="View"><span class="fa fa-eye" aria-hidden="true"/></a> ';
				$btn .= '<a href="'.url('dashboard/post-category/'.Hashids::encode($postcategory->id).'/edit').'" class="btn btn-primary btn-sm" title="Edit"><span class="fa fa-pencil" aria-hidden="true"/></a> ';
				$btn .= '<a href="'.url('dashboard/post-category/'.Hashids::encode($postcategory->id).'').'" class="btn btn-danger btn-sm" data-delete="" title="Delete"><span class="fa fa-trash" aria-hidden="true"></span></a>';
				$btn .= '</div>';
				return $btn;
            })
			->addColumn('control', function ($postcategory) {
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
		if(Auth::user()->can('postcategory')) {
			return view('backend.post-category.create');
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
		if(Auth::user()->can('postcategory')) {
			$this->validate($request, [
				'title' => 'required',
				'seotitle' => 'required'
			]);
			$request->request->add([
				'created_by' => Auth::User()->id,
				'updated_by' => Auth::User()->id
			]);
			$requestData = $request->all();

			PostCategory::create($requestData);

			Session::flash('flash_message', 'Post category added!');

			return redirect('dashboard/post-category/table');
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
		if(Auth::user()->can('postcategory')) {
			$ids = Hashids::decode($id);
			$postcategory = PostCategory::findOrFail($ids[0]);

			return view('backend.post-category.show', compact('postcategory'));
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
		if(Auth::user()->can('postcategory')) {
			$ids = Hashids::decode($id);
			$postcategory = PostCategory::findOrFail($ids[0]);

			return view('backend.post-category.edit', compact('postcategory'));
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
		if(Auth::user()->can('postcategory')) {
			$ids = Hashids::decode($id);
			$this->validate($request, [
				'title' => 'required',
				'seotitle' => 'required'
			]);
			$request->request->add([
				'updated_by' => Auth::User()->id
			]);
			$requestData = $request->all();

			$postcategory = PostCategory::findOrFail($ids[0]);
			$postcategory->update($requestData);

			Session::flash('flash_message', 'Post category updated!');

			return redirect('dashboard/post-category/table');
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
		if(Auth::user()->can('postcategory')) {
			$ids = Hashids::decode($id);
			PostCategory::destroy($ids[0]);

			Session::flash('flash_message', 'Post category deleted!');

			return redirect('dashboard/post-category/table');
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
		if(Auth::user()->can('postcategory')) {
			if ($request->has('id')) {
				$ids = $request->id;
				foreach($ids as $id){
					$idd = Hashids::decode($id);
					PostCategory::destroy($idd[0]);
				}
				Session::flash('flash_message', 'Post category deleted!');
			} else {
				Session::flash('flash_message', 'No data deleted!');
			}

			return redirect('dashboard/post-category/table');
		} else {
			return redirect('dashboard');
		}
    }
}
