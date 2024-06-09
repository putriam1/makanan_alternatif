<?php

use App\Http\Controllers\AhliGiziController;
use App\Http\Controllers\ChefController;
use App\Http\Controllers\KonsulController;
use App\Http\Controllers\MakananAlternativeController;
use App\Http\Controllers\MakananController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\HistoriController;
use App\Http\Controllers\RiwayatPenyakitController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\PenggunaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['middleware' => 'admin'], function () {
    Route::get('/admin', function () {
        return view('dashboard/admin');
    });

    Route::get('/ahli-gizi', [AhliGiziController::class, 'index'])
    ->name('ahli-gizi.index');
    Route::get('/create-ahli-gizi', [AhliGiziController::class, 'create'])
        ->name('ahli-gizi.create');
    Route::post('/store-ahli-gizi', [AhliGiziController::class, 'store'])
        ->name('ahli-gizi.store');

    Route::get('/ubah-status-ahli-gizi/{id}', [AhliGiziController::class, 'ubahStatus'])
        ->name('ahli-gizi.ubah-status-ahli-gizi');

    Route::get('/chef', [ChefController::class, 'index'])
        ->name('chef.index');
    Route::get('/create-chef', [ChefController::class, 'create'])
        ->name('chef.create');
    Route::post('/store-chef', [ChefController::class, 'store'])
        ->name('chef.store');

    Route::get('/ubah-status-chef/{id}', [ChefController::class, 'ubahStatus'])
        ->name('chef.ubah-status-chef');

    Route::get('/pasien', [PasienController::class, 'index'])
        ->name('pasien.index');
    Route::get('/create-pasien', [PasienController::class, 'create'])
        ->name('pasien.create');
    Route::post('/store-pasien', [PasienController::class, 'store'])
        ->name('pasien.store');

    Route::get('/makanan', [MakananController::class, 'index'])
        ->name('makanan.index');
    Route::get('/create-makanan', [MakananController::class, 'create'])
        ->name('makanan.create');
    Route::post('/store-makanan', [MakananController::class, 'store'])
        ->name('makanan.store');

    Route::get('/makanan-alternative', [MakananAlternativeController::class, 'index'])
    ->name('makanan-alternative.index');
    Route::get('/create-makanan-alternative', [MakananAlternativeController::class, 'create'])
        ->name('makanan-alternative.create');
    Route::post('/store-makanan-alternative', [MakananAlternativeController::class, 'store'])
        ->name('makanan-alternative.store');

    Route::get('/riwayat_penyakit', [RiwayatPenyakitController::class, 'index'])
        ->name('riwayat-penyakit.index');
    Route::get('/create-penyakit', [RiwayatPenyakitController::class, 'create'])
        ->name('riwayat-penyakit.create');
    Route::post('/tambah-penyakit', [RiwayatPenyakitController::class, 'store'])
        ->name('riwayat-penyakit.store');
});

Route::group(['middleware' => 'ahligizi'], function () {
    Route::get('/create-konsul', [KonsulController::class, 'create'])
        ->name('konsul.create')->middleware('ahligizi');
    Route::post('/store-konsul', [KonsulController::class, 'store'])
        ->name('konsul.store');

    Route::post('/konsul-cek-makanan-sayur', [KonsulController::class, 'cekMakananSayur'])
        ->name('konsul.cek-makanan-sayur');
    Route::post('/konsul-cek-makanan-lauk', [KonsulController::class, 'cekMakananLauk'])
        ->name('konsul.cek-makanan-lauk');
    Route::post('/konsul-cek-makanan-buah', [KonsulController::class, 'cekMakananBuah'])
        ->name('konsul.cek-makanan-buah');
    Route::post('/konsul-cek-makanan-pokok', [KonsulController::class, 'cekMakananPokok'])
        ->name('konsul.cek-makanan-pokok');
});


Route::get('/konsul', [KonsulController::class, 'index'])
    ->name('konsul.index');

Route::get('/generate-pdf/{id}', [PDFController::class, 'generatePDF'])->name('generate.pdf');

Route::get('/histori', [HistoriController::class, 'index'])
    ->name('histori.index');

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);

Route::get('/pasien/{nomor_pasien}', [PasienController::class, 'getPasien']);
Route::get('/ahli_gizi/{nip}', [AhliGiziController::class, 'getAhliGizi']);

// Route::get('/riwayat-penyakit/{id_pasien}', [RiwayatPenyakitController::class, 'getRiwayatPenyakit']);

