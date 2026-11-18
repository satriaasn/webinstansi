<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Visitor;

class AgendaController extends Controller
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
    public function index(Request $request)
    {
		$query = Agenda::leftJoin('users', 'users.id', 'agendas.created_by')
			->where('agendas.active', '=', 'Y')
			->select('agendas.*', 'users.name');

		if ($request->filled('q')) {
			$search = $request->get('q');
			$query->where(function ($q) use ($search) {
				$q->where('agendas.title', 'like', "%{$search}%")
				  ->orWhere('agendas.location', 'like', "%{$search}%")
				  ->orWhere('agendas.penyelenggara', 'like', "%{$search}%")
				  ->orWhere('agendas.content', 'like', "%{$search}%");
			});
		}

		$agendas = $query->orderBy('agendas.start', 'desc')
			->paginate(9)
			->withQueryString();

		return view(getTheme('agenda'), compact('agendas'));
    }

	public function detail($seotitle)
    {
		$agenda = Agenda::leftJoin('users', 'users.id', 'agendas.created_by')
			->where('agendas.active', '=', 'Y')
			->where(function ($q) use ($seotitle) {
				$q->where('agendas.seotitle', '=', $seotitle)
				  ->orWhere('agendas.api_id', '=', $seotitle);
			})
			->select('agendas.*', 'users.name')
			->first();

		if (!$agenda) {
			abort(404, 'Agenda kegiatan tidak ditemukan.');
		}

		return view(getTheme('detailagenda'), compact('agenda'));
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
