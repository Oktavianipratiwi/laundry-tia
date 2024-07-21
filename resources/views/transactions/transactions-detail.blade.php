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
                <h5 class="mb-0">Detail Transaksi dengan ID {{ $transaksi->id }}</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-name">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="basic-default-name" value="{{ $transaksi->user->name }}" readonly />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-company">Tanggal Ditimbang</label>
                    <div class="col-sm-10">
                        <input type="date" name="tgl_ditimbang" class="form-control" value="{{ \Carbon\Carbon::parse($transaksi->tgl_ditimbang)->format('Y-m-d') }}" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-company">Tanggal Diambil</label>
                    <div class="col-sm-10">
                        <input type="date" name="tgl_diambil" class="form-control" value="{{ \Carbon\Carbon::parse($transaksi->tgl_diambil)->format('Y-m-d') }}" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-message">Alamat</label>
                    <div class="col-sm-10">
                        <textarea id="basic-default-message" name="alamat" class="form-control" aria-label="Hi, Do you have a moment to talk Joe?" aria-describedby="basic-icon-default-message2" readonly>{{ $transaksi->user->alamat }}</textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-phone">Kontak</label>
                    <div class="col-sm-10">
                        <input type="text" id="basic-default-phone" name="no_telp" class="form-control phone-mask" aria-label="658 799 8941" aria-describedby="basic-default-phone" value="{{ $transaksi->user->no_telp }}" readonly />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-phone">Total Berat</label>
                    <div class="col-sm-10">
                        <input type="text" id="basic-default-phone" name="total_berat" class="form-control phone-mask" aria-label="658 799 8941" aria-describedby="basic-default-phone" value="{{ $transaksi->total_berat }} Kg" readonly />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-phone">Diskon</label>
                    <div class="col-sm-10">
                        <input type="text" id="basic-default-phone" name="diskon" class="form-control phone-mask" aria-label="658 799 8941" aria-describedby="basic-default-phone" value="{{ number_format($transaksi->diskon, 0, ',', '.') }}" readonly />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-phone">Total Bayar</label>
                    <div class="col-sm-10">
                        <input type="text" id="basic-default-phone" name="total_berat" class="form-control phone-mask" aria-label="658 799 8941" aria-describedby="basic-default-phone" value="Rp{{ number_format($transaksi->total_bayar, 0, ',', '.') }}" readonly />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-phone">Status Pembayaran</label>
                    <div class="col-sm-10">
                        <input type="text" id="basic-default-phone" name="status_pembayaran" class="form-control phone-mask" aria-label="658 799 8941" aria-describedby="basic-default-phone" value="{{ $transaksi->status_pembayaran }}" readonly />
                    </div>
                </div>
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
            </div>
        </div>
    </div>
</div>
@endsection