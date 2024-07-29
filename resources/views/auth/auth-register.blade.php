@extends('layouts/blankLayout')

@section('title', 'Register - Pages')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection


@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
      <!-- Register Card -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center">
            <a href="{{url('/')}}" class="app-brand-link gap-2">
              <span class="app-brand-logo demo"><img src="../assets/img/laundry.png" width="40pt" height="40pt" alt=""></span>
              <span class="app-brand-text demo text-body fw-bold">{{config('variables.templateName')}}</span>
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-2">Mulai pengalaman baru 🚀</h4>
          <p class="mb-4">Buat manajemen aplikasimu menjadi seru!</p>


          @if ($errors->any())
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif
          <form id="formAuthentication" enctype="multipart/form-data" class="mb-3" action="{{ route('daftaraksi') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label for="username" class="form-label">Nama</label>
              <input type="text" class="form-control" id="username" name="name" placeholder="Oktaviani Pratiwi" autofocus required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="okta05532@gmail.com" required>
            </div>
            <div class="mb-3">
              <label for="username" class="form-label">Alamat</label>
              <input type="text" class="form-control" id="username" name="alamat" placeholder="Bungo Pasang" autofocus required>
            </div>
            <div class="mb-3">
              <label for="username" class="form-label">Nomor Telepon</label>
              <input type="number" class="form-control" id="username" name="no_telp" placeholder="083181597441" autofocus required>
            </div>
            <div class="mb-3 form-password-toggle">
              <label class="form-label" for="password">Password</label>
              <div class="input-group input-group-merge">
                <input type="password" required id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>
            <div class="mb-3 form-password-toggle">
              <label class="form-label" for="password">Konfirmasi Password</label>
              <div class="input-group input-group-merge">
                <input type="password" required id="password" class="form-control" name="password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>


            <!-- <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms">
                <label class="form-check-label" for="terms-conditions">
                  Saya setuju dengan
                  aturan yang berlaku
                </label>
              </div>
            </div> -->
            <button type="submit" class="btn btn-primary d-grid w-100">
              Sign up
            </button>
          </form>

          <p class="text-center">
            <span>Sudah punya akun?</span>
            <a href="{{url('')}}">
              <span>Masuk sekarang</span>
            </a>
          </p>
        </div>
      </div>
      <!-- Register Card -->
    </div>
  </div>
</div>
@endsection