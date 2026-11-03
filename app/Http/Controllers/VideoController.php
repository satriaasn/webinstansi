<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Visitor;

class VideoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
        //$this->visitor();
    }

	public function index()
    {
		$videos = Video::orderBy('id','DESC')->where([['videos.active', '=', 'Y']])->paginate(6);
		return view(getTheme('video'), compact('videos'));
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
