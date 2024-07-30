@extends('layouts/contentNavbarLayout')

@section('title', 'Pesanan')

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card">
    @if(auth()->user()->role == 'pegawai')
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Pesanan</h5>
        <form action="{{url('berat-live')}}" method="GET">
            <button type="submit" class="btn btn-primary">
                <span class="tf-icons bx bx-check-circle me-1"></span>Timbang!
            </button>
        </form>
    </div>

    @elseif(auth()->user()->role == 'admin')
    <h5 class="card-header">Daftar Pesanan</h5>

    @elseif(auth()->user()->role == 'pelanggan')
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Pesanan</h5>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahPesanan">
            <span class="tf-icons bx bx-plus-circle me-1"></span>Tambah Pesanan
        </button>
    </div>
    @endif

    <div class="table-responsive text-nowrap">
        @if(auth()->user()->role == 'pegawai')
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pelanggan</th>
                    <th>Tanggal Pemesanan</th>
                    <th>Alamat</th>
                    <th>Kontak</th>
                    <th>Status</th>
                    <th class="text-center" colspan="2">Actions</th>
                </tr>
            </thead>
            @if($pesananDaftar->isEmpty())
            <tr>
                <td colspan="6" class="text-center"><b>Pesanan belum ada</b></td>
            </tr>
            @endif
            @foreach($pesananDaftar as $key => $row)
            <tbody class="table-border-bottom-0">
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $row->user->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($row->tgl_pemesanan)->translatedFormat('l, j F Y') }}</td>
                    <td>{{ $row->alamat }}</td>
                    <td>{{ $row->no_telp }}</td>
                    <td>
                        @if($row->status_pemesanan == 'sudah diproses')
                        <span class="badge bg-label-success me-1">Sudah diproses</span>
                        @elseif($row->status_pemesanan == 'belum diproses')
                        <span class="badge bg-label-warning me-1">Belum diproses</span>
                        @elseif($row->status_pemesanan == 'pegawai menuju lokasi')
                        <span class="badge bg-label-info me-1">kurir jemput pesanan</span>
                        @elseif($row->status_pemesanan == 'antar pesanan')
                        <span class="badge bg-label-info me-1">kurir antar pesanan</span>
                        @elseif($row->status_pemesanan == 'sudah diperiksa')
                        <span class="badge bg-label-primary me-1">Sudah diperiksa</span>
                        @endif
                    </td>
                    @if(auth()->user()->role == 'pegawai')
                    <td>
                        @if($row->status_pemesanan == 'belum diproses')
                        <form action="{{ route('konfirmasipesananjemput', $row->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary">
                                <span class="tf-icons bx bx-pie-chart-alt me-1"></span>Jemput Pesanan
                            </button>
                        </form>
                        @elseif($row->status_pemesanan == 'pegawai menuju lokasi')
                        <button type="button" data-bs-toggle="modal" data-bs-target="#modalTipeLayanan{{ $row->id }}" class=" btn btn-outline-primary">
                            <span class="tf-icons bx bx-pie-chart-alt me-1"></span>Buat Transaksi
                        </button>
                        @elseif($row->status_pemesanan == 'sudah diproses')
                        <form action="{{ route('konfirmasipesananantar', $row->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary">
                                <span class="tf-icons bx bx-pie-chart-alt me-1"></span>Antar Pesanan
                            </button>
                        </form>
                        @elseif($row->status_pemesanan == 'antar pesanan')
                        <form action="{{ route('pesananselesai', $row->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary">
                                <span class="tf-icons bx bx-pie-chart-alt me-1"></span>Pesanan Selesai
                            </button>
                        </form>
                        @elseif($row->status_pemesanan == 'sudah diperika')
                        <button type="submit" class="btn btn-outline-primary">
                            <span class="tf-icons bx bx-pie-chart-alt me-1"></span>Pesanan Selesai
                        </button>
                        @endif
                    </td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalEditPesanan{{ $row->id }}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalHapusPesanan{{ $row->id }}"><i class="bx bx-trash me-1"></i> Delete</a>
                            </div>
                        </div>
                    </td>
                    @endif
                </tr>
            </tbody>
            @endforeach
        </table>

        <!-- admin & pelanggan -->
        @else
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Pemesanan</th>
                    <th>Alamat</th>
                    <th>No Telp</th>
                    <th>Status Pemesanan</th>
                </tr>
            </thead>
            @if(count($pesananDaftar) == 0)
            <td style="font-weight:bold; text-align:center;" colspan="5">Pesanan Belum Ada</td>
            @else
            @foreach($pesananDaftar as $key => $row)
            <tbody class="table-border-bottom-0">
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($row->tgl_pemesanan)->translatedFormat('l, j F Y') }}</td>
                    <td>{{ $row->alamat }}</td>
                    <td>{{ $row->no_telp }}</td>
                    <td>
                        @if($row->status_pemesanan == 'sudah diproses')
                        <span class="badge bg-label-success me-1">Sudah diproses</span>
                        @elseif($row->status_pemesanan == 'belum diproses')
                        <span class="badge bg-label-warning me-1">Belum diproses</span>
                        @elseif($row->status_pemesanan == 'pegawai menuju lokasi')
                        <span class="badge bg-label-info me-1">kurir jemput pesanan</span>
                        @elseif($row->status_pemesanan == 'antar pesanan')
                        <span class="badge bg-label-info me-1">kurir antar pesanan</span>
                        @elseif($row->status_pemesanan == 'sudah diperiksa')
                        <span class="badge bg-label-primary me-1">Sudah diperiksa</span>
                        @endif
                    </td>
                </tr>
            </tbody>
            @endforeach
            @endif
        </table>
        @endif
    </div>
</div>

<!-- MODAL TAMBAH PESANAN UNTUK PELANGGAN-->
<div class="modal fade" id="modalTambahPesanan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Tambah Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('tambahpesanan') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="dobBasic" class="form-label">Tanggal Pemesanan</label>
                            <input type="date" name="tgl_pemesanan" class="form-control" value="{{ \Carbon\Carbon::now()->toDateString() }}">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="emailBasic" class="form-label">Alamat</label>
                            <textarea class="form-control" name="alamat" placeholder="Masukkan Alamat Lengkap">{{ auth()->user()->alamat }}</textarea>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="dobBasic" class="form-label">Kontak</label>
                            <input type="number" name="no_telp" class="form-control" placeholder="Silahkan masukkan Nomor Hp" value="{{ auth()->user()->no_telp }}">
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

<!-- MODAL TIPE LAYANAN UNTUK KURIR -->
@foreach($pesananDaftar as $row)
<div class="modal fade" id="modalTipeLayanan{{ $row->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Jenis Layanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Pilih Tipe Layanan Pelanggan
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalBuatTransaksiSatuan{{ $row->id }}">Satuan</button>
                <button type=" submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalBuatTransaksiKiloan{{ $row->id }}">Kiloan</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- MODAL BUAT TRANSAKSI SATUAN UTK KURIR-->
@foreach($pesananDaftar as $row)
<div class=" modal fade" id="modalBuatTransaksiSatuan{{ $row->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Tambah Transaksi Satuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('tambahtransaksisatuan', $row->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col mb-1">
                            <label for="nameBasic" class="form-label"><b>Nama</b></label>
                            <input type="text" name="user_id" class="form-control" value="{{ $row->user->name }}" readonly>
                            <input type="hidden" name="user_id" value="{{ $row ? $row->user->id : '' }}">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-1">
                            <label for="defaultSelect" class="form-label"><b>Layanan</b></label>
                            <select id="defaultSelect" class="form-select" name="layanan_id" required oninvalid="this.setCustomValidity('Pilih Jenis Layanan Terlebih dahulu.')" oninput="this.setCustomValidity('')">
                                <option disabled selected value="">Pilih Jenis Layanan</option>
                                @foreach($layananDaftar as $row)
                                @if($row->jenis_satuan == 'satuan')
                                <option value=" {{ $row->id }}">{{ $row->jenis_layanan}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-1">
                            <label for="dobBasic" class="form-label"><b>Tanggal Ditimbang</b></label>
                            <input type="date" name="tgl_ditimbang" class="form-control" value="{{ \Carbon\Carbon::now()->toDateString() }}">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-1">
                            <label for="dobBasic" class="form-label"><b>Jumlah</b></label>
                            <input type="number" name="jumlah" class="form-control">
                        </div>
                    </div>
                    <div class=" row g-2">
                        <div class="col mb-1">
                            <label for="dobBasic" class="form-label"><b>Diskon</b></label>
                            <input type="number" name="diskon" class="form-control" value="0">
                        </div>
                    </div>
                    <div class=" row g-2">
                        <div class="col mb-1">
                            <label for="emailBasic" class="form-label"><b>Status</b></label>
                            <select id="defaultSelect" class="form-select" name="status_pembayaran" required oninvalid="this.setCustomValidity('Pilih Status Pembayaran Terlebih dahulu.')" oninput="this.setCustomValidity('')">
                                <option disabled selected value="">Pilih Status Pembayaran</option>
                                <option value=" belum lunas">Belum Lunas</option>
                                <option value="lunas">Lunas</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
<!-- END -->

<!-- MODAL BUAT TRANSAKSI KILOAN UTK KURIR-->
@foreach($pesananDaftar as $row)
<div class="modal fade" id="modalBuatTransaksiKiloan{{ $row->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Tambah Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('tambahtransaksikiloan', $row->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col mb-1">
                            <label for="nameBasic" class="form-label"><b>Nama</b></label>
                            <input type="text" name="user_id" class="form-control" value="{{ $row->user->name }}" readonly>
                            <input type="hidden" name="user_id" value="{{ $row ? $row->user->id : '' }}">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-1">
                            <label for="emailBasic" class="form-label"><b>Layanan</b></label>
                            <select id="defaultSelect" class="form-select" name="layanan_id" required oninvalid="this.setCustomValidity('Pilih Jenis Layanan Terlebih dahulu.')" oninput="this.setCustomValidity('')">
                                <option disabled selected value="">Pilih Jenis Layanan</option>
                                @foreach($layananDaftar as $row)
                                @if($row->jenis_satuan == 'kiloan')
                                <option value="{{ $row->id }}">{{ $row->jenis_layanan}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-1">
                            <label for="dobBasic" class="form-label"><b>Tanggal Ditimbang</b></label>
                            <input type="date" name="tgl_ditimbang" class="form-control" value="{{ \Carbon\Carbon::now()->toDateString() }}">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-1">
                            <label for="dobBasic" class="form-label"><b>Total Berat (dalam Kg)</b></label>
                            <input type="text" name="total_berat" class="form-control" value="{{ $weight_data ? $weight_data->weight : '' }}" readonly>
                        </div>
                    </div>
                    <div class=" row g-2">
                        <div class="col mb-1">
                            <label for="dobBasic" class="form-label"><b>Diskon</b></label>
                            <input type="number" name="diskon" class="form-control" value="0">
                        </div>
                    </div>
                    <div class=" row g-2">
                        <div class="col mb-1">
                            <label for="emailBasic" class="form-label"><b>Status</b></label>
                            <select id="defaultSelect" class="form-select" name="status_pembayaran" required oninvalid="this.setCustomValidity('Pilih Status Pembayaran Terlebih dahulu.')" oninput="this.setCustomValidity('')">
                                <option disabled selected value="">Pilih Status Pembayaran</option>
                                <option value=" belum lunas">Belum Lunas</option>
                                <option value="lunas">Lunas</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
<!-- END -->

<!-- MODAL EDIT PESANAN -->
@foreach($pesananDaftar as $key => $row)
<div class="modal fade" id="modalEditPesanan{{ $row->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Edit Pesanan No {{ $key+1 }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('editpesanan',$row->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameWithTitle" class="form-label">Tanggal Pemesanan</label>
                            <input type="date" name="tgl_pemesanan" class="form-control" value="{{ \Carbon\Carbon::parse($row->tgl_pemesanan)->format('Y-m-d') }}">
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

<!-- MODAL HAPUS PESANAN -->
@foreach($pesananDaftar as $row)
<div class="modal fade" id="modalHapusPesanan{{ $row->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Hapus Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin untuk menghapus pesanan <b>{{ $row->user->name }}</b> ?
            </div>
            <form action="{{ route('hapuspesanan',$row->id) }}" method="POST">
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