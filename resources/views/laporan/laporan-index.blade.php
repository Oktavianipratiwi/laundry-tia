@extends('layouts/contentNavbarLayout')

@section('title', 'Laporan')

@section('content')
<div class="card">
    <h5 class="card-header fw-bold">Laporan Pemasukan</h5>
    <div class="card-body">
        @foreach($laporanPerBulan as $bulan => $laporanHarian)
            <div class="mb-4">
                <h4 class="text-primary mb-3 fw-bold">{{ Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }}</h4>
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th class="fw-bold">No</th>
                                <th class="fw-bold">Hari dan Tanggal Bayar</th>
                                <th class="fw-bold">Total Uang Masuk</th>
                                <th class="fw-bold">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($laporanHarian as $index => $laporan)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $laporan['tanggal']->translatedFormat('l, j F Y') }}</td>
                                    <td>Rp {{ number_format($laporan['total'], 0, ',', '.') }}</td>
                                    <td>
                                        <a href="{{ route('laporan-detail', $laporan['tanggal']->format('Y-m-d')) }}" class="btn btn-sm btn-primary">Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="2" class="fw-bold">Total Bulan {{ Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }}</th>
                                <th colspan="2" class="fw-bold">Rp {{ number_format(collect($laporanHarian)->sum('total'), 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            @if(!$loop->last)
                <hr class="my-5">
            @endif
        @endforeach
    </div>
</div>
@endsection