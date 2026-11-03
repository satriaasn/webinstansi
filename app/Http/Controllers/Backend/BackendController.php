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
use App\Models\PermohonanInformasi;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
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

        // Data terbaru untuk dashboard interaktif (Matching Mockup)
        $latestPosts = Post::where('active', 'Y')->orderBy('id', 'desc')->take(3)->get();
        $latestAgendas = Agenda::where('active', 'Y')->orderBy('id', 'desc')->take(3)->get();
        $latestDownloads = Download::where('active', 'Y')->orderBy('id', 'desc')->take(4)->get();
        $latestGallery = Gallery::where('active', 'Y')->orderBy('id', 'desc')->take(6)->get();
        $totalGalleryCount = Gallery::where('active', 'Y')->count();
        $totalVisitors = Visitor::count();

        $ppidCounts = [
            'total'    => PermohonanInformasi::count(),
            'pending'  => PermohonanInformasi::where('status', 'pending')->count(),
            'diproses' => PermohonanInformasi::where('status', 'diproses')->count(),
            'selesai'  => PermohonanInformasi::where('status', 'selesai')->count(),
        ];

        // 30-hari grafik pengunjung
        $visitorChart = Cache::remember('dashboard_visitor_chart', 3600, function () {
            return DB::table('visitors')
                ->select('date_time', DB::raw('count(*) as total'))
                ->where('date_time', '>=', now()->subDays(30)->toDateString())
                ->groupBy('date_time')
                ->orderBy('date_time', 'asc')
                ->get();
        });

        return view('backend.dashboard', compact(
            'cposts', 'cpages', 'cagendas', 'cdownloads', 'cgallerys', 'calbums', 'cvideos', 'ccontacts',
            'latestPosts', 'latestAgendas', 'latestDownloads', 'latestGallery', 'totalGalleryCount', 'totalVisitors',
            'ppidCounts', 'visitorChart'
        ));
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
