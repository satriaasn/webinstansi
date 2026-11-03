<?php

namespace App\Http\Controllers;

use App\Models\Download;
use App\Models\DownloadCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Visitor;

class DownloadController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($seotitle)
    {
		if ($seotitle == 'all') {
			$downloads = Download::leftJoin('download_categorys', 'download_categorys.id', '=', 'downloads.download_category_id')
				->where('downloads.active', '=', 'Y')
				->select('downloads.*', 'download_categorys.id as dcid', 'download_categorys.title as dctitle')
                ->orderByDesc('id')
				->paginate(20);
			$downloadcategorys = DownloadCategory::where('active', '=', 'Y')->first();
			return view(getTheme('download'), compact('seotitle', 'downloads', 'downloadcategorys'));
		} else {
			$downloadcategorys = DownloadCategory::where('seotitle', '=', $seotitle)->first();
			if ($downloadcategorys) {
				$downloads = Download::leftJoin('download_categorys', 'download_categorys.id', '=', 'downloads.download_category_id')
					->where([['downloads.download_category_id', '=', $downloadcategorys->id],['downloads.active', '=', 'Y']])
					->select('downloads.*', 'download_categorys.id as dcid', 'download_categorys.title as dctitle')
                    ->orderByDesc('id')
					->paginate(20);
				return view(getTheme('download'), compact('seotitle', 'downloads', 'downloadcategorys'));
			} else {
				return redirect('download/all');
			}
		}
    }

    public function visitor(){

        /*session_start();
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
        */
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
