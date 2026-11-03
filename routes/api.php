<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::middleware('throttle:200,1')->get('/berita', [\App\Http\Controllers\API\PostController::class, 'index']);

// ─── API Informasi Sosial ──────────────────────────────────────────
Route::prefix('informasi-sosial')->middleware('throttle:60,1')->group(function () {
    Route::get('/layanan', [\App\Http\Controllers\API\InformasiSosialController::class, 'layananIndex']);
    Route::get('/layanan/{kode}', [\App\Http\Controllers\API\InformasiSosialController::class, 'layananShow']);
    Route::post('/daftar', [\App\Http\Controllers\API\InformasiSosialController::class, 'daftar']);
    Route::post('/status', [\App\Http\Controllers\API\InformasiSosialController::class, 'cekStatus']);
});

Route::prefix('dishub')->middleware('throttle:60,1')->group(function () {
    Route::get('/', [\App\Http\Controllers\API\DishubController::class, 'index']);
    Route::get('/flight-schedules', [\App\Http\Controllers\API\DishubController::class, 'flightSchedules']);
    Route::get('/flight-schedules/{id}', [\App\Http\Controllers\API\DishubController::class, 'flightScheduleShow']);
    Route::get('/terminals', [\App\Http\Controllers\API\DishubController::class, 'terminals']);
    Route::get('/terminals/{id}', [\App\Http\Controllers\API\DishubController::class, 'terminalShow']);
    Route::get('/akdp-routes', [\App\Http\Controllers\API\DishubController::class, 'akdpRoutes']);
    Route::get('/akdp-routes/{id}', [\App\Http\Controllers\API\DishubController::class, 'akdpRouteShow']);
    Route::get('/toll-rates', [\App\Http\Controllers\API\DishubController::class, 'tollRates']);
    Route::get('/toll-rates/{id}', [\App\Http\Controllers\API\DishubController::class, 'tollRateShow']);
    Route::get('/notes', [\App\Http\Controllers\API\DishubController::class, 'notes']);
    Route::get('/notes/{id}', [\App\Http\Controllers\API\DishubController::class, 'noteShow']);
});
