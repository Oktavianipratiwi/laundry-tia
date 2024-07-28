@extends('layouts/contentNavbarLayout')

@section('title', 'Profil')

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row">
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Profil Anda</h5>
            </div>
            <form action="{{ route('editprofile') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name"><b>Nama</b></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="basic-default-name" name="name" value="{{ $profile->name }}" required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name"><b>Email</b></label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="basic-default-name" name="email" value="{{ $profile->email }}" required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name"><b>Alamat</b></label>
                        <div class="col-sm-10">
                            <textarea id="basic-default-message" name="alamat" class="form-control" aria-label="Hi, Do you have a moment to talk Joe?" aria-describedby="basic-icon-default-message2" required>{{ $profile->alamat }}</textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name"><b>Kontak</b></label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="basic-default-name" name="no_telp" value="{{ $profile->no_telp }}" required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name"><b>Password</b></label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="basic-default-name" name="password" />
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Edit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection