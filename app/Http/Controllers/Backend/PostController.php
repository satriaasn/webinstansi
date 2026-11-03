<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use Session;

use Yajra\Datatables\Datatables;
use Vinkla\Hashids\Facades\Hashids;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (Auth::user()->can('post')) {
            return view('backend.post.datatable');
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
        if (Auth::user()->can('post')) {
            return view('backend.post.datatable');
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
            $post = Post::leftJoin('users', 'users.id', '=', 'posts.created_by')
                ->leftJoin('post_categorys', 'post_categorys.id', '=', 'posts.post_category_id')
                ->select('posts.*', 'users.id as uid', 'users.name as uname', 'post_categorys.id as aid', 'post_categorys.title as atitle');
        } else {
            $post = Post::leftJoin('users', 'users.id', '=', 'posts.created_by')
                ->leftJoin('post_categorys', 'post_categorys.id', '=', 'posts.post_category_id')
                ->where('posts.created_by', '=', Auth::user()->id)
                ->select('posts.*', 'users.id as uid', 'users.name as uname');
        }
        return Datatables::of($post)
            ->addColumn('check', function ($post) {
                $check = '<div style="text-align:center;">
					<input type="checkbox" id="titleCheckdel" />
					<input type="hidden" class="deldata" name="id[]" value="' . Hashids::encode($post->id) . '" disabled />
				</div>';
                return $check;
            })
            ->addColumn('headline', function ($post) {
                return $post->headline == 'Y' ? 'Headline' : 'Non Headline';
            })
            ->addColumn('active', function ($post) {
                return $post->active == 'Y' ? 'Active' : 'Non Active';
            })
            ->addColumn('action', function ($post) {
                $btn = '<div style="text-align:center;">';
                $btn .= '<a href="' . url('dashboard/post/' . Hashids::encode($post->id) . '') . '" class="btn btn-secondary btn-sm" title="View"><span class="fa fa-eye" aria-hidden="true"/></a> ';
                $btn .= '<a href="' . url('dashboard/post/' . Hashids::encode($post->id) . '/edit') . '" class="btn btn-primary btn-sm" title="Edit"><span class="fa fa-pencil" aria-hidden="true"/></a> ';
                $btn .= '<a href="' . url('dashboard/post/' . Hashids::encode($post->id) . '') . '" class="btn btn-danger btn-sm" data-delete="" title="Delete"><span class="fa fa-trash" aria-hidden="true"></span></a>';
                $btn .= '</div>';
                return $btn;
            })
            ->addColumn('control', function ($post) {
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
        if (Auth::user()->can('post')) {
            $post_categorys = PostCategory::where('active', '=', 'Y')->get();
            $selected_category = request()->query('category_id');

            return view('backend.post.create', compact('post_categorys', 'selected_category'));
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
        if (Auth::user()->can('post')) {
            $rule = [
                'post_category_id' => 'required',
                'title' => 'required',
                'seotitle' => 'required',
                'content' => 'required'
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
            $post = Post::create($requestData);
            Session::flash('flash_message', 'Post added!');

            $postCategory = PostCategory::find($requestData['post_category_id']);
            if ($postCategory) {
                $hashId = Hashids::encode($post->id);
                if ($postCategory->seotitle == 'kuliner') {
                    return redirect('dashboard/post-culinary/'.$hashId.'/edit');
                } elseif ($postCategory->seotitle == 'akomodasi') {
                    return redirect('dashboard/post-accommodation/'.$hashId.'/edit');
                } elseif ($postCategory->seotitle == 'transportasi') {
                    return redirect('dashboard/post-transport/'.$hashId.'/edit');
                } elseif (in_array($postCategory->seotitle, ['pariwisata', 'ekonomi-kreatif'])) {
                    return redirect('dashboard/post-destination/'.$hashId.'/edit');
                }
            }

            return redirect('dashboard/post/table');
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
        if (Auth::user()->can('post')) {
            $ids = Hashids::decode($id);
            $post = Post::findOrFail($ids[0]);

            return view('backend.post.show', compact('post'));
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
        if (Auth::user()->can('post')) {
            $ids = Hashids::decode($id);
            $post = Post::findOrFail($ids[0]);
            //dd($post);
            $post_categorys = PostCategory::where('active', '=', 'Y')->get();

            return view('backend.post.edit', compact('post', 'post_categorys'));
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
        if (Auth::user()->can('post')) {
            $ids = Hashids::decode($id);

            $rule = [
                'post_category_id' => 'required',
                'title' => 'required',
                'seotitle' => 'required',
                'content' => 'required'
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

            $post = Post::findOrFail($ids[0]);
            $post->update($requestData);

            Session::flash('flash_message', 'Post updated!');

            return redirect('dashboard/post/table');
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
        if (Auth::user()->can('post')) {
            $ids = Hashids::decode($id);
            Post::destroy($ids[0]);

            Session::flash('flash_message', 'Post deleted!');

            return redirect('dashboard/post/table');
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
        if (Auth::user()->can('post')) {
            if ($request->has('id')) {
                $ids = $request->id;
                foreach ($ids as $id) {
                    $idd = Hashids::decode($id);
                    Post::destroy($idd[0]);
                }
                Session::flash('flash_message', 'Post deleted!');
            } else {
                Session::flash('flash_message', 'No data deleted!');
            }

            return redirect('dashboard/post/table');
        } else {
            return redirect('dashboard');
        }
    }
}
