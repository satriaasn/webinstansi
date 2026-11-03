<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostDestination;
use App\Models\PostAccommodation;
use App\Models\PostCulinary;
use App\Models\PostTransport;
use Session;

use Yajra\Datatables\Datatables;
use Vinkla\Hashids\Facades\Hashids;

class PostDestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (Auth::user()->can('post')) {
            return view('backend.post-destination.datatable');
        } else {
            return redirect('dashboard');
        }
    }

    /**
     * Displays datatables front end view
     */
    public function getIndex()
    {
        return $this->index();
    }

    /**
     * Process datatables ajax request.
     */
    public function anyData()
    {
        // Only get posts that belong to Pariwisata or Ekonomi Kreatif
        $pariwisata_cat = PostCategory::where('seotitle', 'pariwisata')->value('id');
        $ekraf_cat = PostCategory::where('seotitle', 'ekonomi-kreatif')->value('id');

        $cats = array_filter([$pariwisata_cat, $ekraf_cat]);
        
        $post = Post::leftJoin('post_destinations', 'post_destinations.post_id', '=', 'posts.id')
            ->leftJoin('post_categorys', 'post_categorys.id', '=', 'posts.post_category_id')
            ->whereIn('posts.post_category_id', $cats)
            ->select('posts.id', 'posts.title', 'post_categorys.title as cat_title', 'post_destinations.id as dest_id', 'post_destinations.city');

        return Datatables::of($post)
            ->addColumn('status_dest', function ($post) {
                return $post->dest_id ? '<span class="badge bg-success">Isi Data</span>' : '<span class="badge bg-warning">Belum Isi</span>';
            })
            ->addColumn('action', function ($post) {
                $btn = '<div style="text-align:center;">';
                $btn .= '<a href="' . url('dashboard/post-destination/' . Hashids::encode($post->id) . '/edit') . '" class="btn btn-primary btn-sm" title="Edit Destinasi"><span class="fa fa-pencil" aria-hidden="true"/> Edit Destinasi</a> ';
                $btn .= '</div>';
                return $btn;
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (Auth::user()->can('post')) {
            $ids = Hashids::decode($id);
            $post = Post::findOrFail($ids[0]);
            
            // Destination data
            $destination = PostDestination::where('post_id', $post->id)->first() ?? new PostDestination();
            
            // Get all potential related items from allowed categories
            $allowed_cats = PostCategory::whereIn('seotitle', ['pariwisata', 'ekonomi-kreatif', 'akomodasi', 'kuliner', 'transportasi'])->pluck('id')->toArray();
            
            $all_related_options = Post::whereIn('post_category_id', $allowed_cats)
                ->where('id', '!=', $post->id)
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->id => $item->title . ' (' . ($item->postCategory->title ?? 'Uncategorized') . ')'];
                });

            // Get currently related post IDs (bidirectional)
            $related_ids = array_unique(array_merge(
                $post->relatedPosts()->pluck('related_post_id')->toArray(),
                $post->mappedToPosts()->pluck('post_id')->toArray()
            ));

            return view('backend.post-destination.edit', compact(
                'post', 
                'destination', 
                'all_related_options',
                'related_ids'
            ));
        } else {
            return redirect('dashboard');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        if (Auth::user()->can('post')) {
            $ids = Hashids::decode($id);
            $post = Post::findOrFail($ids[0]);

            // 1. Update Destination Info (1:1)
            $destData = $request->only(['city', 'region', 'address', 'opening_hours', 'ticket_price', 'contact_info', 'latitude', 'longitude']);
            $destData['post_id'] = $post->id;
            $destination = PostDestination::where('post_id', $post->id)->first();
            if($destination){ $destination->update($destData); } else { PostDestination::create($destData); }

            // 2. Update Related Content (Many-to-Many Bidirectional)
            $related_ids = $request->input('related_posts', []);
            
            // Unlink all existing relationships to/from this post
            $post->relatedPosts()->detach();
            $post->mappedToPosts()->detach();

            // Create new relationships
            $post->relatedPosts()->sync($related_ids);

            Session::flash('flash_message', 'Data Destinasi dan Keterhubungan Layanan berhasil disimpan!');

            return redirect('dashboard/post-destination/table');
        } else {
            return redirect('dashboard');
        }
    }
}
