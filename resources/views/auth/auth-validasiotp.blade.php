@extends('layouts/blankLayout')

@section('title', 'Validasi OTP - Pages')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('content')
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <!-- Register -->
            <div class="card">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center">
                        <a href="{{url('/')}}" class="app-brand-link gap-2">
                            <span class="app-brand-logo demo"> <img src="../assets/img/laundry.png" width="40pt" height="40pt" alt="">
                            </span>
                            <span class="app-brand-text demo text-body fw-bold">{{config('variables.templateName')}}</span>
                        </a>
                    </div>
                    <!-- /Logo -->
                    <h5 class="mb-2"><b>Selamat Datang di {{config('variables.templateName')}}! 👋</b></h5>
                    <p class="mb-4">Silahkan masukkan kode OTP Anda yang telah dikirimkan melalui email yang telah diinputkan.</p>

                    @if(session()->has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session()->get('success') }}
                    </div>
                    @elseif($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form id="formAuthentication" class="mb-3" action="{{ route('validasiotpaksi') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">OTP</label>
                            <input type="number" class="form-control" id="otp" name="otp" placeholder="Masukkan OTP Anda" required autofocus>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">Verifikasi OTP</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection