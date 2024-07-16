<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Analytics extends Controller
{
  // public function index()
  // {
  //   $userName = Auth::user()->name; // Sesuaikan dengan kolom nama yang ada di database
  //   return view('content.dashboard.dashboards-analytics', compact('userName'));
  // }

  public function index()
  {
    $userName = Auth::user()->name; // Sesuaikan dengan kolom nama yang ada di database

    // Mengambil data dari tabel-tabel yang relevan
    $activeOrders = Pemesanan::where('status_pemesanan', '!=', 'sudah diproses')->count();
    $completedTransactions = Transaksi::where('status_pembayaran', 'lunas')->count();
    $totalCustomers = User::where('role', 'pelanggan')->count();
    $totalCouriers = User::where('role', 'pegawai')->count();
    $recentOrders = Pemesanan::orderBy('created_at', 'desc')->take(5)->get();
    $dailyRevenue = Transaksi::whereDate('created_at', now()->toDateString())->count();
    $monthlyRevenue = Transaksi::whereMonth('created_at', now()->month)->count();

    $currentYear = Carbon::now()->year;
    $monthlyCustomers = [];

    for ($month = 1; $month <= 12; $month++) {
      $count = User::where('role', 'pelanggan')
        ->whereYear('created_at', $currentYear)
        ->whereMonth('created_at', $month)
        ->count();

      $monthlyCustomers[] = $count;
    }

    // Data untuk chart
    $chartData = [
      'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      'data' => $monthlyCustomers,
    ];

    // Mengirim data ke view
    return view(
      'content.dashboard.dashboards-analytics',
      compact(
        'userName',
        'activeOrders',
        'completedTransactions',
        'totalCustomers',
        'totalCouriers',
        'recentOrders',
        'dailyRevenue',
        'monthlyRevenue',
        'chartData'
      ),
    );
  }
}
