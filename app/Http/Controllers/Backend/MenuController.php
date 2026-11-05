<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Menu;
use Session;

use Yajra\Datatables\Datatables;
use Vinkla\Hashids\Facades\Hashids;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
		if(Auth::user()->can('menu')) {
			$menu = new Menu;
			$menulist = $menu->tree();

			return view('backend.menu.index')->with('menu', $menulist);
		} else {
			return redirect('dashboard');
		}
	}

	/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
		if(Auth::user()->can('menu')) {
			return view('backend.menu.create');
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
		if(Auth::user()->can('menu')) {
			$this->validate($request, [
				'name' => 'required',
				'url' => 'required',
				'target' => 'required'
			]);
			$request->request->add([
				'created_by' => Auth::User()->id,
				'updated_by' => Auth::User()->id
			]);
			$requestData = $request->all();

			Menu::create($requestData);

			Session::flash('flash_message', 'Menu added!');

			return redirect('dashboard/menu');
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
		if(Auth::user()->can('menu')) {
			$ids = Hashids::decode($id);
			$menu = Menu::findOrFail($ids[0]);

			return view('backend.menu.edit', compact('menu'));
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
		if(Auth::user()->can('menu')) {
			$this->validate($request, [
				'name' => 'required',
				'url' => 'required',
				'target' => 'required'
			]);
			$request->request->add([
				'updated_by' => Auth::User()->id
			]);
			$requestData = $request->all();

			$ids = Hashids::decode($id);
			$menu = Menu::findOrFail($ids[0]);
			$menu->update($requestData);

			Session::flash('flash_message', 'Menu updated!');

			return redirect('dashboard/menu');
		} else {
			return redirect('dashboard');
		}
    }

	/**
     * Sort the specified resource in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function menusort(Request $request)
    {
		if(Auth::user()->can('menu')) {
			$raw = $request->input('data');
			if (empty($raw)) {
				return response()->json(['status' => 'error', 'message' => 'Data struktur menu kosong.'], 400);
			}
			$data = json_decode($raw);
			if (!is_array($data)) {
				return response()->json(['status' => 'error', 'message' => 'Format data struktur menu tidak valid.'], 400);
			}

			$readbleArray = $this->parseJsonArray($data);
			$userId = Auth::id();

			\DB::beginTransaction();
			try {
				$i = 0;
				foreach($readbleArray as $row){
					if (!isset($row['id'])) continue;
					$i++;
					Menu::where('id', $row['id'])->update([
						'parent_id' => $row['parentID'] ?? 0,
						'position' => $i,
						'updated_by' => $userId
					]);
				}
				\DB::commit();

				\Cache::forget('home_menu_tree');
				\Cache::flush();

				return response()->json([
					'status' => 'success',
					'message' => 'Susunan dan hierarki menu berhasil disimpan!'
				]);
			} catch (\Exception $e) {
				\DB::rollBack();
				return response()->json([
					'status' => 'error',
					'message' => 'Gagal memperbarui menu: ' . $e->getMessage()
				], 500);
			}
		} else {
			return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
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
		if(Auth::user()->can('menu')) {
			$ids = Hashids::decode($id);
			Menu::destroy($ids[0]);

			Session::flash('flash_message', 'Menu deleted!');

			return redirect('dashboard/menu');
		} else {
			return redirect('dashboard');
		}
    }

	public function parseJsonArray($jsonArray, $parentID = 0) {
		$return = array();
		foreach ($jsonArray as $subArray) {
			$returnSubSubArray = array();
			if (isset($subArray->children)) {
				$returnSubSubArray = $this->parseJsonArray($subArray->children, $subArray->id);
			}
			$return[] = array('id' => $subArray->id, 'parentID' => $parentID);
			$return = array_merge($return, $returnSubSubArray);
		}
		return $return;
	}
}
