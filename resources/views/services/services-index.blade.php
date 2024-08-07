@extends('layouts/contentNavbarLayout')

@section('title', 'Layanan')

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
        <h5 class="mb-0">Daftar Layanan</h5>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahLayanan">
            <span class="tf-icons bx bx-plus-circle me-1"></span>Tambah Layanan
        </button>
    </div>

    @else
    <h5 class="card-header">Daftar Layanan</h5>
    @endif

    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Layanan</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Durasi</th>
                    @if(auth()->user()->role == 'admin')
                    <th>Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach($layananDaftar as $key => $row)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $row->jenis_layanan }}</td>
                    <!-- <td>{{ \Carbon\Carbon::parse($row->created_at)->translatedFormat('l, j F Y') }}</td> -->
                    <td>Rp{{ number_format($row->harga, 0, ',', '.') }}</td>
                    <td>{{ $row->jenis_satuan }}</td>
                    <td>{{ $row->durasi_layanan }}</td>
                    @if(auth()->user()->role == 'admin')
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalEditLayanan{{ $row->id }}"><i class=" bx bx-edit-alt me-1"></i> Edit</a>
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalHapusLayanan{{ $row->id }}"><i class=" bx bx-trash me-1"></i> Delete</a>
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

<!-- MODAL TAMBAH LAYANAN -->
<div class="modal fade" id="modalTambahLayanan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Tambah Layanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('tambahlayanan') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="dobBasic" class="form-label">Nama Layanan</label>
                            <input type="text" name="jenis_layanan" class="form-control" placeholder="Masukkan Nama Layanan">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="emailBasic" class="form-label">Harga</label>
                            <input type="number" name="harga" class="form-control" placeholder="Masukkan Harga">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="emailBasic" class="form-label">Jenis Layanan</label>
                            <select id="defaultSelect" class="form-select" name="jenis_satuan">
                                <option disabled selected value="">Pilih Jenis</option>
                                <option value="satuan">Satuan</option>
                                <option value="kiloan">Kiloan</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="emailBasic" class="form-label">Durasi Layanan</label>
                            <select id="defaultSelect" class="form-select" name="durasi_layanan">
                                <option disabled selected value="">Pilih Durasi</option>
                                <option value="12 jam">12 Jam</option>
                                <option value="2 hari">2 Hari</option>
                            </select>
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

<!-- MODAL EDIT LAYANAN -->
@foreach($layananDaftar as $row)
<div class="modal fade" id="modalEditLayanan{{ $row->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Edit Layanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('editlayanan',$row->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameWithTitle" class="form-label">Jenis Layanan</label>
                            <input type="text" name="jenis_layanan" class="form-control" value="{{ $row->jenis_layanan }}">
                        </div>
                    </div>
                    <div class="col mb-3">
                        <label for="emailWithTitle" class="form-label">Harga/Kg</label>
                        <input type="number" name="harga" class="form-control" value="{{ $row->harga }}">
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="emailBasic" class="form-label">Jenis Satuan</label>
                            <select id="defaultSelect" class="form-select" name="jenis_satuan">
                                <option value="satuan" @if($row->jenis_satuan == 'satuan') selected @endif>Satuan</option>
                                <option value="kiloan" @if($row->jenis_satuan == 'kiloan') selected @endif>Kiloan</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="emailBasic" class="form-label">Durasi Layanan</label>
                            <select id="defaultSelect" class="form-select" name="durasi_layanan">
                            <option value="12 jam" @if($row->durasi_layanan == '12 jam') selected @endif>12 Jam</option>
                            <option value="2 hari" @if($row->durasi_layanan == '2 hari') selected @endif>2 Hari</option>
                            </select>
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

<!-- MODAL HAPUS LAYANAN -->
@foreach($layananDaftar as $row)
<div class="modal fade" id="modalHapusLayanan{{ $row->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Hapus Layanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin untuk menghapus jenis layanan <b>{{ $row->jenis_layanan }}</b> ?
            </div>
            <form action="{{ route('hapuslayanan',$row->id) }}" method="POST">
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