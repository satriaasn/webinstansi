<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Visitor;
use Illuminate\Support\Facades\Cache;

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
    public function index($seotitle)
    {
        $page = request()->get('page', 1);
        $cacheKey = "post_index_{$seotitle}_page_{$page}";

        $data = Cache::remember($cacheKey, 86400, function () use ($seotitle) {
            if ($seotitle == 'all') {
                $posts = Post::leftJoin('users', 'users.id', 'posts.created_by')
                    ->leftJoin('post_categorys', 'post_categorys.id', 'posts.post_category_id')
                    ->where([['posts.active', '=', 'Y']])
                    ->select('posts.*', 'post_categorys.title as ctitle', 'users.name')
                    ->orderBy('posts.id', 'desc')
                    ->paginate(6);
                $category = PostCategory::where([['active', '=', 'Y']])->first();
            } else {
                $category = PostCategory::where([['seotitle', '=', $seotitle], ['active', '=', 'Y']])->first();
                if ($category) {
                    $posts = Post::leftJoin('users', 'users.id', 'posts.created_by')
                        ->leftJoin('post_categorys', 'post_categorys.id', 'posts.post_category_id')
                        ->where([['posts.post_category_id', '=', $category->id], ['posts.active', '=', 'Y']])
                        ->select('posts.*', 'post_categorys.title as ctitle', 'users.name')
                        ->orderBy('posts.id', 'desc')
                        ->paginate(6);
                } else {
                    $posts = Post::leftJoin('users', 'users.id', 'posts.created_by')
                        ->leftJoin('post_categorys', 'post_categorys.id', 'posts.post_category_id')
                        ->where([['posts.active', '=', 'Y']])
                        ->select('posts.*', 'post_categorys.title as ctitle', 'users.name')
                        ->orderBy('posts.id', 'desc')
                        ->paginate(6);
                }
            }

            return compact('posts', 'category', 'seotitle');
        });

        return view(getTheme('post'), $data);
    }

    public function search(Request $request)
    {
        $posts = Post::leftJoin('users', 'users.id', 'posts.created_by')
            ->leftJoin('post_categorys', 'post_categorys.id', 'posts.post_category_id')
            ->where([
                ['posts.active', '=', 'Y'],
                ['posts.post_category_id', '=', '1'],
                ['posts.title', 'LIKE', '%' . $request['query'] . '%']
            ])
            ->orWhere('posts.content', 'LIKE', '%' . $request['query'] . '%')
            ->select('posts.*', 'post_categorys.title as ctitle', 'users.name')
            ->orderBy('posts.id', 'desc')
            ->paginate(6);
        return view(getTheme('post'), compact('posts'));
    }

    public function detail($seotitle)
    {
        $cacheKey = "post_detail_{$seotitle}";
        $post = Cache::remember($cacheKey, 86400, function () use ($seotitle) {
            $p = Post::leftJoin('users', 'users.id', 'posts.created_by')
                ->leftJoin('post_categorys', 'post_categorys.id', 'posts.post_category_id')
                ->where([['posts.active', '=', 'Y'], ['posts.seotitle', '=', $seotitle]])
                ->select('posts.*', 'post_categorys.title as ctitle', 'post_categorys.seotitle as cseotitle', 'users.name')
                ->first();

            if (!$p) {
                return null;
            }

            if (config('app.url') == 'https://disparekraf.lampungprov.go.id') {
                $p->load(['destination', 'approvedReviews']);
            }

            return $p;
        });

        if (!$post) {
            abort(404);
        }

        DB::table('posts')->where('id', $post->id)->increment('hit');

        return view(getTheme('detailpost'), compact('post'));
    }

    public static function idkategoriPost($limit, $offset = '0', $post_category_id)
    {
        $cacheKey = "idkategoriPost_{$post_category_id}_{$limit}_{$offset}";
        return Cache::remember($cacheKey, 86400, function () use ($limit, $offset, $post_category_id) {
            $result = Post::leftJoin('users', 'users.id', 'posts.created_by')
                ->leftJoin('post_categorys', 'post_categorys.id', 'posts.post_category_id')
                ->where('post_category_id', $post_category_id)
                ->where([['posts.active', '=', 'Y']])
                ->select('posts.*', 'post_categorys.title as ctitle', 'users.name')
                ->orderBy('posts.id', 'desc')
                ->limit($limit)
                ->offset($offset)
                ->get();
            return $result;
        });
    }

    public static function seokategoriPost($limit, $offset = '0', $seo_category)
    {
        $cacheKey = "seokategoriPost_{$seo_category}_{$limit}_{$offset}";
        return Cache::remember($cacheKey, 86400, function () use ($limit, $offset, $seo_category) {
            $result = Post::leftJoin('users', 'users.id', 'posts.created_by')
                ->leftJoin('post_categorys', 'post_categorys.id', 'posts.post_category_id')
                ->where('post_categorys.seotitle', $seo_category)
                ->where([['posts.active', '=', 'Y']])
                ->select('posts.*', 'post_categorys.title as ctitle', 'users.name')
                ->orderBy('posts.id', 'desc')
                ->limit($limit)
                ->offset($offset)
                ->get();
            return $result;
        });
    }



    public function visitor()
    {

        $session_id = session_id();
        $date = date('Y-m-d');
        $results = DB::select("SELECT * FROM `visitors` WHERE `session_id` = '" . $session_id . "' AND date_time = '" . $date . "' ");
        if (count($results) < 1) {
            $ip = $this->getCLientIP();
            $visitor = array(
                'session_id' => $session_id,
                'ip_client' => $ip,
                'user_agent' => $_SERVER['HTTP_USER_AGENT'],
                'date_time' => $date
            );
            Visitor::create($visitor);
        }
    }

    public function getCLientIP()
    {
        $client = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote = $_SERVER['REMOTE_ADDR'];

        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }
        return $ip;
    }

    public function storeReview(Request $request, $post_id)
    {
        $request->validate([
            'guest_name' => 'required|string|max:150',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string'
        ]);

        \App\Models\PostReview::create([
            'post_id' => $post_id,
            'guest_name' => $request->guest_name,
            'guest_email' => $request->guest_email,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 'pending' // default is pending
        ]);

        return redirect()->back()->with('success', 'Ulasan Anda berhasil dikirim dan sedang menunggu moderasi.');
    }
}
