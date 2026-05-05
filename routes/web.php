<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\CustomerController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('buku', BukuController::class)->middleware('auth');
Route::resource('kategori', KategoriController::class);
Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
Route::get('/barang/scan', [BarangController::class, 'scan'])->name('barang.scan');
Route::post('/barang/print', [App\Http\Controllers\BarangController::class, 'print'])->name('barang.print');
Route::post('/barang/store', [App\Http\Controllers\BarangController::class, 'store'])->name('barang.store');
Route::get('/barang/create', [App\Http\Controllers\BarangController::class, 'create'])->name('barang.create');

Route::get('/modul4/tabel-biasa', function () {return view('modul4.barang_lokal');});
Route::get('/modul4/tabel-datatables', function () {return view('modul4.barang_datatables');});
Route::get('/modul4/select-kota', function () {return view('modul4.select_kota');});

Route::get('/modul5/wilayah', function (){return view('modul5.wilayah');});
Route::get('/modul5/pos', function () {
    return view('modul5.transaksi'); // Pastikan nama filenya transaksi.blade.php
});
Route::get('/api/barang/{id}', [BarangController::class, 'getBarangByKode']);
Route::post('/api/transaksi/simpan', [App\Http\Controllers\TransaksiController::class, 'simpanTransaksi']);

Route::get('/halaman-pdf', [PDFController::class, 'index']); // Untuk buka halaman form
Route::post('/generate-sertifikat', [PDFController::class, 'generateSertifikat']);
Route::post('/generate-pengumuman', [PDFController::class, 'generatePengumuman']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])
    ->name('google.login');

Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])
    ->name('google.callback');

Route::prefix('modul6')->group(function () {
    Route::get('/pemesanan', [PemesananController::class, 'index']);
    Route::get('/get-menus/{idvendor}', [PemesananController::class, 'getMenus']);
    Route::post('/checkout', [PemesananController::class, 'checkout']);
    Route::post('/payment-success', [PemesananController::class, 'paymentSuccess']);
    Route::get('/vendor-scan', [PemesananController::class, 'vendorScan'])->middleware('auth');
});
Route::get('/api/pesanan/{id}', [PemesananController::class, 'getPesananById']);
Route::get('/customer/tambah-1', [CustomerController::class, 'tambah1'])->name('customer.tambah1');
Route::post('/customer/simpan-1', [CustomerController::class, 'simpan1'])->name('customer.simpan1');
Route::get('/customer/tambah-2', [CustomerController::class, 'tambah2'])->name('customer.tambah2');
Route::post('/customer/simpan-2', [CustomerController::class, 'simpan2'])->name('customer.simpan2');
Route::get('/customer/data', [CustomerController::class, 'index'])->name('customer.index');

require __DIR__.'/auth.php';
