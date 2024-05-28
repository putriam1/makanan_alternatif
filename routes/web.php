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
use Illuminate\Support\Facades\Route;

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

Route::get('/login', function () {
    return view('auth/login');
});

Route::get('/generate-pdf/{id}', [PDFController::class, 'generatePDF'])->name('generate.pdf');

Route::get('/histori', [HistoriController::class, 'index'])
    ->name('histori.index');

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

Route::get('/lihatkonsul', function () {
    return view('admin/lihatkonsultasi');
});

Route::get('/admin', function () {
    return view('dashboard/admin');
});

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

Route::get('/konsul', [KonsulController::class, 'index'])
    ->name('konsul.index');
Route::get('/create-konsul', [KonsulController::class, 'create'])
    ->name('konsul.create');
Route::post('/store-konsul', [KonsulController::class, 'store'])
    ->name('konsul.store');

Route::get('/makanan-alternative', [MakananAlternativeController::class, 'index'])
    ->name('makanan-alternative.index');
Route::get('/create-makanan-alternative', [MakananAlternativeController::class, 'create'])
    ->name('makanan-alternative.create');
Route::post('/store-makanan-alternative', [MakananAlternativeController::class, 'store'])
    ->name('makanan-alternative.store');

Route::post('/cek-protein', [KonsulController::class, 'cekProteinSayur'])
    ->name('konsul.cek-protein');
Route::post('/cek-karbohidrat', [KonsulController::class, 'cekKarbohidratSayur'])
    ->name('konsul.cek-karbohidrat');
Route::post('/cek-lemak', [KonsulController::class, 'cekLemakSayur'])
    ->name('konsul.cek-lemak');

Route::post('/cek-protein-lauk', [KonsulController::class, 'cekProteinLauk'])
    ->name('konsul.cek-protein-lauk');
Route::post('/cek-karbohidrat-lauk', [KonsulController::class, 'cekKarbohidratLauk'])
    ->name('konsul.cek-karbohidrat-lauk');
Route::post('/cek-lemak-lauk', [KonsulController::class, 'cekLemakLauk'])
    ->name('konsul.cek-lemak-lauk');

Route::post('/cek-protein-buah', [KonsulController::class, 'cekProteinBuah'])
    ->name('konsul.cek-protein-buah');
Route::post('/cek-karbohidrat-buah', [KonsulController::class, 'cekKarbohidratBuah'])
    ->name('konsul.cek-karbohidrat-buah');
Route::post('/cek-lemak-buah', [KonsulController::class, 'cekLemakBuah'])
    ->name('konsul.cek-lemak-buah');

Route::post('/cek-protein-pokok', [KonsulController::class, 'cekProteinPokok'])
    ->name('konsul.cek-protein-pokok');
Route::post('/cek-karbohidrat-pokok', [KonsulController::class, 'cekKarbohidratPokok'])
    ->name('konsul.cek-karbohidrat-pokok');
Route::post('/cek-lemak-pokok', [KonsulController::class, 'cekLemakPokok'])
    ->name('konsul.cek-lemak-pokok');

Route::get('/riwayat_penyakit', [RiwayatPenyakitController::class, 'index'])
    ->name('riwayat-penyakit.index');
Route::get('/create-penyakit', [RiwayatPenyakitController::class, 'create'])
    ->name('riwayat-penyakit.create');
Route::post('/tambah-penyakit', [RiwayatPenyakitController::class, 'store'])
    ->name('riwayat-penyakit.store');
Route::get('/pasien/{nomor_pasien}', [PasienController::class, 'getPasien']);

Route::get('/riwayatpenyakit/{id_pasien}', [RiwayatPenyakitController::class, 'getRiwayat']);
Route::get('/ahli-gizi/{nip}', [AhliGiziController::class, 'getAhligizi']);