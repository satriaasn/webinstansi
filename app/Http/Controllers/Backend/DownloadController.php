<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Download;
use App\Models\DownloadCategory;
use App\Models\User;
use Session;

use Yajra\Datatables\Datatables;
use Vinkla\Hashids\Facades\Hashids;

class DownloadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (Auth::user()->can('download')) {
            return view('backend.download.datatable');
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
        if (Auth::user()->can('download')) {
            return view('backend.download.datatable');
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
        if (Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin')) {
            $downloads = Download::leftJoin('users', 'users.id', '=', 'downloads.created_by')
                ->leftJoin('download_categorys', 'download_categorys.id', '=', 'downloads.download_category_id')
                ->select('downloads.*', 'users.id as uid', 'users.name as uname', 'download_categorys.id as aid', 'download_categorys.title as atitle');
        } else {
            $downloads = Download::leftJoin('users', 'users.id', '=', 'downloads.created_by')
                ->leftJoin('download_categorys', 'download_categorys.id', '=', 'downloads.download_category_id')
                ->where('downloads.created_by', '=', Auth::user()->id)
                ->select('downloads.*', 'users.id as uid', 'users.name as uname', 'download_categorys.id as aid', 'download_categorys.title as atitle');
        }
        return Datatables::of($downloads)
            ->addColumn('check', function ($download) {
                $check = '<div style="text-align:center;">
					<input type="checkbox" id="titleCheckdel" />
					<input type="hidden" class="deldata" name="id[]" value="' . Hashids::encode($download->id) . '" disabled />
				</div>';
                return $check;
            })
            ->addColumn('active', function ($download) {
                return $download->active == 'Y' ? 'Active' : 'Non Active';
            })
            ->addColumn('action', function ($download) {
                $btn = '<div style="text-align:center;">';
                $btn .= '<a href="' . url('dashboard/download/' . Hashids::encode($download->id) . '') . '" class="btn btn-secondary btn-sm" title="View"><span class="fa fa-eye" aria-hidden="true"/></a> ';
                $btn .= '<a href="' . url('dashboard/download/' . Hashids::encode($download->id) . '/edit') . '" class="btn btn-primary btn-sm" title="Edit"><span class="fa fa-pencil" aria-hidden="true"/></a> ';
                $btn .= '<a href="' . url('dashboard/download/' . Hashids::encode($download->id) . '') . '" class="btn btn-danger btn-sm" data-delete="" title="Delete"><span class="fa fa-trash" aria-hidden="true"></span></a>';
                $btn .= '</div>';
                return $btn;
            })
            ->addColumn('control', function ($download) {
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
        if (Auth::user()->can('download')) {
            $download_categorys = DownloadCategory::where('active', '=', 'Y')->get();

            return view('backend.download.create', compact('download_categorys'));
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
        if (Auth::user()->can('download')) {
            $rule = [
                'download_category_id' => 'required',
                'title' => 'required',
                'seotitle' => 'required',
                'file' => 'required|mimes:pdf'
            ];
            $this->validate($request, $rule);
            $request->request->add([
                'created_by' => Auth::User()->id,
                'updated_by' => Auth::User()->id
            ]);
            $requestData = $request->all();
            if ($request->hasFile('file')) {
                $image = $request->file('file');
                $hashImage = $image->hashName();
                $image->storeAs('public/uploads', $hashImage);
                $requestData['file'] = $hashImage;
            }

            Download::create($requestData);

            Session::flash('flash_message', 'Download added!');

            return redirect('dashboard/download/table');
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
        if (Auth::user()->can('download')) {
            $ids = Hashids::decode($id);
            $download = Download::findOrFail($ids[0]);

            return view('backend.download.show', compact('download'));
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
        if (Auth::user()->can('download')) {
            $ids = Hashids::decode($id);
            $download = Download::findOrFail($ids[0]);
            $download_categorys = DownloadCategory::where('active', '=', 'Y')->get();

            return view('backend.download.edit', compact('download', 'download_categorys'));
        } else {
            return redirect('dashboard');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        if (Auth::user()->can('download')) {
            $ids = Hashids::decode($id);

            $rule = [
                'download_category_id' => 'required',
                'title' => 'required',
                'seotitle' => 'required',

            ];
            if ($request->hasFile('file')) {
                $rule['file'] = 'required|mimes:pdf';
            }
            $this->validate($request, $rule);
            $request->request->add([
                'updated_by' => Auth::User()->id
            ]);
            $requestData = $request->all();
            if ($request->hasFile('file')) {
                $image = $request->file('file');
                $hashImage = $image->hashName();
                $image->storeAs('public/uploads', $hashImage);
                $requestData['file'] = $hashImage;
            }
            $download = Download::findOrFail($ids[0]);
            $download->update($requestData);

            Session::flash('flash_message', 'Download updated!');

            return redirect('dashboard/download/table');
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
        if (Auth::user()->can('download')) {
            $ids = Hashids::decode($id);
            Download::destroy($ids[0]);

            Session::flash('flash_message', 'Download deleted!');

            return redirect('dashboard/download/table');
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
        if (Auth::user()->can('download')) {
            if ($request->has('id')) {
                $ids = $request->id;
                foreach ($ids as $id) {
                    $idd = Hashids::decode($id);
                    Download::destroy($idd[0]);
                }
                Session::flash('flash_message', 'Download deleted!');
            } else {
                Session::flash('flash_message', 'No data deleted!');
            }

            return redirect('dashboard/download/table');
        } else {
            return redirect('dashboard');
        }
    }
}
