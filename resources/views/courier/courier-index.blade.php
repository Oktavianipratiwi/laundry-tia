@extends('layouts/contentNavbarLayout')

@section('title', 'Kurir')

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Kurir</h5>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahKurir">
            <span class="tf-icons bx bx-plus-circle me-1"></span>Tambah Kurir
        </button>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Kontak</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Actions</th>
                </tr>
            </thead>
            @foreach($kurirDaftar as $key => $row)
            <tbody class="table-border-bottom-0">
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->no_telp }}</td>
                    <td>{{ $row->email }}</td>
                    <td>{{ $row->alamat }}</td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalEditKurir{{ $row->id }}""><i class=" bx bx-edit-alt me-1"></i> Edit</a>
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalHapusKurir{{ $row->id }}""><i class=" bx bx-trash me-1"></i> Delete</a>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
            @endforeach
        </table>
    </div>
</div>

<!-- MODAL TAMBAH KURIR -->
<div class="modal fade" id="modalTambahKurir" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Tambah Kurir</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('tambahkurir') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="nameBasic" class="form-label">Nama</label>
                            <input type="text" name="name" class="form-control" placeholder="Masukkan Nama Kurir">
                        </div>
                        <div class="col mb-3">
                            <label for="dobBasic" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="emailBasic" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        <div class="col mb-3">
                            <label for="dobBasic" class="form-label">Kontak</label>
                            <input type="number" name="no_telp" class="form-control">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="emailBasic" class="form-label">Alamat</label>
                            <textarea class="form-control" name="alamat"></textarea>
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

<!-- MODAL EDIT KURIR -->
@foreach($kurirDaftar as $row)
<div class="modal fade" id="modalEditKurir{{ $row->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Edit Kurir</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('editkurir', $row->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="nameBasic" class="form-label">Nama</label>
                            <input type="text" name="name" class="form-control" value="{{ $row->name }}">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="emailBasic" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $row->email }}">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="dobBasic" class="form-label">Kontak</label>
                            <input type="number" name="no_telp" class="form-control" value="{{ $row->no_telp }}">
                        </div>
                    </div>
                    <div class=" row g-2">
                        <div class="col mb-3">
                            <label for="emailBasic" class="form-label">Alamat</label>
                            <textarea class="form-control" name="alamat">{{ $row->alamat }}</textarea>
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
@endforeach
<!-- END -->

<!-- MODAL HAPUS KURIR -->
@foreach($kurirDaftar as $row)
<div class="modal fade" id="modalHapusKurir{{ $row->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Hapus Pakaian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin untuk menghapus kurir dengan nama <b>{{ $row->name }}</b> ?
            </div>
            <form action="{{ route('hapuskurir',$row->id) }}" method="POST">
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
<!-- END -->
@endsection