<?php

use App\Models\Setting;
use App\Models\Theme;
use Illuminate\Support\Facades\Storage;
use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Metric;
use Google\Analytics\Data\V1beta\RunReportRequest;

// Tambahkan ini
use Carbon\Carbon;
use Spatie\Analytics\Period;
use Spatie\Analytics\Facades\Analytics;
use Google\Analytics\Data\V1beta\Filter\StringFilter;

use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Filter;
use Google\Analytics\Data\V1beta\FilterExpression;


use Google\Analytics\Data\V1beta\Filter\StringFilter\MatchType;

if (!function_exists('getSetting')) {
    function getSetting($key)
    {
        static $settings = null;
        if ($settings === null) {
            $settings = \Illuminate\Support\Facades\Cache::rememberForever('global_app_settings', function () {
                return \App\Models\Setting::pluck('value', 'key')->toArray();
            });
        }
        return $settings[$key] ?? '';
    }
}
if (!function_exists('getTheme')) {
    function getTheme($files)
    {
        $result = Theme::where('active', 'Y')->first();
        if ($result) {
            return $result->folder . '.' . $files;
        } else {
            $result2 = Theme::where('id', '1')->first();
            return $result2->folder . '.' . $files;
        }
    }
}
if (!function_exists('activeMenu')) {
    function activeMenu($uri = '')
    {
        $active = '';

        if (Request::is($uri . '/*') || Request::is($uri)) {
            $active = 'active';
        }
        return $active;
    }
}

if (!function_exists('str_limit')) {
    function str_limit($text = '', $limit = 50)
    {
        return \Illuminate\Support\Str::limit($text, $limit);
    }
}

if (!function_exists('callassets')) {
    function callassets($fileName)
    {
        if (empty($fileName)) {
            return null;
        }
        return url('call-file/assets/' . $fileName);
    }
}

if (!function_exists('callassetspath')) {
    function callassetspath($fileName)
    {
        if (empty($fileName)) {
            return null;
        }
        return url('assets/' . $fileName);
    }
}

if (!function_exists('callassetsCss')) {
    function callassetsCss($fileName)
    {
        if (empty($fileName)) {
            return null;
        }
        return url('call-css/assets/' . $fileName);
    }
}

if (!function_exists('callassetsJs')) {
    function callassetsJs($fileName)
    {
        if (empty($fileName)) {
            return null;
        }
        return url('call-js/assets/' . $fileName);
    }
}

if (!function_exists('berkas_asset')) {
    function berkas_asset($fileName)
    {
        if (empty($fileName)) {
            return null;
        }

        $cacheKey = 'berkas_path_' . md5($fileName);

        // Jika sudah ada di cache, langsung ambil
        if (\Illuminate\Support\Facades\Cache::has($cacheKey)) {
            return \Illuminate\Support\Facades\Cache::get($cacheKey);
        }

        // Cek apakah path lengkap sudah tersedia
        if (\Illuminate\Support\Str::startsWith($fileName, ['uploads/', '/uploads/'])) {
            $path = ltrim($fileName, '/'); // Buang '/' di depan
            $fullPath = Storage::disk('public')->path($path);
            if (file_exists($fullPath)) {
                $url = url('berkas/' . $path);
                \Illuminate\Support\Facades\Cache::put($cacheKey, $url, now()->addHours(2));
                return $url;
            }
        } else {
            // Coba lokasi-lokasi umum
            $candidates = [
                $fileName,
                'uploads/' . $fileName,
                'uploads/thumbs/' . $fileName,
                'uploads/medium/medium_' . $fileName,
            ];

            foreach ($candidates as $path) {
                $fullPath = Storage::disk('public')->path($path);
                if (file_exists($fullPath)) {
                    $url = url('berkas/' . $path);
                    Cache::put($cacheKey, $url, now()->addHours(2));
                    return $url;
                }
            }
        }

        // Jika tidak ditemukan, tetap cache null agar tidak dicek terus-menerus
        \Illuminate\Support\Facades\Cache::put($cacheKey, null, now()->addMinutes(10));
        return null;
    }
}

if (!function_exists('berkas')) {
    function berkas($fileName)
    {
        if (empty($fileName)) {
            return null;
        }

        if (\Illuminate\Support\Str::startsWith($fileName, ['http://', 'https://'])) {
            return $fileName;
        }

        $clean = ltrim($fileName, '/');

        $candidates = [
            $clean,
            'uploads/' . $clean,
            'public/uploads/' . $clean,
            'uploads/thumbs/' . $clean,
            'uploads/medium/medium_' . $clean,
        ];

        foreach ($candidates as $rel) {
            if (Storage::disk('public')->exists($rel)) {
                return url('berkas/' . $rel);
            }
            if (file_exists(public_path('berkas/' . $rel))) {
                return url('berkas/' . $rel);
            }
        }

        return null;
    }
}
if (!function_exists('berkasLogo')) {
    function berkasLogo($fileName)
    {
        if (empty($fileName)) {
            return null;
        }

        $clean = ltrim($fileName, '/');

        $candidates = [
            public_path('storage/' . $clean),
            public_path('storage/uploads/' . $clean),
            Storage::disk('public')->path($clean),
            Storage::disk('public')->path('uploads/' . $clean),
            Storage::disk('public')->path('public/uploads/' . $clean),
            public_path('berkas/' . $clean),
        ];

        foreach ($candidates as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        return null;
    }
}


if (!function_exists('getImgWidth')) {
    function getImgWidth($filename)
    {
        if (empty($filename) || !file_exists($filename)) {
            return 0;
        }
        $info = @getimagesize($filename);
        return $info ? (int)$info[0] : 0;
    }
}

if (!function_exists('getImageRatio')) {
    function getImageRatio($filename)
    {
        if (empty($filename) || !file_exists($filename)) {
            return 1;
        }
        $info = @getimagesize($filename);
        if ($info && !empty($info[1])) {
            return (float)($info[0] / $info[1]);
        }
        return 1;
    }
}

if (!function_exists('resValidator')) {
    function resValidator($validator)
    {
        $request = Illuminate\Support\Facades\Request::instance();
        $errorString = implode(',', $validator->messages()->all());
        $res['message'] = $errorString;
        $res['success'] = false;

        if ($request->wantsJson()) {
            $res['errors'] = $validator->errors()->toArray();

            return response()->json($res, 422);
        } else {
            return redirect()->back()->withInput()->withErrors($validator)->with($res);
        }
    }
}

if (!function_exists('getVisitorStatsSpatie')) {
    /**
     * Mengambil statistik pengunjung dari Google Analytics dengan satu panggilan API.
     *
     * @return array
     */
    function getVisitorStatsSpatie(): array
    {
        $propertyId = env('G_ANAL_PROPERTY_ID');

        if (!$propertyId) {
            return [
                'today' => 0,
                'yesterday' => 0,
                'thisMonth' => 0,
                'thisYear' => 0,
                'total' => 0,
            ];
        }

        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $startOfYear = Carbon::now()->startOfYear();
        $endOfYear = Carbon::now()->endOfYear();

        $todayVisitors = Analytics::fetchTotalVisitorsAndPageViews(
            Period::create($today, $today)
        )->sum('activeUsers');

        $yesterdayVisitors = Analytics::fetchTotalVisitorsAndPageViews(
            Period::create($yesterday, $yesterday)
        )->sum('activeUsers');

        $thisMonthVisitors = Analytics::fetchTotalVisitorsAndPageViews(
            Period::create($startOfMonth, $endOfMonth)
        )->sum('activeUsers');

        $thisYearVisitors = Analytics::fetchTotalVisitorsAndPageViews(
            Period::create($startOfYear, $endOfYear)
        )->sum('activeUsers');

        $totalVisitors = Analytics::fetchTotalVisitorsAndPageViews(
            Period::years(5)
        )->sum('activeUsers');

        return [
            'today' => $todayVisitors,
            'yesterday' => $yesterdayVisitors,
            'thisMonth' => $thisMonthVisitors,
            'thisYear' => $thisYearVisitors,
            'total' => $totalVisitors,
        ];
    }
}

if (!function_exists('getVisitorStats2')) {
    /**
     * Mengambil statistik pengunjung dari Google Analytics untuk aliran data web.
     *
     * @param string $streamName The name of the data stream to filter by.
     * @return array
     */
    function getVisitorStats2(): array
    {
        $streamName = env('G_STREAM_NAME');
        $propertyId = env('G_ANAL_PROPERTY_ID');

        if (!$propertyId) {
            return [
                'today' => 0,
                'yesterday' => 0,
                'thisMonth' => 0,
                'thisYear' => 0,
                'total' => 0,
            ];
        }

        try {
            // Mengambil data untuk hari ini
            $todayData = Analytics::get(Period::days(1), ['activeUsers'], ['streamName'])
                ->where('streamName', $streamName)
                ->first();
            $todayVisitors = $todayData ? $todayData['activeUsers'] : 0;

            // Mengambil data untuk kemarin
            $yesterdayData = Analytics::get(Period::create(Carbon::yesterday(), Carbon::yesterday()), ['activeUsers'], ['streamName'])
                ->where('streamName', $streamName)
                ->first();
            $yesterdayVisitors = $yesterdayData ? $yesterdayData['activeUsers'] : 0;

            // Mengambil data untuk bulan ini
            $thisMonthData = Analytics::get(Period::create(Carbon::now()->startOfMonth(), Carbon::now()), ['activeUsers'], ['streamName'])
                ->where('streamName', $streamName)
                ->first();
            $thisMonthVisitors = $thisMonthData ? $thisMonthData['activeUsers'] : 0;

            // Mengambil data untuk tahun ini
            $thisYearData = Analytics::get(Period::create(Carbon::now()->startOfYear(), Carbon::now()), ['activeUsers'], ['streamName'])
                ->where('streamName', $streamName)
                ->first();
            $thisYearVisitors = $thisYearData ? $thisYearData['activeUsers'] : 0;

            // Mengambil data total
            $totalData = Analytics::get(Period::create(Carbon::create(2020, 1, 1), Carbon::now()), ['activeUsers'], ['streamName'])
                ->where('streamName', $streamName)
                ->first();
            $totalVisitors = $totalData ? $totalData['activeUsers'] : 0;

            return [
                'today' => $todayVisitors,
                'yesterday' => $yesterdayVisitors,
                'thisMonth' => $thisMonthVisitors,
                'thisYear' => $thisYearVisitors,
                'total' => $totalVisitors,
            ];
        } catch (\Exception $e) {
            // Tangani error API
            return [
                'today' => 0,
                'yesterday' => 0,
                'thisMonth' => 0,
                'thisYear' => 0,
                'total' => 0,
            ];
        }
    }
}

if (!function_exists('getVisitorStatsGoogle')) {
    function getVisitorStatsGoogle()
    {
        // Ganti dengan path ke file kredensial JSON Anda
        $credentialsPath = storage_path('app/analytics/masterweb-pemprov-lampung-2154c27fc432.json');

        // Ganti dengan Property ID GA4 Anda
        $propertyId = env('G_ANAL_MEASUREMENT_ID');

        if (!$propertyId) {
            return [
                'today' => 0,
                'yesterday' => 0,
                'thisMonth' => 0,
                'thisYear' => 0,
                'total' => 0,
            ];
        }

        $client = new BetaAnalyticsDataClient(['credentials' => $credentialsPath]);

        try {
            // Mengambil statistik untuk "Hari Ini"
            $todayResponse = $client->runReport(new RunReportRequest([
                'property' => "properties/$propertyId",
                'dateRanges' => [new DateRange(['startDate' => 'today', 'endDate' => 'today'])],
                'metrics' => [new Metric(['name' => 'activeUsers'])],
            ]));
            $todayVisitors = $todayResponse->getRows()->count() > 0 ? $todayResponse->getRows()[0]->getMetricValues()[0]->getValue() : 0;

            // Mengambil statistik untuk "Kemarin"
            $yesterdayResponse = $client->runReport(new RunReportRequest([
                'property' => "properties/$propertyId",
                'dateRanges' => [new DateRange(['startDate' => 'yesterday', 'endDate' => 'yesterday'])],
                'metrics' => [new Metric(['name' => 'activeUsers'])],
            ]));
            $yesterdayVisitors = $yesterdayResponse->getRows()->count() > 0 ? $yesterdayResponse->getRows()[0]->getMetricValues()[0]->getValue() : 0;

            // Mengambil statistik untuk "Bulan Ini"
            $thisMonthResponse = $client->runReport(new RunReportRequest([
                'property' => "properties/$propertyId",
                'dateRanges' => [new DateRange(['startDate' => '30daysAgo', 'endDate' => 'today'])],
                'metrics' => [new Metric(['name' => 'activeUsers'])],
            ]));
            $monthVisitors = $thisMonthResponse->getRows()->count() > 0 ? $thisMonthResponse->getRows()[0]->getMetricValues()[0]->getValue() : 0;

            // Mengambil statistik untuk "Tahun Ini"
            $thisYearResponse = $client->runReport(new RunReportRequest([
                'property' => "properties/$propertyId",
                'dateRanges' => [new DateRange(['startDate' => '365daysAgo', 'endDate' => 'today'])],
                'metrics' => [new Metric(['name' => 'activeUsers'])],
            ]));
            $yearVisitors = $thisYearResponse->getRows()->count() > 0 ? $thisYearResponse->getRows()[0]->getMetricValues()[0]->getValue() : 0;

            // Mengambil statistik "Total" dari awal
            $totalResponse = $client->runReport(new RunReportRequest([
                'property' => "properties/$propertyId",
                'dateRanges' => [new DateRange(['startDate' => '2005-01-01', 'endDate' => 'today'])],
                'metrics' => [new Metric(['name' => 'activeUsers'])],
            ]));
            $totalVisitors = $totalResponse->getRows()->count() > 0 ? $totalResponse->getRows()[0]->getMetricValues()[0]->getValue() : 0;

            $visitorStats = [
                'today' => $todayVisitors,
                'yesterday' => $yesterdayVisitors,
                'thisMonth' => $monthVisitors,
                'thisYear' => $yearVisitors,
                'total' => $totalVisitors,
            ];
            return $visitorStats;


        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal mengambil data dari Google Analytics: ' . $e->getMessage());
            return [
                'today' => 0,
                'yesterday' => 0,
                'thisMonth' => 0,
                'thisYear' => 0,
                'total' => 0,
            ];
        }
    }

    if (!function_exists('getVisitorStats')) {


        function getVisitorStats(): array
        {
            $streamName = env('G_STREAM_NAME');
            $cacheKey = 'visitor_stats_' . \Illuminate\Support\Str::slug($streamName); // contoh: 'visitor_stats_situs-web-rsj'

            return \Illuminate\Support\Facades\Cache::remember($cacheKey, now()->addMinutes(30), function () use ($streamName) {

                $rawPropertyId = env('G_ANAL_PROPERTY_ID'); // hanya angka, misal: '123456789'
                $propertyId = $rawPropertyId ? 'properties/' . $rawPropertyId : null; // format: 'properties/123456789'
                $credentialsPath = storage_path('app/analytics/masterweb-pemprov-lampung-2154c27fc432.json');

                if (!$rawPropertyId || !$propertyId || !file_exists($credentialsPath)) {
                    return [
                        'today' => 0,
                        'yesterday' => 0,
                        'thisMonth' => 0,
                        'thisYear' => 0,
                        'total' => 0,
                    ];
                }

                $client = new BetaAnalyticsDataClient([
                    'credentials' => $credentialsPath,
                ]);

                // Fungsi internal untuk ambil total visitor non-unique per hari dalam rentang waktu
                $getTotalVisitors = function ($startDate, $endDate) use ($client, $propertyId, $streamName) {
                    $request = new RunReportRequest([
                        'property' => $propertyId,
                        'date_ranges' => [
                            new DateRange([
                                'start_date' => $startDate,
                                'end_date' => $endDate,
                            ]),
                        ],
                        'metrics' => [
                            new Metric(['name' => 'activeUsers']),
                        ],
                        'dimensions' => [
                            new Dimension(['name' => 'date']),
                            new Dimension(['name' => 'streamName']),
                        ],
                        'dimension_filter' => new FilterExpression([
                            'filter' => new Filter([
                                'field_name' => 'streamName',
                                'string_filter' => new StringFilter([
                                    'value' => $streamName,
                                    'match_type' => MatchType::EXACT,
                                ]),
                            ]),
                        ]),
                    ]);

                    $response = $client->runReport($request);

                    $total = 0;
                    foreach ($response->getRows() as $row) {
                        $activeUsers = (int)$row->getMetricValues()[0]->getValue();
                        $total += $activeUsers;
                    }

                    return $total;
                };

                // Waktu
                $today = Carbon::today()->toDateString();
                $yesterday = Carbon::yesterday()->toDateString();
                $startMonth = Carbon::now()->startOfMonth()->toDateString();
                $startYear = Carbon::now()->startOfYear()->toDateString();
                $now = Carbon::now()->toDateString();
                $fiveYearsAgo = Carbon::now()->subYears(5)->toDateString();

                return [
                    'today' => $getTotalVisitors($today, $today),
                    'yesterday' => $getTotalVisitors($yesterday, $yesterday),
                    'thisMonth' => $getTotalVisitors($startMonth, $now),
                    'thisYear' => $getTotalVisitors($startYear, $now),
                    'total' => $getTotalVisitors($fiveYearsAgo, $now),
                ];
            });
        }

        function getVisitorStatsByStreamNameBAK(): array
        {
            $streamName = env('G_STREAM_NAME');
            $rawPropertyId = env('G_ANAL_PROPERTY_ID'); // hanya angka, misal: '123456789'
            $propertyId = $rawPropertyId ? 'properties/' . $rawPropertyId : null; // format: 'properties/123456789'
            $credentialsPath = storage_path('app/analytics/masterweb-pemprov-lampung-2154c27fc432.json');

            if (!$rawPropertyId || !$propertyId || !file_exists($credentialsPath)) {
                return [
                    'today' => 0,
                    'yesterday' => 0,
                    'thisMonth' => 0,
                    'thisYear' => 0,
                    'total' => 0,
                ];
            }

            $client = new BetaAnalyticsDataClient([
                'credentials' => $credentialsPath,
            ]);

            $getActiveUsers = function ($startDate, $endDate) use ($client, $propertyId, $streamName) {
                $request = new RunReportRequest([
                    'property' => $propertyId,
                    'date_ranges' => [
                        new DateRange([
                            'start_date' => $startDate,
                            'end_date' => $endDate,
                        ]),
                    ],
                    'metrics' => [
                        new Metric(['name' => 'activeUsers']),
                    ],
                    'dimensions' => [
                        new Dimension(['name' => 'streamName']),
                    ],
                    'dimension_filter' => new FilterExpression([
                        'filter' => new Filter([
                            'field_name' => 'streamName',
                            'string_filter' => new StringFilter([
                                'value' => $streamName,
                                'match_type' => MatchType::EXACT,
                            ]),
                        ]),
                    ]),
                ]);

                $response = $client->runReport($request);
                $rows = $response->getRows();

                return count($rows) ? (int)$rows[0]->getMetricValues()[0]->getValue() : 0;
            };

            $today = Carbon::today()->toDateString();
            $yesterday = Carbon::yesterday()->toDateString();
            $startMonth = Carbon::now()->startOfMonth()->toDateString();
            $startYear = Carbon::now()->startOfYear()->toDateString();
            $now = Carbon::now()->toDateString();
            $fiveYearsAgo = Carbon::now()->subYears(5)->toDateString();

            return [
                'today' => $getActiveUsers($today, $today),
                'yesterday' => $getActiveUsers($yesterday, $yesterday),
                'thisMonth' => $getActiveUsers($startMonth, $now),
                'thisYear' => $getActiveUsers($startYear, $now),
                'total' => $getActiveUsers($fiveYearsAgo, $now),
            ];
        }
    }
}

if (!function_exists('webp_asset')) {
    /**
     * Mengembalikan versi WebP dari asset jika tersedia, fallback ke berkas_asset biasa
     */
    function webp_asset($path)
    {
        if (empty($path)) {
            return asset('assets/images/placeholder.webp');
        }

        $originalUrl = berkas_asset($path);
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png'])) {
            $webpRelativePath = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $path);
            $publicWebpPath = public_path('storage/' . $webpRelativePath);

            if (file_exists($publicWebpPath)) {
                return url('storage/' . $webpRelativePath);
            }
        }

        return $originalUrl;
    }
}

if (!function_exists('menuUrl')) {
    /**
     * Resolves menu URL to clean relative or external link
     */
    function menuUrl($url)
    {
        $url = trim((string)$url);
        if (empty($url) || $url === '#' || $url === 'javascript:void(0)') {
            return 'javascript:void(0)';
        }

        // Strip production domain to keep browsing on current host
        if (preg_match('#^https?://(?:www\.)?bappeda\.lampungprov\.go\.id/(.*)$#i', $url, $matches)) {
            $url = $matches[1];
        }

        // Map legacy .html URLs to modern routes
        if ($url === 'hal-informasi-pelayanan-publik.html') {
            return url('pages/informasi-pelayanan-publik');
        }
        if (str_starts_with($url, 'kategoridownload-')) {
            return url('download/all');
        }
        if (str_starts_with($url, 'kategori-')) {
            return url('post/all');
        }
        if (in_array($url, ['konsultasi.html', 'semua-konsul.html'])) {
            return url('contact');
        }

        // External URLs
        if (preg_match('#^https?://#i', $url)) {
            return $url;
        }

        return url(ltrim($url, '/'));
    }
}

if (!function_exists('isExternalUrl')) {
    /**
     * Checks if URL points to an external host
     */
    function isExternalUrl($url)
    {
        $url = trim((string)$url);
        if (empty($url) || $url === '#' || $url === 'javascript:void(0)') {
            return false;
        }
        if (preg_match('#^https?://(?:www\.)?bappeda\.lampungprov\.go\.id#i', $url)) {
            return false;
        }
        return (bool) preg_match('#^https?://#i', $url);
    }
}


