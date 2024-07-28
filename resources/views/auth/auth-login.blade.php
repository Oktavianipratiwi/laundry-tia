@extends('layouts/blankLayout')

@section('title', 'Login - Pages')

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
          <p class="mb-4">Silahkan masukkan akun Anda dan mulai pengalaman baru!</p>

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


          <form id="formAuthentication" class="mb-3" action="{{ route('loginaksi') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="text" class="form-control" id="email" name="email" placeholder="Masukkan email Anda" required autofocus>
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">Password</label>
                <!-- <a href="{{url('auth/forgot-password-basic')}}">
                  <small>Lupa Password?</small>
                </a> -->
              </div>
              <div class="input-group input-group-merge">
                <input type="password" required id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" type="submit">Log in</button>
            </div>
          </form>

          <p class="text-center">
            <span>Belum pernah masuk? Silahkan</span>
            <a href="{{ route('register') }}">
              <span>Register!</span>
            </a>
          </p>
        </div>
      </div>
    </div>
    <!-- /Register -->
  </div>
</div>
</div>
@endsection