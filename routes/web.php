<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/get-visitor', [\App\Http\Controllers\HomeController::class, 'cekVisitor']);
Route::get('/add-theme-2024', [\App\Http\Controllers\HomeController::class, 'addTheme2024']);
Route::get('/berkas/{slashData?}', [\App\Http\Controllers\FileController::class, 'index'])->where('slashData', '(.*)');
Route::get('/call-file/{slashData?}', [\App\Http\Controllers\FileController::class, 'callFile'])->where('slashData', '(.*)');
Route::get('/call-css/{slashData?}', [\App\Http\Controllers\FileController::class, 'callcssFile'])->where('slashData', '(.*)');
Route::get('/call-js/{slashData?}', [\App\Http\Controllers\FileController::class, 'calljsFile'])->where('slashData', '(.*)');
// Route::get('api_event','EventController@api_event');
Route::middleware(['log.visitor'])->group(function () {
    Route::get('/', 'HomeController@index');
    Route::get('home', 'HomeController@index')->name('home');
    Route::get('info-dishub', 'DishubController@index')->middleware('dishub.access')->name('dishub.index');
    Route::get('pages/{seotitle}', 'PagesController@detail');
    Route::get('post/{seotitle}', 'PostController@index');
    Route::get('detail-post/{seotitle}', 'PostController@detail');
    Route::post('destinations/{post_id}/review', 'PostController@storeReview')->name('post.review.store');
    Route::get('agenda/all', 'AgendaController@index');
    Route::get('detail-agenda/{seotitle}', 'AgendaController@detail');
    Route::get('download/{seotitle}', 'DownloadController@index');
    Route::get('album/all', 'GalleryController@index');
    Route::get('detail-gallery/{seotitle}', 'GalleryController@detail');
    Route::get('video/all', 'VideoController@index');
    Route::get('pegawai/all', 'PegawaiController@index');
    // Route::get('event', 'EventController@index');
    // Route::get('detail-event/{event_seo}', 'EventController@detail');
    // Route::get('event/search','EventController@search');
    // ─── Informasi Sosial ────────────────────────────────────────────
    Route::get('informasi-sosial', 'InformasiSosialController@index')->name('informasi-sosial.index');
    Route::get('informasi-sosial/layanan/{kode}', 'InformasiSosialController@detail')->name('informasi-sosial.detail');
    Route::get('informasi-sosial/daftar', 'InformasiSosialController@formDaftar')->name('informasi-sosial.daftar');
    Route::get('informasi-sosial/cek-status', 'InformasiSosialController@cekStatus')->name('informasi-sosial.cek-status');
    // ─────────────────────────────────────────────────────────────────

    // ─── Permohonan Informasi Publik (PPID) ─────────────────────────
    Route::get('permohonan-informasi', [\App\Http\Controllers\PermohonanInformasiController::class, 'index'])->name('permohonan-informasi.index');
    Route::get('permohonan-informasi/tracking', [\App\Http\Controllers\PermohonanInformasiController::class, 'tracking'])->name('permohonan-informasi.tracking');
    Route::post('permohonan-informasi/submit', [\App\Http\Controllers\PermohonanInformasiController::class, 'submit'])->name('permohonan-informasi.submit');
    Route::get('permohonan-informasi/sukses/{tiket}', [\App\Http\Controllers\PermohonanInformasiController::class, 'sukses'])->name('permohonan-informasi.sukses');
    Route::get('permohonan-informasi/jawaban/{tiket}', [\App\Http\Controllers\PermohonanInformasiController::class, 'downloadJawaban'])->name('permohonan-informasi.download-jawaban');
    // ─────────────────────────────────────────────────────────────────

    // ─── Legacy URLs Redirects (from previous CMS version) ───────────
    Route::get('hal-informasi-pelayanan-publik.html', function () {
        return redirect('pages/informasi-pelayanan-publik', 301);
    });
    Route::get('kategoridownload-{slug}.html', function () {
        return redirect('download/all', 301);
    });
    Route::get('kategori-{slug}.html', function () {
        return redirect('post/all', 301);
    });
    Route::get('berita-{slug}.html', function () {
        return redirect('post/all', 301);
    });
    Route::get('konsultasi.html', function () {
        return redirect('contact', 301);
    });
    Route::get('semua-konsul.html', function () {
        return redirect('contact', 301);
    });
    Route::get('grafik_vaksinasi.html', function () {
        return redirect('/', 301);
    });
    // ─────────────────────────────────────────────────────────────────
});
Route::get('home/search', 'HomeController@search');
Route::get('search', 'HomeController@search');
//Route::get('home/visitor', 'HomeController@visitor');
Route::get('post/search','PostController@search');
Route::get('contact', 'ContactController@index');
Route::post('contact/submit', 'Backend\\ContactController@submit');
Route::get('/reload-captcha','ContactController@reloadCaptcha');


// api wisata (WisataController not present)
// Route::get('wisata/api/data','Backend\\WisataController@apiGetWisata');

// Informasi Sosial - POST submit (outside log.visitor group to avoid issues)
Route::post('informasi-sosial/submit', 'InformasiSosialController@submitDaftar')->name('informasi-sosial.submit');
Route::get('informasi-sosial/sukses', 'InformasiSosialController@sukses')->name('informasi-sosial.sukses');

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@authenticate');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', function () {
    return abort(404);
});
// Route::get('user/activation/{token}', 'Auth\RegisterController@userActivation');

Route::group(['middleware' => 'auth'], function () {
	Route::get('dashboard', 'Backend\BackendController@index');
    Route::get('dashboard/analytics/data', 'Backend\BackendController@getAnalyticsData')->name('analytics.data');
	Route::post('dashboard/upload-editor', 'FileController@uploadEditor');

	Route::get('dashboard/roles/index','Backend\\RolesController@getIndex');
	Route::get('dashboard/roles/table','Backend\\RolesController@getIndex');
	Route::get('dashboard/roles/data','Backend\\RolesController@anyData');
	Route::post('dashboard/roles/deleteall', 'Backend\\RolesController@deleteAll');
	Route::resource('dashboard/roles', 'Backend\RolesController');

	Route::get('dashboard/permissions/index','Backend\\PermissionsController@getIndex');
	Route::get('dashboard/permissions/table','Backend\\PermissionsController@getIndex');
	Route::get('dashboard/permissions/data','Backend\\PermissionsController@anyData');
	Route::post('dashboard/permissions/deleteall', 'Backend\\PermissionsController@deleteAll');
	Route::resource('dashboard/permissions', 'Backend\PermissionsController');

	Route::get('dashboard/users/index','Backend\\UsersController@getIndex');
	Route::get('dashboard/users/table','Backend\\UsersController@getIndex');
	Route::get('dashboard/users/data','Backend\\UsersController@anyData');
	Route::post('dashboard/users/deleteall', 'Backend\\UsersController@deleteAll');
	Route::resource('dashboard/users', 'Backend\UsersController');

	Route::get('dashboard/activitylogs/index','Backend\\ActivityLogsController@getIndex');
	Route::get('dashboard/activitylogs/table','Backend\\ActivityLogsController@getIndex');
	Route::get('dashboard/activitylogs/data','Backend\\ActivityLogsController@anyData');
	Route::post('dashboard/activitylogs/deleteall', 'Backend\\ActivityLogsController@deleteAll');
	Route::resource('dashboard/activitylogs', 'Backend\ActivityLogsController')->only(['index', 'show', 'destroy']);

	Route::get('dashboard/settings/index','Backend\\SettingsController@getIndex');
	Route::get('dashboard/settings/table','Backend\\SettingsController@getIndex');
	Route::get('dashboard/settings/data','Backend\\SettingsController@anyData');
	Route::post('dashboard/settings/deleteall', 'Backend\\SettingsController@deleteAll');
	Route::resource('dashboard/settings', 'Backend\SettingsController');

	// Route::get('dashboard/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@getGenerator']);
	// Route::post('dashboard/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@postGenerator']);

	Route::get('dashboard/pages/index','Backend\\PagesController@getIndex');
	Route::get('dashboard/pages/table','Backend\\PagesController@getIndex');
	Route::get('dashboard/pages/data','Backend\\PagesController@anyData');
	Route::post('dashboard/pages/deleteall', 'Backend\\PagesController@deleteAll');
	Route::resource('dashboard/pages', 'Backend\PagesController');

	Route::get('dashboard/post/index','Backend\\PostController@getIndex');
	Route::get('dashboard/post/table','Backend\\PostController@getIndex');
	Route::get('dashboard/post/data','Backend\\PostController@anyData');
	Route::post('dashboard/post/deleteall', 'Backend\\PostController@deleteAll');
	Route::resource('dashboard/post', 'Backend\PostController');

	Route::get('dashboard/post-category/index','Backend\\PostCategoryController@getIndex');
	Route::get('dashboard/post-category/table','Backend\\PostCategoryController@getIndex');
	Route::get('dashboard/post-category/data','Backend\\PostCategoryController@anyData');
	Route::post('dashboard/post-category/deleteall', 'Backend\\PostCategoryController@deleteAll');
	Route::resource('dashboard/post-category', 'Backend\PostCategoryController');

	Route::get('dashboard/agenda/index','Backend\\AgendaController@getIndex');
	Route::get('dashboard/agenda/table','Backend\\AgendaController@getIndex');
	Route::get('dashboard/agenda/data','Backend\\AgendaController@anyData');
	Route::post('dashboard/agenda/deleteall', 'Backend\\AgendaController@deleteAll');
	Route::resource('dashboard/agenda', 'Backend\AgendaController');

	Route::get('dashboard/download/index','Backend\\DownloadController@getIndex');
	Route::get('dashboard/download/table','Backend\\DownloadController@getIndex');
	Route::get('dashboard/download/data','Backend\\DownloadController@anyData');
	Route::post('dashboard/download/deleteall', 'Backend\\DownloadController@deleteAll');
	Route::resource('dashboard/download', 'Backend\DownloadController');

	Route::get('dashboard/download-category/index','Backend\\DownloadCategoryController@getIndex');
	Route::get('dashboard/download-category/table','Backend\\DownloadCategoryController@getIndex');
	Route::get('dashboard/download-category/data','Backend\\DownloadCategoryController@anyData');
	Route::post('dashboard/download-category/deleteall', 'Backend\\DownloadCategoryController@deleteAll');
	Route::resource('dashboard/download-category', 'Backend\DownloadCategoryController');

	Route::get('dashboard/gallery/index','Backend\\GalleryController@getIndex');
	Route::get('dashboard/gallery/table','Backend\\GalleryController@getIndex');
	Route::get('dashboard/gallery/data','Backend\\GalleryController@anyData');
	Route::post('dashboard/gallery/deleteall', 'Backend\\GalleryController@deleteAll');
	Route::resource('dashboard/gallery', 'Backend\GalleryController');

	Route::get('dashboard/album/index','Backend\\AlbumController@getIndex');
	Route::get('dashboard/album/table','Backend\\AlbumController@getIndex');
	Route::get('dashboard/album/data','Backend\\AlbumController@anyData');
	Route::post('dashboard/album/deleteall', 'Backend\\AlbumController@deleteAll');
	Route::resource('dashboard/album', 'Backend\AlbumController');

	Route::get('dashboard/video/index','Backend\\VideoController@getIndex');
	Route::get('dashboard/video/table','Backend\\VideoController@getIndex');
	Route::get('dashboard/video/data','Backend\\VideoController@anyData');
	Route::post('dashboard/video/deleteall', 'Backend\\VideoController@deleteAll');
	Route::resource('dashboard/video', 'Backend\VideoController');

	Route::get('dashboard/menu/table','Backend\\MenuController@index');
	Route::get('dashboard/menu/menusort','Backend\\MenuController@menusort');
	Route::post('dashboard/menu/menusort', 'Backend\\MenuController@menusort');
	Route::resource('dashboard/menu', 'Backend\MenuController');

	Route::get('dashboard/theme/index','Backend\\ThemeController@getIndex');
	Route::get('dashboard/theme/table','Backend\\ThemeController@getIndex');
	Route::get('dashboard/theme/data','Backend\\ThemeController@anyData');
	Route::post('dashboard/theme/deleteall', 'Backend\\ThemeController@deleteAll');
	Route::post('dashboard/theme/active', 'Backend\\ThemeController@active');
	Route::resource('dashboard/theme', 'Backend\ThemeController');

	Route::get('dashboard/contact/index','Backend\\ContactController@getIndex');
	Route::get('dashboard/contact/table','Backend\\ContactController@getIndex');
	Route::get('dashboard/contact/data','Backend\\ContactController@anyData');
	Route::get('dashboard/contact/reply/{id}','Backend\ContactController@reply');
	Route::post('dashboard/contact/actreply/{id}','Backend\ContactController@actreply');
	Route::post('dashboard/contact/deleteall', 'Backend\\ContactController@deleteAll');
	Route::resource('dashboard/contact', 'Backend\ContactController');

	Route::get('dashboard/slider/index','Backend\\SliderController@getIndex');
	Route::get('dashboard/slider/table','Backend\\SliderController@getIndex');
	Route::get('dashboard/slider/data','Backend\\SliderController@anyData');
	Route::post('dashboard/slider/deleteall', 'Backend\\SliderController@deleteAll');
	Route::resource('dashboard/slider', 'Backend\SliderController');

	Route::get('dashboard/pegawai/index','Backend\PegawaiController@getIndex');
	Route::get('dashboard/pegawai/table','Backend\PegawaiController@getIndex');
	Route::get('dashboard/pegawai/data','Backend\PegawaiController@anyData');
	Route::post('dashboard/pegawai/deleteall','Backend\PegawaiController@deleteAll');
	Route::resource('dashboard/pegawai','Backend\PegawaiController');

	// FERI - Legacy Event module disabled (Controller not in codebase)
    // Route::get('dashboard/event/index','Backend\\EventController@getIndex');
    // Route::get('dashboard/event/table','Backend\\EventController@getIndex');
    // Route::get('dashboard/event/data','Backend\\EventController@anyData');
    // Route::post('dashboard/event/deleteall', 'Backend\\EventController@deleteAll');
    // Route::resource('dashboard/event', 'Backend\EventController');
    // Route::get('dashboard/event/dataGallery/{event_kode}','Backend\\EventController@galleryData');
    // Route::delete('dashboard/event/delgallery/{id_galeri}','Backend\\EventController@destroy_gallery');
    // Route::post('dashboard/event/deleteallgallery/','Backend\\EventController@deleteallgallery');
    // Route::post('dashboard/event/store_image','Backend\\EventController@store_image');

    // Pendaftar Layanan Sosial
    Route::get('dashboard/pendaftar-sosial/index','Backend\\PendaftarSosialController@getIndex');
    Route::get('dashboard/pendaftar-sosial/table','Backend\\PendaftarSosialController@getIndex');
    Route::get('dashboard/pendaftar-sosial/data','Backend\\PendaftarSosialController@anyData');
    Route::post('dashboard/pendaftar-sosial/deleteall', 'Backend\\PendaftarSosialController@deleteAll');
    Route::resource('dashboard/pendaftar-sosial', 'Backend\PendaftarSosialController');

    // portalweb wisata glory - disabled (Controller not in codebase)
    // Route::get('dashboard/wisata/index','Backend\\WisataController@getIndex');
    // Route::get('dashboard/wisata/table','Backend\\WisataController@getIndex');
    // Route::get('dashboard/wisata/data','Backend\\WisataController@anyData');
    // Route::resource('dashboard/wisata', 'Backend\WisataController');

    // Destinations CRUD (Posts wrapped with Destination Data)
	Route::get('dashboard/post-destination/index','Backend\\PostDestinationController@getIndex');
	Route::get('dashboard/post-destination/table','Backend\\PostDestinationController@getIndex');
	Route::get('dashboard/post-destination/data','Backend\\PostDestinationController@anyData');
	Route::resource('dashboard/post-destination', 'Backend\PostDestinationController');

    // Post Reviews CRUD
	Route::get('dashboard/post-review/index','Backend\\PostReviewController@getIndex');
	Route::get('dashboard/post-review/table','Backend\\PostReviewController@getIndex');
	Route::get('dashboard/post-review/data','Backend\\PostReviewController@anyData');
	Route::post('dashboard/post-review/deleteall', 'Backend\\PostReviewController@deleteAll');
	Route::resource('dashboard/post-review', 'Backend\PostReviewController');

    // Accommodation CRUD
	Route::get('dashboard/post-accommodation/index','Backend\\PostAccommodationController@getIndex');
	Route::get('dashboard/post-accommodation/table','Backend\\PostAccommodationController@getIndex');
	Route::get('dashboard/post-accommodation/data','Backend\\PostAccommodationController@anyData');
	Route::resource('dashboard/post-accommodation', 'Backend\PostAccommodationController');

    // Culinary CRUD
	Route::get('dashboard/post-culinary/index','Backend\\PostCulinaryController@getIndex');
	Route::get('dashboard/post-culinary/table','Backend\\PostCulinaryController@getIndex');
	Route::get('dashboard/post-culinary/data','Backend\\PostCulinaryController@anyData');
	Route::resource('dashboard/post-culinary', 'Backend\PostCulinaryController');

    // Transport CRUD
    Route::get('dashboard/post-transport/index','Backend\\PostTransportController@getIndex');
	Route::get('dashboard/post-transport/table','Backend\\PostTransportController@getIndex');
	Route::get('dashboard/post-transport/data','Backend\\PostTransportController@anyData');
	Route::resource('dashboard/post-transport', 'Backend\PostTransportController');

    // Permohonan Informasi (PPID) Backend
    Route::get('dashboard/permohonan-informasi/index', [\App\Http\Controllers\Backend\PermohonanInformasiController::class, 'index']);
    Route::get('dashboard/permohonan-informasi/table', [\App\Http\Controllers\Backend\PermohonanInformasiController::class, 'index'])->name('dashboard.permohonan-informasi.index');
    Route::get('dashboard/permohonan-informasi/data', [\App\Http\Controllers\Backend\PermohonanInformasiController::class, 'anyData'])->name('dashboard.permohonan-informasi.anydata');
    Route::get('dashboard/permohonan-informasi/{id}', [\App\Http\Controllers\Backend\PermohonanInformasiController::class, 'show'])->name('dashboard.permohonan-informasi.show');
    Route::post('dashboard/permohonan-informasi/{id}/update-status', [\App\Http\Controllers\Backend\PermohonanInformasiController::class, 'updateStatus'])->name('dashboard.permohonan-informasi.update-status');
    Route::get('dashboard/permohonan-informasi/{id}/send-email', [\App\Http\Controllers\Backend\PermohonanInformasiController::class, 'sendEmail'])->name('dashboard.permohonan-informasi.send-email');
    Route::delete('dashboard/permohonan-informasi/{id}', [\App\Http\Controllers\Backend\PermohonanInformasiController::class, 'destroy'])->name('dashboard.permohonan-informasi.destroy');
    Route::post('dashboard/permohonan-informasi/deleteall', [\App\Http\Controllers\Backend\PermohonanInformasiController::class, 'deleteAll'])->name('dashboard.permohonan-informasi.delete-all');

    Route::middleware('dishub.access')->group(function () {
        Route::get('dashboard/dishub/{module}/index', 'Backend\\DishubDataController@index');
        Route::get('dashboard/dishub/{module}/table', 'Backend\\DishubDataController@index');
        Route::get('dashboard/dishub/{module}/data', 'Backend\\DishubDataController@anyData');
        Route::get('dashboard/dishub/{module}/create', 'Backend\\DishubDataController@create');
        Route::post('dashboard/dishub/{module}', 'Backend\\DishubDataController@store');
        Route::get('dashboard/dishub/{module}/{id}', 'Backend\\DishubDataController@show');
        Route::get('dashboard/dishub/{module}/{id}/edit', 'Backend\\DishubDataController@edit');
        Route::patch('dashboard/dishub/{module}/{id}', 'Backend\\DishubDataController@update');
        Route::delete('dashboard/dishub/{module}/{id}', 'Backend\\DishubDataController@destroy');
        Route::post('dashboard/dishub/{module}/deleteall', 'Backend\\DishubDataController@deleteAll');
    });
});
