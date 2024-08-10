@php
$isMenu = false;
@endphp

@extends('layouts/contentNavbarLayout')

@section('title', 'Laporan')

@section('content')
<div class="card">
    <h5 class="card-header fw-bold">Detail Transaksi Tanggal {{ Carbon\Carbon::parse($tanggal)->translatedFormat('l, j F Y') }}</h5>
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th class="fw-bold">No</th>
                        <th class="fw-bold">Nama Pelanggan</th>
                        <th class="fw-bold">Layanan</th>
                        <th class="fw-bold">Jenis</th>
                        <th class="fw-bold">Total Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksi as $index => $t)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $t->user->name }}</td>
                            @if($t->total_berat == null)
                            <td>{{ $t->layanan->jenis_layanan }} - {{ $t->jumlah }} Pcs</td>
                            @elseif($t->jumlah == null)
                            <td>{{ $t->layanan->jenis_layanan }} - {{ $t->total_berat }} Kg ({{ $t->helai_pakaian }} Helai)</td>
                            @endif
                            <td>{{ $t->layanan->jenis_satuan }}</td>
                            <td>Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th colspan="4" class="fw-bold">Total</th>
                        <th class="fw-bold">Rp {{ number_format($transaksi->sum('total_bayar'), 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <a href="{{ route('laporan-index') }}" class="btn btn-primary mt-3">Kembali</a>
    </div>
</div>
@endsection