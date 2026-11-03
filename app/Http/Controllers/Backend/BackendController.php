<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Download;
use App\Models\DownloadCategory;
use App\Models\Pages;
use App\Models\Album;
use App\Models\Gallery;
use App\Models\Agenda;
use App\Models\Video;
use App\Models\Menu;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;

class BackendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index(Request $request)
    {
        $cposts = Post::count();
        $cpages = Pages::count();
        $cagendas = Agenda::count();
        $cdownloads = Download::count();
        $cgallerys = Gallery::count();
        $calbums = Album::count();
        $cvideos = Video::count();
        $ccontacts = Contact::count();


        return view('backend.dashboard', compact('cposts', 'cpages', 'cagendas', 'cdownloads', 'cgallerys', 'calbums', 'cvideos', 'ccontacts'));
    }

    public function getAnalyticsData(Request $request)
    {
        if (env('G_ANAL_MEASUREMENT_ID')) {
            // Ambil tanggal dari request AJAX
            $startDate = Carbon::parse($request->input('start_date'));
            $endDate = Carbon::parse($request->input('end_date'));
            $period = Period::create($startDate, $endDate);

            // Buat kunci cache yang unik berdasarkan rentang tanggal
            $cacheKey = 'analytics_data_' . $startDate->toDateString() . '_' . $endDate->toDateString();

            // Gunakan Cache::remember() untuk mengambil atau menyimpan data
            $data = Cache::remember($cacheKey, now()->addMinutes(30), function () use ($period) {
                // Logika ini hanya akan dijalankan jika cache tidak ada atau sudah kedaluwarsa
                return [
                    'visitorsAndPageViews' => Analytics::fetchVisitorsAndPageViews($period),
                    'totalVisitorsAndPageViews' => Analytics::fetchTotalVisitorsAndPageViews($period),
                    'mostVisitedPages' => Analytics::fetchMostVisitedPages($period),
                    'topReferrers' => Analytics::fetchTopReferrers($period),
                    'userTypes' => Analytics::fetchUserTypes($period),
                    'topBrowsers' => Analytics::fetchTopBrowsers($period),
                ];
            });

            // Kembalikan data (dari cache atau dari API) dalam bentuk JSON
            return response()->json($data);
        } else {
            return response()->json([]);
        }
    }

}
