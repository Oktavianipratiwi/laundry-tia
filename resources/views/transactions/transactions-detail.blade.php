@php
$isNavbar = false;
@endphp

@extends('layouts/contentNavbarLayout')

@section('title', 'Detail Transaksi')

@section('content')


<div class="row">
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Detail Transaksi</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-name"><b>Nama</b></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="basic-default-name" value="{{ $transaksi->user->name }}" readonly />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-company"><b>Tanggal Ditimbang</b></label>
                    <div class="col-sm-10">
                        <input type="date" name="tgl_ditimbang" class="form-control" value="{{ \Carbon\Carbon::parse($transaksi->tgl_ditimbang)->format('Y-m-d') }}" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-company"><b>Tanggal dan Jam Jemput</b></label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($pemesanan->tgl_penjemputan)->translatedFormat('l, j F Y') }} - {{ \Carbon\Carbon::parse($pemesanan->jam_jemput)->translatedFormat('H:i') }} WIB" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-company"><b>Tanggal dan Jam Antar</b></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($pemesanan->tgl_pengantaran)->translatedFormat('l, j F Y') }} - {{ \Carbon\Carbon::parse($pemesanan->jam_antar)->translatedFormat('H:i') }} WIB" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-message"><b>Alamat</b></label>
                    <div class="col-sm-10">
                        <textarea id="basic-default-message" name="alamat" class="form-control"  readonly>{{ $transaksi->user->alamat }}</textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-phone"><b>Kontak</b></label>
                    <div class="col-sm-10">
                        <input type="text" id="basic-default-phone" name="no_telp" class="form-control phone-mask" value="{{ $transaksi->user->no_telp }}" readonly />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-phone"><b>Layanan</b></label>
                    <div class="col-sm-10">
                        <input type="text" id="basic-default-phone" name="total_berat" class="form-control phone-mask"  value="{{ $transaksi->layanan->jenis_layanan }}" readonly />
                    </div>
                </div>
                @if($transaksi->total_berat != null)
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-phone"><b>Total Berat</b></label>
                    <div class="col-sm-10">
                        <input type="text" id="basic-default-phone" name="total_berat" class="form-control phone-mask"  value="{{ $transaksi->total_berat }} Kg" readonly />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-phone"><b>Jumlah Helai Pakaian</b></label>
                    <div class="col-sm-10">
                        <input type="text" id="basic-default-phone" name="total_berat" class="form-control phone-mask" value="{{ $transaksi->helai_pakaian }} Pcs" readonly />
                    </div>
                </div>
                @elseif($transaksi->jumlah != null)
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-phone"><b>Jumlah Helai Pakaian Satuan</b></label>
                    <div class="col-sm-10">
                        <input type="text" id="basic-default-phone" name="total_berat" class="form-control phone-mask" aria-label="658 799 8941" aria-describedby="basic-default-phone" value="{{ $transaksi->jumlah }} Pcs" readonly />
                    </div>
                </div>
                @endif
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-phone"><b>Diskon</b></label>
                    <div class="col-sm-10">
                        <input type="text" id="basic-default-phone" name="diskon" class="form-control phone-mask" aria-label="658 799 8941" aria-describedby="basic-default-phone" value="{{ number_format($transaksi->diskon, 0, ',', '.') }}" readonly />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-phone"><b>Total Bayar</b></label>
                    <div class="col-sm-10">
                        <input type="text" id="basic-default-phone" name="total_berat" class="form-control phone-mask" aria-label="658 799 8941" aria-describedby="basic-default-phone" value="Rp{{ number_format($transaksi->total_bayar, 0, ',', '.') }}" readonly />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-phone"><b>Status Pengantaran</b></label>
                    <div class="col-sm-10">
                        <input type="text"  name="status_pembayaran" class="form-control phone-mask"  value="{{ $transaksi->status_pengantaran }}" readonly />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-phone"><b>Status Pembayaran</b></label>
                    <div class="col-sm-10">
                        <input type="text"  name="status_pembayaran" class="form-control phone-mask"  value="{{ $transaksi->status_pembayaran }}" readonly />
                    </div>
                </div>
                @if($user->role != 'admin')
                @if($transaksi->status_pembayaran == 'belum lunas')
                <form action="{{ route('bayartransaksi', $transaksi->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-phone">Unggah bukti Pembayaran</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" id="bukti_pembayaran" name="bukti_pembayaran" required>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Bayar</button>
                        </div>
                    </div>
                </form>
                @endif
                @if($transaksi->bukti_pembayaran)
                <div class="mt-3 text-center">
                    <p><strong>Bukti Pembayaran:</strong></p>
                    <img src="{{ asset($transaksi->bukti_pembayaran) }}" alt="Bukti Pembayaran" class="img-fluid" style="width: 50%; height: 50%;">
                </div>
                @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection