<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Visitor;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
       // $this->visitor();
        //session_start();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->filled("key") || $request->get("key") != "PemprovLampung") {
            return response()->json([
                "message" => "Anda tidak memiliki izin ini!",
                "status" => false
            ],403);
        }
        
		$posts = Post::query();
        
        // Conditionally include Tripadvisor data based on environment or URL
        if (app()->environment('local', 'development') || config('app.url') == 'https://disparekraf.lampungprov.go.id') {
            $posts->with([
                'destination', 
                'approvedReviews', 
                'relatedPosts.destination',
                'relatedPosts.accommodation', 
                'relatedPosts.culinary', 
                'relatedPosts.transport',
                'mappedToPosts.destination',
                'mappedToPosts.accommodation', 
                'mappedToPosts.culinary', 
                'mappedToPosts.transport',
                'accommodation', 
                'culinary', 
                'transport'
            ]);
        }

        $posts->leftJoin('users', 'users.id', 'posts.created_by')
        ->leftJoin('post_categorys', 'post_categorys.id', 'posts.post_category_id')
        ->where([['posts.active', '=', 'Y']])
        ->select('posts.*', 'post_categorys.title as ctitle', 'users.name');
        if($request->filled("search")) {
            $posts = $posts->where('title', 'like', '%'.$request->get('search').'%');   
        }
        if($request->filled("start_date") && $request->filled("end_date")) {
            $posts = $posts->whereBetween('created_at', [$request->get('start_date'), $request->get('end_date')]);
        }


        $posts = $posts->orderBy('posts.created_at', 'desc')
        ->paginate($request->get("size", 10));

        // Merge mappedToPosts into relatedPosts for bidirectional consistency in API
        if (app()->environment('local', 'development') || config('app.url') == 'https://disparekraf.lampungprov.go.id') {
            foreach ($posts->items() as $post) {
                if ($post->relationLoaded('mappedToPosts') && $post->relationLoaded('relatedPosts')) {
                    $merged = $post->relatedPosts->merge($post->mappedToPosts)->unique('id')->values();
                    
                    $destinations = [];
                    $accommodations = [];
                    $culinaries = [];
                    $transports = [];

                    foreach ($merged as $rp) {
                        if ($rp->postCategory) {
                             $mappedParams = [
                                 'id' => $rp->id,
                                 'title' => $rp->title,
                                 'seotitle' => $rp->seotitle,
                                 'picture_url' => $rp->picture ? berkas_asset($rp->picture) : null,
                             ];

                             if (in_array($rp->postCategory->seotitle, ['pariwisata', 'ekonomi-kreatif'])) {
                                 if ($rp->destination) {
                                     $mappedParams['address'] = $rp->destination->address;
                                 }
                                 $destinations[] = $mappedParams;
                             } elseif ($rp->postCategory->seotitle == 'akomodasi') {
                                 if ($rp->accommodation) {
                                     $mappedParams['accommodation_type'] = $rp->accommodation->accommodation_type;
                                     $mappedParams['star_rating'] = $rp->accommodation->star_rating;
                                 }
                                 $accommodations[] = $mappedParams;
                             } elseif ($rp->postCategory->seotitle == 'kuliner') {
                                 if ($rp->culinary) {
                                     $mappedParams['cuisine_type'] = $rp->culinary->cuisine_type;
                                 }
                                 $culinaries[] = $mappedParams;
                             } elseif ($rp->postCategory->seotitle == 'transportasi') {
                                 if ($rp->transport) {
                                     $mappedParams['transport_mode'] = $rp->transport->transport_mode;
                                     $mappedParams['route_origin'] = $rp->transport->route_origin;
                                     $mappedParams['route_destination'] = $rp->transport->route_destination;
                                     $mappedParams['estimated_price'] = $rp->transport->estimated_price;
                                 }
                                 $transports[] = $mappedParams;
                             }
                        }
                    }

                    $post->setAttribute('related_grouped', [
                        'destinations' => $destinations,
                        'accommodations' => $accommodations,
                        'culinaries' => $culinaries,
                        'transports' => $transports,
                    ]);

                    $post->unsetRelation('relatedPosts');
                    $post->unsetRelation('mappedToPosts');
                }
            }
        }

        $posts = $posts->toArray();
        $posts["message"] = "Berhasil mendapatkan data!";
        $posts["status"] = true;
        return response()->json($posts);
    }

	
}
