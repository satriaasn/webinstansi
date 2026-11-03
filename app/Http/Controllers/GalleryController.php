<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Visitor;

class GalleryController extends Controller
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
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$page = request()->get('page', 1);
		$cacheKey = "gallery_index_page_{$page}";
		$albums = \Illuminate\Support\Facades\Cache::remember($cacheKey, 86400, function () {
			return Album::leftJoin('users', 'users.id', 'albums.created_by')
				->where([['albums.active', '=', 'Y']])
				->select('albums.*', 'users.name')
				->orderBy('albums.id', 'desc')
				->paginate(6);
		});
		return view(getTheme('album'), compact('albums'));
    }

	public function detail($seotitle)
    {
		$page = request()->get('page', 1);
		$cacheKey = "gallery_detail_{$seotitle}_page_{$page}";
		$data = \Illuminate\Support\Facades\Cache::remember($cacheKey, 86400, function () use ($seotitle) {
			$album = Album::where([['seotitle', '=', $seotitle]])->first();

			$gallerys = Gallery::leftJoin('users', 'users.id', 'gallerys.created_by')
				->leftJoin('albums', 'albums.id', 'gallerys.album_id')
				->where([['gallerys.active', '=', 'Y'],['albums.seotitle', '=', $seotitle]])
				->select('gallerys.*', 'albums.title as atitle', 'users.name')
				->paginate(6);

			return compact('album', 'gallerys');
		});

		return view(getTheme('gallery'), $data);
    }

    public static function getLatestGallery($id_album,$limit){
		$cacheKey = "latest_gallery_{$id_album}_{$limit}";
		return \Illuminate\Support\Facades\Cache::remember($cacheKey, 86400, function () use ($id_album, $limit) {
			return Gallery::where('album_id', $id_album)
				->limit($limit)
				->orderBy('created_at', "DESC")
				->get();
		});
    }

    public function visitor(){

        session_start();
        $session_id = session_id();;
        $date = date('Y-m-d');
        $results = DB::select("SELECT * FROM `visitors` WHERE `session_id` = '". $session_id ."' AND date_time = '". $date ."' ");
        if (count($results) < 1){
            $ip = $this->getCLientIP();
            $visitor = array(
                'session_id'=>$session_id,
                'ip_client'=>$ip,
                'user_agent'=>$_SERVER['HTTP_USER_AGENT'],
                'date_time'=>$date
            );
            Visitor::create($visitor);
        }
    }

    public function getCLientIP(){
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP)){
            $ip = $client;
        }elseif(filter_var($forward, FILTER_VALIDATE_IP)){
            $ip = $forward;
        }else{
            $ip = $remote;
        }
        return $ip;
    }
}
