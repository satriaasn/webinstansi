<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Download;
use App\Models\DownloadCategory;
use App\Models\Pages;
use App\Models\Album;
use App\Models\Gallery;
use App\Models\Agenda;
use App\Models\Theme;
use App\Models\Video;
use App\Models\Menu;
use App\Models\Slider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use App\Models\Visitor;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;

class HomeController extends Controller
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
    public function index()
    {
        $today = date("Y-m-d");
        $yesterday = date('Y-m-d', strtotime("-1 days"));
        $month = date('m');
        $year = date('Y');
        $videos = Cache::remember('home_videos', 86400, function () {
            return Video::where('active', '=', 'Y')->limit(6)->orderBy('id', 'DESC')->get();
        });
        $sliders = Cache::remember('home_sliders', 86400, function () {
            return Slider::where('active', '=', 'Y')->limit(6)->orderBy('id', 'DESC')->get();
        });

        $visitorStats = getVisitorStats();

        $visitor = array(
            'hari_ini' => $visitorStats['today'] ?? "-",
            'kemarin' => $visitorStats['yesterday'] ?? "-",
            'bulan_ini' => $visitorStats['thisMonth'] ?? "-",
            'tahun_ini' => $visitorStats['thisYear'] ?? "-",
            'total_visitor' => $visitorStats['total'] ?? "-"
        );
        $is_home = "true";

        // Ambil data theme aktif sekali saja untuk pengecekan
        $activeThemeObj = Theme::where('active', 'Y')->first();
        $tema_aktiv = $activeThemeObj ? $activeThemeObj->title : '';
        $themeFolder = $activeThemeObj ? $activeThemeObj->folder : '';
        $currentHost = request()->getHost(); // ambil domain tanpa port

        $destinasiPosts = collect();
        $ekonomiKreatifPosts = collect();
        $kegiatanPosts = collect();
        $beritaPosts = collect();
        $galleryPosts = collect();
        $posts_page = null;

        $isTripinTheme = (strtolower($themeFolder) === 'theme-tripin' || strtolower($tema_aktiv) === 'theme tripin');

        if ($isTripinTheme) {
            // Eager-loaded data collections for theme-tripin sections to prevent N+1 queries in Blade
            $destinasiPosts = Cache::remember('home_destinasi_posts', 3600, function () {
                return Post::with(['destination', 'approvedReviews'])
                    ->leftJoin('post_categorys', 'post_categorys.id', 'posts.post_category_id')
                    ->where('post_categorys.seotitle', 'pariwisata')
                    ->where('posts.active', 'Y')
                    ->select('posts.*')
                    ->orderBy('posts.id', 'desc')
                    ->limit(8)
                    ->get();
            });

            $ekonomiKreatifPosts = Cache::remember('home_ekraft_posts', 3600, function () {
                return Post::leftJoin('post_categorys', 'post_categorys.id', 'posts.post_category_id')
                    ->where('post_categorys.seotitle', 'ekonomi-kreatif')
                    ->where('posts.active', 'Y')
                    ->select('posts.*')
                    ->orderBy('posts.id', 'desc')
                    ->limit(8)
                    ->get();
            });

            $kegiatanPosts = Cache::remember('home_kegiatan_posts', 3600, function () {
                return Post::leftJoin('post_categorys', 'post_categorys.id', 'posts.post_category_id')
                    ->where('post_categorys.seotitle', 'kegiatan')
                    ->where('posts.active', 'Y')
                    ->select('posts.*')
                    ->orderBy('posts.id', 'desc')
                    ->limit(8)
                    ->get();
            });

            $beritaPosts = Cache::remember('home_berita_posts', 3600, function () {
                return Post::leftJoin('users', 'users.id', 'posts.created_by')
                    ->leftJoin('post_categorys', 'post_categorys.id', 'posts.post_category_id')
                    ->where('post_categorys.seotitle', 'berita')
                    ->where('posts.active', 'Y')
                    ->select('posts.*', 'users.name')
                    ->orderBy('posts.id', 'desc')
                    ->limit(8)
                    ->get();
            });

            $galleryPosts = Cache::remember('home_gallery_5', 3600, function () {
                return self::gallery(5);
            });
        } else {
            $posts_page = Post::leftJoin('users', 'users.id', 'posts.created_by')
                ->leftJoin('post_categorys', 'post_categorys.id', 'posts.post_category_id')
                ->where([['posts.active', '=', 'Y']])
                ->select('posts.*', 'post_categorys.title as ctitle', 'users.name')
                ->orderBy('posts.id', 'desc')
                ->paginate(10);

            $posts_page->withPath('post/all');
        }

        // Data dinamis untuk tampilan baru beranda Bappeda
        $latestNews = Cache::remember('home_latest_news_v2', 600, function () {
            return Post::leftJoin('post_categorys', 'post_categorys.id', 'posts.post_category_id')
                ->where('posts.active', 'Y')
                ->select('posts.*', 'post_categorys.title as ctitle', 'post_categorys.seotitle as cseotitle')
                ->orderBy('posts.id', 'desc')
                ->limit(4)
                ->get();
        });

        $latestAgendas = Cache::remember('home_latest_agendas_v2', 600, function () {
            return Agenda::where('active', 'Y')
                ->orderBy('start', 'desc')
                ->limit(4)
                ->get();
        });

        $planningDocuments = Cache::remember('home_planning_documents_v2', 600, function () {
            return Download::leftJoin('download_categorys', 'download_categorys.id', 'downloads.download_category_id')
                ->where('downloads.active', 'Y')
                ->select('downloads.*', 'download_categorys.title as ctitle', 'download_categorys.seotitle as cseotitle')
                ->orderBy('downloads.id', 'desc')
                ->limit(8)
                ->get();
        });

        $latestGalleries = Cache::remember('home_galleries_v2', 600, function () {
            return Gallery::where('active', 'Y')
                ->orderBy('id', 'desc')
                ->limit(3)
                ->get();
        });

        $featuredVideo = Cache::remember('home_featured_video_v2', 600, function () {
            return Video::where('active', 'Y')
                ->orderBy('id', 'desc')
                ->first();
        });

        if ($tema_aktiv == 'Theme Porto' && $currentHost == 'diskominfotik.lampungprov.go.id') {
            return view(getTheme('homedisko'), compact('videos', 'sliders', 'visitor', 'is_home', 'posts_page'));
        }

        return view(getTheme('home'), compact(
            'videos', 'sliders', 'visitor', 'is_home', 'posts_page',
            'destinasiPosts', 'ekonomiKreatifPosts', 'kegiatanPosts', 'beritaPosts', 'galleryPosts',
            'latestNews', 'latestAgendas', 'planningDocuments', 'latestGalleries', 'featuredVideo'
        ));
    }

    public function visitor()
    {

        /*session_start();
        $session_id = session_id();;
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
        */
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


    public static function latestPost($limit, $offset = '0')
    {
        $cacheKey = "latestPost_{$limit}_{$offset}";
        return Cache::remember($cacheKey, 86400, function () use ($limit, $offset) {
            $result = Post::leftJoin('users', 'users.id', 'posts.created_by')
                ->leftJoin('post_categorys', 'post_categorys.id', 'posts.post_category_id')
                ->where([['posts.active', '=', 'Y']])
                ->select('posts.*', 'post_categorys.title as ctitle', 'users.name')
                ->orderBy('posts.id', 'desc')
                ->limit($limit)
                ->offset($offset)
                ->get();
            return $result;
        });
    }

    public static function headlinePost($limit, $offset = '0')
    {
        $cacheKey = "headlinePost_{$limit}_{$offset}";
        return Cache::remember($cacheKey, 86400, function () use ($limit, $offset) {
            $result = Post::leftJoin('users', 'users.id', 'posts.created_by')
                ->leftJoin('post_categorys', 'post_categorys.id', 'posts.post_category_id')
                ->where([['posts.active', '=', 'Y']])
                ->where([['posts.headline', '=', 'Y']])
                ->select('posts.*', 'post_categorys.title as ctitle', 'users.name')
                ->orderBy('posts.id', 'desc')
                ->limit($limit)
                ->offset($offset)
                ->get();
            return $result;
        });
    }

    public static function latestDownload($limit, $offset = '0')
    {
        $result = Download::leftJoin('users', 'users.id', 'downloads.created_by')
            ->leftJoin('download_categorys', 'download_categorys.id', 'downloads.download_category_id')
            ->where([['downloads.active', '=', 'Y']])
            ->select('downloads.*', 'download_categorys.title as ctitle', 'users.name')
            ->orderBy('downloads.id', 'desc')
            ->limit($limit)
            ->offset($offset)
            ->get();
        return $result;
    }

    public static function gallery($limit, $offset = '0')
    {
        $cacheKey = "gallery_{$limit}_{$offset}";
        return Cache::remember($cacheKey, 86400, function () use ($limit, $offset) {
            $result = Gallery::leftJoin('users', 'users.id', 'gallerys.created_by')
                ->leftJoin('albums', 'albums.id', 'gallerys.album_id')
                ->where([['gallerys.active', '=', 'Y']])
                ->select('gallerys.*', 'albums.title as atitle', 'users.name')
                ->orderBy('gallerys.id', 'desc')
                ->limit($limit)
                ->offset($offset)
                ->get();
            return $result;
        });
    }

    public static function agenda($limit, $offset = '0')
    {
        $cacheKey = "agenda_{$limit}_{$offset}";
        return Cache::remember($cacheKey, 86400, function () use ($limit, $offset) {
            $result = Agenda::leftJoin('users', 'users.id', 'agendas.created_by')
                ->where('agendas.active', '=', 'Y')
                ->select('agendas.*', 'users.name')
                ->orderBy('agendas.id', 'desc')
                ->limit($limit)
                ->offset($offset)
                ->get();
            return $result;
        });
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        $contents = Post::leftJoin('users', 'users.id', 'posts.created_by')
            ->leftJoin('post_categorys', 'post_categorys.id', 'posts.post_category_id')
            ->where([['posts.active', '=', 'Y'], ['posts.title', 'LIKE', '%' . $query . '%']])
            ->orWhere([['posts.content', 'LIKE', '%' . $query . '%']])
            ->select('posts.*', 'post_categorys.title as ctitle', 'users.name')
            ->orderBy('posts.id', 'desc')
            ->limit(20)
            ->get();
        $downloads = Download::leftJoin('download_categorys', 'download_categorys.id', '=', 'downloads.download_category_id')
            ->where([['downloads.title', 'LIKE', '%' . $query . '%'], ['downloads.active', '=', 'Y']])
            ->orWhere([['downloads.content', 'LIKE', '%' . $query . '%']])
            ->select('downloads.*', 'download_categorys.id as dcid', 'download_categorys.title as dctitle')
            ->orderBy('downloads.id', 'desc')
            ->limit(20)
            ->get();

        return view(getTheme('search'), compact(
            'contents',
            'downloads',
            'query'
        ));
    }

    public static function video($limit, $offset = '0')
    {
        $cacheKey = "video_{$limit}_{$offset}";
        return Cache::remember($cacheKey, 86400, function () use ($limit, $offset) {
            $result = Video::where([['videos.active', '=', 'Y']])
                ->select('videos.*')
                ->orderBy('videos.id', 'desc')
                ->limit($limit)
                ->offset($offset)
                ->get();
            return $result;
        });
    }

    public static function getPages($id)
    {
        return Cache::remember("home_page_{$id}", 86400, function () use ($id) {
            return Pages::where('id', $id)->first();
        });
    }

    public static function getMenus()
    {
        return Cache::remember("home_menu_tree", 86400, function () {
            $menus = new Menu;
            return $menus->tree();
        });
    }

    public static function addTheme2024()
    {
        $checkTheme2024 = Theme::where('folder', 'theme-2024limitless')->count();
        if ($checkTheme2024 == 0) {
            Theme::create([
                'title' => 'Theme UTI',
                'folder' => 'theme-uti',
                'picture' => 'theme-uti.jpg',
                'active' => 'N',
                'created_by' => '1',
                'updated_by' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Theme::create([
                'title' => 'Theme 2024 Limitless',
                'folder' => 'theme-2024limitless',
                'picture' => 'theme-2024limitless.jpg',
                'active' => 'Y',
                'created_by' => '1',
                'updated_by' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Theme::where('folder', '!=', 'theme-2024limitless')->update(['active' => 'N']);
            return 'theme 2024 berhasil ditambahkan';
        } else {
            return 'theme 2024 sudah ada';
        }

    }

    public static function listCategory($limit)
    {
        $result = PostCategory::limit($limit)
            ->get();
        return $result;
    }

    public function cekVisitor()
    {

        $visitorsAndPageViews = Analytics::fetchVisitorsAndPageViews(Period::days(7));
        $totalVisitorsAndPageViews = Analytics::fetchTotalVisitorsAndPageViews(Period::days(7));
        $mostVisitedPages = Analytics::fetchMostVisitedPages(Period::days(7));
        $topReferrers = Analytics::fetchTopReferrers(Period::days(7));
        $userTypes = Analytics::fetchUserTypes(Period::days(7));
        $topBrowsers = Analytics::fetchTopBrowsers(Period::days(7));
        return view('analytics', compact('visitorsAndPageViews', 'totalVisitorsAndPageViews', 'mostVisitedPages', 'topReferrers', 'userTypes', 'topBrowsers'));
    }

    public static function gallery_pop_up($limit, $offset = '0')
    {
        $hasColumn = Schema::hasColumn('albums', 'is_popup');

        $result = Gallery::leftJoin('users', 'users.id', 'gallerys.created_by')
            ->leftJoin('albums', 'albums.id', 'gallerys.album_id')
            ->where('gallerys.active', '=', 'Y')
            ->where(function ($query) use ($hasColumn) {
                if ($hasColumn) {
                    $query->where('albums.is_popup', '=', 1);
                }

                $query->orWhere('albums.title', 'like', '%pop_up%')
                    ->orWhere('albums.title', 'like', '%popup%')
                    ->orWhere('albums.title', 'like', '%pop up%');
            })
            ->select('gallerys.*', 'albums.title as atitle', 'users.name')
            ->orderBy('gallerys.id', 'desc')
            ->limit($limit)
            ->offset($offset)
            ->get();
        return $result;
    }
}
