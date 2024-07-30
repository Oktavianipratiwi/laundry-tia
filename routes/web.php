<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\layouts\WithoutMenu;
use App\Http\Controllers\layouts\WithoutNavbar;
use App\Http\Controllers\layouts\Fluid;
use App\Http\Controllers\layouts\Container;
use App\Http\Controllers\layouts\Blank;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\pages\AccountSettingsNotifications;
use App\Http\Controllers\pages\AccountSettingsConnections;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\pages\MiscUnderMaintenance;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\cards\CardBasic;
use App\Http\Controllers\user_interface\Accordion;
use App\Http\Controllers\user_interface\Alerts;
use App\Http\Controllers\user_interface\Badges;
use App\Http\Controllers\user_interface\Buttons;
use App\Http\Controllers\user_interface\Carousel;
use App\Http\Controllers\user_interface\Collapse;
use App\Http\Controllers\user_interface\Dropdowns;
use App\Http\Controllers\user_interface\Footer;
use App\Http\Controllers\user_interface\ListGroups;
use App\Http\Controllers\user_interface\Modals;
use App\Http\Controllers\user_interface\Navbar;
use App\Http\Controllers\user_interface\Offcanvas;
use App\Http\Controllers\user_interface\PaginationBreadcrumbs;
use App\Http\Controllers\user_interface\Progress;
use App\Http\Controllers\user_interface\Spinners;
use App\Http\Controllers\user_interface\TabsPills;
use App\Http\Controllers\user_interface\Toasts;
use App\Http\Controllers\user_interface\TooltipsPopovers;
use App\Http\Controllers\user_interface\Typography;
use App\Http\Controllers\extended_ui\PerfectScrollbar;
use App\Http\Controllers\extended_ui\TextDivider;
use App\Http\Controllers\icons\Boxicons;
use App\Http\Controllers\form_elements\BasicInput;
use App\Http\Controllers\form_elements\InputGroups;
use App\Http\Controllers\form_layouts\VerticalForm;
use App\Http\Controllers\form_layouts\HorizontalForm;
use App\Http\Controllers\menu\AuthController;
use App\Http\Controllers\menu\BeratLiveController;
use App\Http\Controllers\menu\OrderController;
use App\Http\Controllers\menu\ClothesController;
use App\Http\Controllers\menu\CourierController;
use App\Http\Controllers\menu\CustomersController;
use App\Http\Controllers\menu\ProfileController;
use App\Http\Controllers\menu\ServicesController;
use App\Http\Controllers\menu\TransactionsController;
use App\Http\Controllers\tables\Basic as TablesBasic;
use App\Http\Controllers\menu\WeightController;


// layout
Route::get('/layouts/without-menu', [WithoutMenu::class, 'index'])->name('layouts-without-menu');
Route::get('/layouts/without-navbar', [WithoutNavbar::class, 'index'])->name('layouts-without-navbar');
Route::get('/layouts/fluid', [Fluid::class, 'index'])->name('layouts-fluid');
Route::get('/layouts/container', [Container::class, 'index'])->name('layouts-container');
Route::get('/layouts/blank', [Blank::class, 'index'])->name('layouts-blank');

// pages
Route::get('/pages/account-settings-account', [AccountSettingsAccount::class, 'index'])->name('pages-account-settings-account');
Route::get('/pages/account-settings-notifications', [AccountSettingsNotifications::class, 'index'])->name('pages-account-settings-notifications');
Route::get('/pages/account-settings-connections', [AccountSettingsConnections::class, 'index'])->name('pages-account-settings-connections');
Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');
Route::get('/pages/misc-under-maintenance', [MiscUnderMaintenance::class, 'index'])->name('pages-misc-under-maintenance');

// authentication
Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
Route::get('/auth/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');

// cards
Route::get('/cards/basic', [CardBasic::class, 'index'])->name('cards-basic');

// User Interface
Route::get('/ui/accordion', [Accordion::class, 'index'])->name('ui-accordion');
Route::get('/ui/alerts', [Alerts::class, 'index'])->name('ui-alerts');
Route::get('/ui/badges', [Badges::class, 'index'])->name('ui-badges');
Route::get('/ui/buttons', [Buttons::class, 'index'])->name('ui-buttons');
Route::get('/ui/carousel', [Carousel::class, 'index'])->name('ui-carousel');
Route::get('/ui/collapse', [Collapse::class, 'index'])->name('ui-collapse');
Route::get('/ui/dropdowns', [Dropdowns::class, 'index'])->name('ui-dropdowns');
Route::get('/ui/footer', [Footer::class, 'index'])->name('ui-footer');
Route::get('/ui/list-groups', [ListGroups::class, 'index'])->name('ui-list-groups');
Route::get('/ui/modals', [Modals::class, 'index'])->name('ui-modals');
Route::get('/ui/navbar', [Navbar::class, 'index'])->name('ui-navbar');
Route::get('/ui/offcanvas', [Offcanvas::class, 'index'])->name('ui-offcanvas');
Route::get('/ui/pagination-breadcrumbs', [PaginationBreadcrumbs::class, 'index'])->name('ui-pagination-breadcrumbs');
Route::get('/ui/progress', [Progress::class, 'index'])->name('ui-progress');
Route::get('/ui/spinners', [Spinners::class, 'index'])->name('ui-spinners');
Route::get('/ui/tabs-pills', [TabsPills::class, 'index'])->name('ui-tabs-pills');
Route::get('/ui/toasts', [Toasts::class, 'index'])->name('ui-toasts');
Route::get('/ui/tooltips-popovers', [TooltipsPopovers::class, 'index'])->name('ui-tooltips-popovers');
Route::get('/ui/typography', [Typography::class, 'index'])->name('ui-typography');

// extended ui
Route::get('/extended/ui-perfect-scrollbar', [PerfectScrollbar::class, 'index'])->name('extended-ui-perfect-scrollbar');
Route::get('/extended/ui-text-divider', [TextDivider::class, 'index'])->name('extended-ui-text-divider');

// icons
Route::get('/icons/boxicons', [Boxicons::class, 'index'])->name('icons-boxicons');

// form elements
Route::get('/forms/basic-inputs', [BasicInput::class, 'index'])->name('forms-basic-inputs');
Route::get('/forms/input-groups', [InputGroups::class, 'index'])->name('forms-input-groups');

// form layouts
Route::get('/form/layouts-vertical', [VerticalForm::class, 'index'])->name('form-layouts-vertical');
Route::get('/form/layouts-horizontal', [HorizontalForm::class, 'index'])->name('form-layouts-horizontal');

// tables
Route::get('/tables/basic', [TablesBasic::class, 'index'])->name('tables-basic');

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
    Route::post('/tambahtransaksikiloan/{id}', [OrderController::class, 'tambahtransaksikiloan'])->name('tambahtransaksikiloan');
    Route::post('/tambahtransaksisatuan/{id}', [OrderController::class, 'tambahtransaksisatuan'])->name('tambahtransaksisatuan');
    Route::post('/konfirmasitransaksi/{id}', [TransactionsController::class, 'konfirmasitransaksi'])->name('konfirmasitransaksi');
    Route::delete('/hapustransaksi/{id}', [TransactionsController::class, 'hapustransaksi'])->name('hapustransaksi');
});

// RUTE UTK PEGAWAI SAJA
Route::middleware(['auth', 'checkRole:pegawai'])->group(function () {
    // order/pesanan
    Route::post('/konfirmasipesananantar/{id}', [OrderController::class, 'konfirmasipesananantar'])->name('konfirmasipesananantar');
    Route::post('/konfirmasipesananjemput/{id}', [OrderController::class, 'konfirmasipesananjemput'])->name('konfirmasipesananjemput');
    Route::post('/pesananselesai/{id}', [OrderController::class, 'pesananselesai'])->name('pesananselesai');
    Route::post('/editpesanan/{id}', [OrderController::class, 'editpesanan'])->name('editpesanan');
    Route::delete('/hapuspesanan/{id}', [OrderController::class, 'hapuspesanan'])->name('hapuspesanan');

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
