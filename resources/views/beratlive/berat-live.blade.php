@php
$isMenu = false;
$navbarHideToggle = false;
@endphp

@extends('layouts/contentNavbarLayout')

@section('title', 'Pemantauan Berat Secara Langsung')

@section('content')
<!-- Pemantauan Berat Secara Langsung -->
<div class="layout-demo-wrapper">
    <div class="card">
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
                    <h1 class="display-1 fw-bold" id="beratLangsung">{{ $berat->weight }} Kg</h1>
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
                        $('#beratLangsung').text('N/A');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching weight: " + error);
                }
            });
        }

        // Update berat setiap 5 detik
        setInterval(updateWeight, 500);

        // Update berat segera setelah halaman dimuat
        updateWeight();
    });
</script>
@endsection