@extends('layouts/contentNavbarLayout')

@section('title', 'Pakaian')

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card">
    @if(auth()->user()->role == 'admin')
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Pakaian</h5>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahPakaian">
            <span class="tf-icons bx bx-plus-circle me-1"></span>Tambah Pakaian
        </button>
    </div>
    @else
    <h5 class="card-header">Daftar Pakaian</h5>
    @endif
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Pakaian</th>
                    <th>Harga/Kg</th>
                    @if(auth()->user()->role == 'admin')
                    <th>Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach($pakaianDaftar as $key => $row)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $row->jenis_pakaian }}</td>
                    <!-- <td>{{ \Carbon\Carbon::parse($row->created_at)->translatedFormat('l, j F Y') }}</td> -->
                    <td>Rp{{ number_format($row->harga, 0, ',', '.') }}</td>
                    @if(auth()->user()->role == 'admin')
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalEditPakaian{{ $row->id }}"><i class=" bx bx-edit-alt me-1"></i> Edit</a>
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalHapusPakaian{{ $row->id }}"><i class=" bx bx-trash me-1"></i> Delete</a>
                            </div>
                        </div>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL TAMBAH PAKAIAN -->
<div class="modal fade" id="modalTambahPakaian" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Tambah Pakaian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('tambahpakaian') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="dobBasic" class="form-label">Jenis Pakaian</label>
                            <input type="text" name="jenis_pakaian" class="form-control" placeholder="Masukkan Jenis Pakaian">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="emailBasic" class="form-label">Harga</label>
                            <input type="number" name="harga" class="form-control" placeholder="Masukkan Harga">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END -->

<!-- MODAL EDIT PAKAIAN -->
@foreach($pakaianDaftar as $row)
<div class="modal fade" id="modalEditPakaian{{ $row->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Edit Pakaian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('editpakaian',$row->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameWithTitle" class="form-label">Jenis Pakaian</label>
                            <input type="text" name="jenis_pakaian" class="form-control" value="{{ $row->jenis_pakaian }}">
                        </div>
                    </div>
                    <div class="col mb-3">
                        <label for="emailWithTitle" class="form-label">Harga/Kg</label>
                        <input type="number" name="harga" class="form-control" value="{{ $row->harga }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
<!-- END -->

<!-- MODAL HAPUS PAKAIAN -->
@foreach($pakaianDaftar as $row)
<div class="modal fade" id="modalHapusPakaian{{ $row->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Hapus Pakaian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin untuk menghapus jenis pakaian <b>{{ $row->jenis_pakaian }}</b> ?
            </div>
            <form action="{{ route('hapuspakaian',$row->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-danger">Ya, hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection
<!-- END -->