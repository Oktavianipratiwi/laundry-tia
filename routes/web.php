<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\menu\AuthController;
use App\Http\Controllers\menu\BeratLiveController;
use App\Http\Controllers\menu\OrderController;
use App\Http\Controllers\menu\CourierController;
use App\Http\Controllers\menu\CustomersController;
use App\Http\Controllers\menu\ProfileController;
use App\Http\Controllers\menu\ServicesController;
use App\Http\Controllers\menu\TransactionsController;
use App\Http\Controllers\menu\WeightController;

// ROUTE UNTUK PROJEK TA ADA DIBAWAH INI

// LOGIN
Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/loginaksi', [AuthController::class, 'loginaksi'])->name('loginaksi');

// REGISTER
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/daftaraksi', [AuthController::class, 'daftaraksi'])->name('daftaraksi');

// VERIFIKASI EMAIL
Route::get('/validasiotp', [AuthController::class, 'validasiotp'])->name('validasiotp');
Route::post('/validasiotpaksi', [AuthController::class, 'validasiotpaksi'])->name('validasiotpaksi');

// LOGOUT
Route::get('/logoutaksi', [AuthController::class, 'logoutaksi'])->name('logoutaksi');


// RUTE UNTUK HAK AKSES ADMIN, PEGAWAI, DAN PELANGGAN
Route::middleware(['auth', 'checkRole:admin,pegawai,pelanggan'])->group(function () {
    Route::get('/dashboard', [Analytics::class, 'index'])->name('dashboard');
    // order/pesanan
    Route::get('/pesanan', [OrderController::class, 'index'])->name('order-index');
    // services/layanan
    Route::get('/layanan', [ServicesController::class, 'index'])->name('services-index');

    // profil
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile-index');
    Route::post('/editprofile', [ProfileController::class, 'editprofile'])->name('editprofile');
});

// RUTE UTK ADMIN DAN PELANGGAN
Route::middleware(['auth', 'checkRole:admin,pelanggan'])->group(function () {
    // transactions/transaksi
    Route::get('/transaksi', [TransactionsController::class, 'index'])->name('transactions-index');
    Route::get('/detailtransaksi/{id}', [TransactionsController::class, 'detailtransaksi'])->name('detailtransaksi');
});

// RUTE UTK ADMIN SAJA
Route::middleware(['auth', 'checkRole:admin'])->group(function () {
    //courier/kurir
    Route::get('/kurir', [CourierController::class, 'index'])->name('courier-index');
    Route::post('/tambahkurir', [CourierController::class, 'tambahkurir'])->name('tambahkurir');
    Route::post('/editkurir/{id}', [CourierController::class, 'editkurir'])->name('editkurir');
    Route::delete('/hapuskurir/{id}', [CourierController::class, 'hapuskurir'])->name('hapuskurir');
    //customers/pelanggan
    Route::get('/pelanggan', [CustomersController::class, 'index'])->name('customers-index');
    Route::post('/tambahpelanggan', [CustomersController::class, 'tambahpelanggan'])->name('tambahpelanggan');
    Route::post('/editpelanggan/{id}', [CustomersController::class, 'editpelanggan'])->name('editpelanggan');
    Route::delete('/hapuspelanggan/{id}', [CustomersController::class, 'hapuspelanggan'])->name('hapuspelanggan');
    // services/layanan
    Route::post('/tambahlayanan', [ServicesController::class, 'tambahlayanan'])->name('tambahlayanan');
    Route::post('/editlayanan/{id}', [ServicesController::class, 'editlayanan'])->name('editlayanan');
    Route::delete('/hapuslayanan/{id}', [ServicesController::class, 'hapuslayanan'])->name('hapuslayanan');
    // transactions/transaksi
    Route::post('/konfirmasitransaksi/{id}', [TransactionsController::class, 'konfirmasitransaksi'])->name('konfirmasitransaksi');
    Route::delete('/hapustransaksi/{id}', [TransactionsController::class, 'hapustransaksi'])->name('hapustransaksi');
});

// RUTE UTK PEGAWAI SAJA
Route::middleware(['auth', 'checkRole:pegawai'])->group(function () {
    // order/pesanan
    Route::post('/konfirmasiwhatsapp/{id}', [OrderController::class, 'konfirmasiwhatsapp'])->name('konfirmasiwhatsapp');
    Route::post('/konfirmasipesananantar/{id}', [OrderController::class, 'konfirmasipesananantar'])->name('konfirmasipesananantar');
    Route::post('/konfirmasipesananjemput/{id}', [OrderController::class, 'konfirmasipesananjemput'])->name('konfirmasipesananjemput');
    Route::post('/pesananselesai/{id}', [OrderController::class, 'pesananselesai'])->name('pesananselesai');
    Route::post('/editpesanan/{id}', [OrderController::class, 'editpesanan'])->name('editpesanan');
    Route::delete('/hapuspesanan/{id}', [OrderController::class, 'hapuspesanan'])->name('hapuspesanan');

    //Buat transaksi
    Route::post('/tambahtransaksikiloan/{id}', [OrderController::class, 'tambahtransaksikiloan'])->name('tambahtransaksikiloan');
    Route::post('/tambahtransaksisatuan/{id}', [OrderController::class, 'tambahtransaksisatuan'])->name('tambahtransaksisatuan');

    // BERAT TIMBANGAN
    Route::get('/weights', [WeightController::class, 'index'])->name('weights.index');

    Route::get('/berat-live', [BeratLiveController::class, 'index']);
    Route::get('/get-latest-weight', [BeratLiveController::class, 'getLatestWeight']);
});

// RUTE UNTUK HAK AKSES PELANGGAN SAJA
Route::middleware(['auth', 'checkRole:pelanggan'])->group(function () {
    Route::post('/tambahpesanan', [OrderController::class, 'tambahpesanan'])->name('tambahpesanan');

    // TRANSAKSI PELANGGAN
    Route::post('/bayartransaksi/{id}', [TransactionsController::class, 'bayartransaksi'])->name('bayartransaksi');
});
