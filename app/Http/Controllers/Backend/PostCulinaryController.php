<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostCulinary;
use Session;

use Yajra\Datatables\Datatables;
use Vinkla\Hashids\Facades\Hashids;

class PostCulinaryController extends Controller
{
    public function index()
    {
        if (Auth::user()->can('post')) {
            return view('backend.post-culinary.datatable');
        } else {
            return redirect('dashboard');
        }
    }

    public function getIndex()
    {
        return $this->index();
    }

    public function anyData()
    {
        $cat_id = PostCategory::where('seotitle', 'kuliner')->value('id');
        
        $post = Post::leftJoin('post_culinaries', 'post_culinaries.post_id', '=', 'posts.id')
            ->leftJoin('post_categorys', 'post_categorys.id', '=', 'posts.post_category_id')
            ->where('posts.post_category_id', $cat_id)
            ->select('posts.id', 'posts.title', 'post_categorys.title as cat_title', 'post_culinaries.id as cul_id', 'post_culinaries.cuisine_type');

        return Datatables::of($post)
            ->addColumn('status_cul', function ($post) {
                return $post->cul_id ? '<span class="badge bg-success">Isi Data</span>' : '<span class="badge bg-warning">Belum Isi</span>';
            })
            ->addColumn('action', function ($post) {
                $btn = '<div style="text-align:center;">';
                $btn .= '<a href="' . url('dashboard/post-culinary/' . Hashids::encode($post->id) . '/edit') . '" class="btn btn-primary btn-sm"><span class="fa fa-pencil" aria-hidden="true"/> Edit Kuliner</a> ';
                $btn .= '</div>';
                return $btn;
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function edit($id)
    {
        if (Auth::user()->can('post')) {
            $ids = Hashids::decode($id);
            $post = Post::findOrFail($ids[0]);
            $culinary = PostCulinary::where('post_id', $post->id)->first() ?? new PostCulinary();

            // Get all potential "Destinasi" items to link to
            $allowed_cats = PostCategory::whereIn('seotitle', ['pariwisata', 'ekonomi-kreatif', 'akomodasi', 'kuliner', 'transportasi'])->pluck('id')->toArray();

            $all_related_options = Post::whereIn('post_category_id', $allowed_cats)
                ->where('id', '!=', $post->id)
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->id => $item->title . ' (' . ($item->postCategory->title ?? 'Uncategorized') . ')'];
                });

            $related_ids = array_unique(array_merge(
                $post->relatedPosts()->pluck('related_post_id')->toArray(),
                $post->mappedToPosts()->pluck('post_id')->toArray()
            ));

            return view('backend.post-culinary.edit', compact('post', 'culinary', 'all_related_options', 'related_ids'));
        } else {
            return redirect('dashboard');
        }
    }

    public function update($id, Request $request)
    {
        if (Auth::user()->can('post')) {
            $ids = Hashids::decode($id);
            $post = Post::findOrFail($ids[0]);

            $requestData = $request->except(['_token', '_method']);
            $requestData['post_id'] = $post->id;

            $culinary = PostCulinary::where('post_id', $post->id)->first();
            
            if($culinary){
                $culinary->update($requestData);
            } else {
                PostCulinary::create($requestData);
            }

            // Sync related Destination posts (Bidirectional)
            $related_ids = $request->input('related_posts', []);
            
            // Clear existing bidirectional links
            $post->relatedPosts()->detach();
            $post->mappedToPosts()->detach();

            // Reattach new links
            $post->relatedPosts()->sync($related_ids);

            Session::flash('flash_message', 'Data Kuliner berhasil disimpan!');
            return redirect('dashboard/post-culinary/table');
        } else {
            return redirect('dashboard');
        }
    }
}
