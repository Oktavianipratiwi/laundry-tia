@php
$isMenu = false;
$navbarHideToggle = false;
@endphp

@extends('layouts/contentNavbarLayout')

@section('title', 'Pemantauan Berat Secara Langsung')

@section('content')
<!-- Pemantauan Berat Secara Langsung -->
<div class="layout-demo-wrapper">
    <div class="row">
        <div class="col-md-6">
            <div class="card mt-4">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mb-4">
                        <a href="{{url('/')}}" class="app-brand-link gap-2">
                            <span class="app-brand-logo demo">
                                <img src="../assets/img/laundry.png" width="40pt" height="40pt" alt="Logo">
                            </span>
                            <span class="app-brand-text demo text-body fw-bold">{{config('variables.templateName')}}</span>
                        </a>
                    </div>
                    <!-- /Logo -->

                    <!-- Tampilan Berat Langsung -->
                    <div class="mb-4 mt-4">
                        <h2 class="text-center mb-3">Pemantauan Berat Secara Langsung</h2>
                        <div class="text-center">
                            <h1 class="display-1 fw-bold" id="beratLangsung">{{ $berat && $berat->weight !== null ? $berat->weight : '0' }} Kg</h1>
                        </div>
                    </div>

                    <div class="text-center">
                        <form action="{{url('pesanan')}}" method="GET">
                            <button type="submit" class="btn btn-primary">
                                <span class="tf-icons bx bxs-chevrons-left me-1"></span>Kembali Ke Halaman Pesanan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('tambahtransaksikiloan', $pesananDaftar->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                        <div class="row g-2">
                            <div class="col mb-1">
                                <label for="nameBasic" class="form-label"><b>Nama</b></label>
                                <input type="text" name="user_id" class="form-control" value="{{ $pesananDaftar->user->name }}" readonly>
                                <input type="hidden" name="user_id" value="{{ $pesananDaftar->user->id }}">
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-1">
                                <label for="defaultSelect" class="form-label"><b>Layanan : Kiloan</b></label>
                                <input type="text" name="layanan_id" class="form-control" value="{{ $pesananDaftar->layanan->jenis_layanan }}" readonly>
                                <input type="hidden" name="layanan_id" value="{{ $pesananDaftar->layanan->id }}">
                            </div>
                        </div>
                        <!-- HIDDEN GEMS -->
                        <input type="hidden" name="tgl_ditimbang" class="form-control" value="{{ \Carbon\Carbon::now()->toDateString() }}">
                        <!-- END -->
                        <div class="row g-2">
                            <div class="col mb-1">
                                <label for="dobBasic" class="form-label"><b>Total Berat (Dalam KG)</b></label>
                                <input type="text" name="total_berat" class="form-control" value="{{ $berat ? $berat->weight : '' }}" required readonly>
                                </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-1">
                                <label for="dobBasic" class="form-label"><b>Jumlah Helai Pakaian</b></label>
                                <input type="number" name="helai_pakaian" class="form-control" required placeholder="Masukkan Jumlah Helai Pakaian.">
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-1">
                                <label for="dobBasic" class="form-label"><b>Foto Pakaian</b></label>
                                <input type="file" accept=".jpg, .jpeg, .heic" name="foto_pakaian" class="form-control" required>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-1">
                                <label for="emailBasic" class="form-label"><b>Status</b></label>
                                <select id="defaultSelect" class="form-select" name="status_pembayaran" required oninvalid="this.setCustomValidity('Pilih Status Pembayaran Terlebih dahulu.')" oninput="this.setCustomValidity('')">
                                    <option disabled selected value="">Pilih Status Pembayaran</option>
                                    <option value=" belum lunas">Belum Lunas</option>
                                    <option value="lunas">Lunas</option>
                                </select>
                            </div>
                        </div>
                        <div class="row g-2 mt-2">
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!--/ Pemantauan Berat Secara Langsung -->
@endsection

@section('page-script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function updateWeight() {
            $.ajax({
                url: '/get-latest-weight',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.weight !== null) {
                        $('#beratLangsung').text(data.weight + ' Kg');
                    } else {
                        $('#beratLangsung').text('0 Kg');                    
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching weight: " + error);
                    $('#beratLangsung').text('0 Kg');
                }
            });
        }

        // Update berat setiap 0.1 detik
        setInterval(updateWeight, 100);

        // Update berat segera setelah halaman dimuat
        updateWeight();
    });
</script>
@endsection