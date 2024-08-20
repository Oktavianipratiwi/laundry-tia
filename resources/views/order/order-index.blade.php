@extends('layouts/contentNavbarLayout')

@section('title', 'Pesanan')

@section('content')

@if(session('successful'))
<div class="alert alert-success alert-dismissible" role="alert">
    {{ session('successful') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif


@if(session('infosatuan'))
<div class="alert alert-info alert-dismissible fade show" role="alert">
    <h4 class="alert-heading">Rekap Terbaru</h4>
    <p>Layanan: {{ session('infosatuan')['layanan'] }}</p>
    <p>Jumlah: {{ session('infosatuan')['jumlah'] }} Pcs</p>
    <p>Harga: Rp{{ number_format(session('infosatuan')['harga'], 0, ',', '.') }}</p>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card">
    @if(auth()->user()->role == 'kurir' || auth()->user()->role == 'admin')
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
        @if(auth()->user()->role == 'kurir')
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pelanggan</th>
                    <th>Tanggal dan Jam Jemput</th>
                    <th>Tanggal dan Jam Antar</th>
                    <th>Alamat</th>
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
                    @if($row->tgl_penjemputan == null)
                    <td><b>Belum diatur</b></td>
                    @else
                    <td>{{ \Carbon\Carbon::parse($row->tgl_penjemputan)->translatedFormat('l, j F Y') }} - {{ \Carbon\Carbon::parse($row->jam_jemput)->format('H:i') }} WIB</td>
                    @endif
                    @if($row->tgl_pengantaran == null)
                    <td><b>Belum diatur</b></td>
                    @else
                    <td>{{ \Carbon\Carbon::parse($row->tgl_pengantaran)->translatedFormat('l, j F Y') }} - {{ \Carbon\Carbon::parse($row->jam_antar)->format('H:i') }} WIB</td>
                    @endif
                    <td>{{ $row->alamat }}</td>
                    <td>
                        @if($row->status_pemesanan == 'pesanan sedang diproses')
                        <span class="badge bg-label-success me-1">Pesanan sedang diproses</span>
                        @elseif($row->status_pemesanan == 'pesanan belum diproses')
                        <span class="badge bg-label-warning me-1">Pesanan belum diproses</span>
                        @elseif($row->status_pemesanan == 'kurir jemput pesanan')
                        <span class="badge bg-label-info me-1">kurir jemput pesanan</span>
                        @elseif($row->status_pemesanan == 'kurir antar pesanan')
                        <span class="badge bg-label-info me-1">kurir antar pesanan</span>
                        @elseif($row->status_pemesanan == 'pesanan selesai')
                        <span class="badge bg-label-primary me-1">Pesanan selesai</span>
                        @elseif($row->status_pemesanan == 'pesanan ditolak')
                        <span class="badge bg-label-danger me-1">Pesanan Ditolak</span>
                        @endif
                    </td>
                    @if(auth()->user()->role == 'kurir')
                    <td>
                        @if($row->status_pemesanan == 'pesanan belum diproses')
                        <form action="{{ route('konfirmasipesananjemput', $row->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary">
                                <span class="tf-icons bx bx-pie-chart-alt me-1"></span>Jemput Pesanan
                            </button>
                        </form> 
                        @elseif($row->status_pemesanan == 'kurir jemput pesanan')
                            @if($row->layanan->jenis_satuan == 'satuan')
                            <button type="button" data-bs-toggle="modal" data-bs-target="#modalBuatTransaksiSatuan{{ $row->id }}" class=" btn btn-outline-primary">
                                <span class="tf-icons bx bx-pie-chart-alt me-1"></span>Buat Transaksi
                            </button>
                            @elseif($row->layanan->jenis_satuan == 'kiloan')
                            <form action="{{ route('order-kiloan', $row->id) }}" method="GET">
                                <button type="submit" class=" btn btn-outline-primary">
                                    <span class="tf-icons bx bx-pie-chart-alt me-1"></span>Buat Transaksi
                                </button>
                            </form>
                            @endif
                        @elseif($row->status_pemesanan == 'pesanan sedang diproses')
                        <form action="{{ route('konfirmasipesananantar', $row->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary">
                                <span class="tf-icons bx bx-pie-chart-alt me-1"></span>Antar Pesanan
                            </button>
                        </form>
                        @elseif($row->status_pemesanan == 'kurir antar pesanan')
                        <form action="{{ route('pesananselesai', $row->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary">
                                <span class="tf-icons bx bx-pie-chart-alt me-1"></span>Pesanan Selesai
                            </button>
                        </form>
                        @elseif($row->status_pemesanan == 'pesanan selesai')
                        <button type="submit" class="btn btn-primary">
                             Selesai
                        </button>
                        @elseif($row->status_pemesanan == 'pesanan ditolak')
                        <button type="submit" class="btn btn-danger">
                             Ditolak
                        </button>
                        @endif
                    </td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                            <div class="dropdown-menu">
                                @if($row->status_pemesanan == 'pesanan belum diproses')
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalTolakPesanan{{ $row->id }}">
                                    <i class='bx bxs-no-entry me-1'></i> Tolak Pesanan
                                </a>
                                @endif
                                @if($row->status_pemesanan != 'pesanan ditolak')
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalKonfirmasiWhatsApp{{ $row->id }}">
                                    <i class="bx bxl-whatsapp me-1"></i> Konfirmasi via WhatsApp
                                </a>
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalEditPesanan{{ $row->id }}">
                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                </a>
                                @endif
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalHapusPesanan{{ $row->id }}">
                                    <i class="bx bx-trash me-1"></i> Delete
                                </a>
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
                        @if($row->status_pemesanan == 'pesanan sedang diproses')
                        <span class="badge bg-label-success me-1">Pesanan sedang diproses</span>
                        @elseif($row->status_pemesanan == 'pesanan belum diproses')
                        <span class="badge bg-label-warning me-1">Pesanan belum diproses</span>
                        @elseif($row->status_pemesanan == 'kurir jemput pesanan')
                        <span class="badge bg-label-info me-1">kurir jemput pesanan</span>
                        @elseif($row->status_pemesanan == 'kurir antar pesanan')
                        <span class="badge bg-label-info me-1">kurir antar pesanan</span>
                        @elseif($row->status_pemesanan == 'pesanan selesai')
                        <span class="badge bg-label-primary me-1">Pesanan Selesai</span>
                        @elseif($row->status_pemesanan == 'pesanan ditolak')
                        <span class="badge bg-label-danger me-1">Pesanan Ditolak - {{ $row->alasan_penolakan }}</span> 
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
                    <input type="hidden" name="tgl_pemesanan" class="form-control" value="{{ \Carbon\Carbon::now()->toDateString() }}" readonly>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="dobBasic" class="form-label"><b>Tanggal Dijemput Kurir</b></label>
                            <input type="date" name="tgl_penjemputan" class="form-control" value="{{ \Carbon\Carbon::now()->toDateString() }}" required>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="dobBasic" class="form-label"><b>Jam Jemput Kurir</b></label>
                            <input type="time" name="jam_jemput" class="form-control" value="{{ \Carbon\Carbon::now()->format('H:i') }}" required>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="dobBasic" class="form-label"><b>Layanan</b></label>
                            <select name="id_layanan" class="form-select" required>
                                @foreach ($layananDaftar as $layanan )
                                <option value="{{ $layanan->id }}">{{ $layanan->jenis_layanan }} - {{ $layanan->jenis_satuan }} - Rp{{ number_format($layanan->harga, 0, ',', '.') }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="alamat" class="form-control" value="{{ auth()->user()->alamat }}">
                    <input type="hidden" name="no_telp" class="form-control" value="{{ auth()->user()->no_telp }}">
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

<!-- MODAL BUAT TRANSAKSI SATUAN UTK KURIR-->
@foreach($pesananDaftar as $row)
<div class=" modal fade" id="modalBuatTransaksiSatuan{{ $row->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Tambah Transaksi Satuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('tambahtransaksisatuan', $row->id) }}" method="POST" enctype="multipart/form-data">
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
                            <label for="defaultSelect" class="form-label"><b>Layanan : Satuan</b></label>
                            <input type="text" name="layanan_id" class="form-control" value="{{ $row->layanan->jenis_layanan }}" readonly>
                            <input type="hidden" name="layanan_id" value="{{ $row ? $row->layanan->id : '' }}">
                        </div>
                    </div>
                    <input type="hidden" name="tgl_ditimbang" class="form-control" value="{{ \Carbon\Carbon::now()->toDateString() }}">
                    <div class="row g-2">
                        <div class="col mb-1">
                            <label for="dobBasic" class="form-label"><b>Jumlah Helai Satuan</b></label>
                            <input type="number" name="jumlah" class="form-control" placeholder="Masukkan Jumlah Helai Satuan." required>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-1">
                            <label for="dobBasic" class="form-label"><b>Foto Pakaian</b></label>
                            <input type="file" name="foto_pakaian" class="form-control" accept="image/*" capture="environment" required>
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
                <h5 class="modal-title" id="modalCenterTitle">Edit Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('editpesanan',$row->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameWithTitle" class="form-label"><b>Tanggal Penjemputan</b></label>
                            @if($row->tgl_penjemputan == null)
                            <input type="text" class="form-control" value="Maaf, tanggal penjemputan belum ditentukan." readonly>
                            @else
                            <input type="date" name="tgl_penjemputan" class="form-control" value="{{ \Carbon\Carbon::parse($row->tgl_penjemputan)->format('Y-m-d') }}">
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameWithTitle" class="form-label"><b>Jam Jemput</b></label>
                            @if($row->jam_jemput == '00:00:00')
                            <input type="text" class="form-control" value="Maaf, jam jemput belum ditentukan." readonly>
                            @else
                            <input type="time" name="jam_jemput" class="form-control" value="{{ \Carbon\Carbon::parse($row->jam_jemput)->format('H:i') }}">
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameWithTitle" class="form-label"><b>Tanggal Pengantaran</b></label>
                            @if($row->tgl_pengantaran == null)
                            <input type="text" class="form-control" value="Maaf, tanggal pengantaran belum ditentukan." readonly>
                            @else
                            <input type="date" name="tgl_pengantaran" class="form-control" value="{{ \Carbon\Carbon::parse($row->tgl_pengantaran)->format('Y-m-d') }}">
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameWithTitle" class="form-label"><b>Jam Antar</b></label>
                            @if($row->jam_antar == '00:00:00')
                            <input type="text" class="form-control" value="Maaf, jam antar belum ditentukan." readonly>
                            @else
                            <input type="time" name="jam_antar" class="form-control" value="{{ \Carbon\Carbon::parse($row->jam_antar)->format('H:i') }}">
                            @endif
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
<!-- END -->

<!-- MODAL KONFIRMASI WHATSAPP UNTUK KURIR KE PELANGGAN -->
@foreach($pesananDaftar as $row)
<div class="modal fade" id="modalKonfirmasiWhatsApp{{ $row->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi via WhatsApp</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin mengirim pesan konfirmasi ke pelanggan via WhatsApp?</p>
            </div>
            <form action="{{ route('konfirmasiwhatsapp',$row->id) }}" target="_blank" method="POST">
                @csrf
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Ya, Konfirmasi</button>
            </form>
            </div>
        </div>
    </div>
</div>
@endforeach
<!-- END FOREACH -->

<!-- MODAL TOLAK PESANAN -->
@foreach($pesananDaftar as $row)
<div class="modal fade" id="modalTolakPesanan{{ $row->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Tolak Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('konfirmasipesananditolak',$row->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameWithTitle" class="form-label"><b>Alasan Penolakan</b></label>
                                <textarea class="form-control" name="alasan_penolakan" placeholder="Masukkan alasan penolakan." required></textarea>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
<!-- END -->

@endsection