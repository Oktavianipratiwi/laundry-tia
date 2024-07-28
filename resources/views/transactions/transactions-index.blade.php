@extends('layouts/contentNavbarLayout')

@section('title', 'Transaksi')

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card">
    @if(auth()->user()->role != 'pelanggan')
    <h5 class="card-header">Daftar Transaksi Kiloan</h5>
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Layanan</th>
                    <th>Total Berat</th>
                    <th>Total Bayar</th>
                    <th>Status Pembayaran</th>
                    <th>Pengantaran</th>
                    <th>Bukti</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @php $no = 1; @endphp
                @if($transaksiDaftar->sum('total_berat') == 0)
                <td style="font-weight:bold; text-align:center;" colspan="8">Transaksi Belum Ada</td>
                @endif
                @foreach($transaksiDaftar as $key => $row)
                @if($row->total_berat != null)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $row->user->name }}</td>
                    <td>{{ $row->layanan->jenis_layanan }}</td>
                    <td>{{ $row->total_berat }} Kg</td>
                    <td>Rp{{ number_format($row->total_bayar, 0, ',', '.') }}</td>
                    @if($row->status_pembayaran == 'lunas' && $row->bukti_pembayaran != null)
                    <td><span class="badge bg-label-success me-1">Lunas via transfer</span></td>
                    @elseif($row->status_pembayaran == 'lunas')
                    <td><span class="badge bg-label-success me-1">Lunas via cash</span></td>
                    @elseif($row->status_pembayaran == 'belum lunas')
                    <td><span class="badge bg-label-warning me-1">Belum Lunas</span></td>
                    @elseif($row->pemesanan->status_pemesanan == 'sudah diperiksa')
                    <td><span class="badge bg-label-warning me-1">Lunas - Sudah Diperiksa</span></td>
                    @endif
                    @if($row->status_pengantaran == 'belum diantar')
                    <td><span class="badge bg-label-danger me-1">Belum diantar</span></td>
                    @elseif($row->status_pengantaran == 'sudah diantar')
                    <td><span class="badge bg-label-success me-1">sudah diantar</span></td>
                    @endif
                    @if($row->bukti_pembayaran != null)
                    <td><b><a href="{{ asset($row->bukti_pembayaran) }}" target="_blank">Lihat Bukti</a></b></td>
                    @else
                    <td>Tidak Ada</td>
                    @endif
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                            <div class="dropdown-menu">
                                @if($row->status_pembayaran == 'lunas')
                                <a class="dropdown-item" href="{{ route('detailtransaksi', $row->id) }}"><i class=" bx bx-detail me-1"></i> Detail</a>
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalHapusTransaksi{{ $row->id }}"><i class=" bx bx-trash me-1"></i> Delete</a>
                                @else
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalKonfirmasiTransaksi{{ $row->id }}"><i class=" bx bx-check me-1"></i> Konfirmasi</a>
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalHapusTransaksi{{ $row->id }}"><i class=" bx bx-trash me-1"></i> Delete</a>
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>

        <hr class="my-2">
        <h5 class="card-header">Daftar Transaksi Satuan</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Layanan</th>
                        <th>Jumlah</th>
                        <th>Total Bayar</th>
                        <th>Status Pembayaran</th>
                        <th>Pengantaran</th>
                        <th>Bukti</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @php $no = 1; @endphp <!-- Initialize counter -->
                    @if($transaksiDaftar->sum('jumlah') == 0)
                    <td style="font-weight:bold; text-align:center;" colspan="8">Transaksi Belum Ada</td>
                    @endif
                    @foreach($transaksiDaftar as $key => $row)
                    @if($row->jumlah != null)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $row->user->name }}</td>
                        <td>{{ $row->layanan->jenis_layanan }}</td>
                        <td>{{ $row->jumlah }}</td>
                        <td>Rp{{ number_format($row->total_bayar, 0, ',', '.') }}</td>
                        @if($row->status_pembayaran == 'lunas')
                        <td><span class="badge bg-label-success me-1">Lunas</span></td>
                        @elseif($row->status_pembayaran == 'belum lunas')
                        <td><span class="badge bg-label-warning me-1">Belum Lunas</span></td>
                        @elseif($row->pemesanan->status_pemesanan == 'sudah diperiksa')
                        <td><span class="badge bg-label-warning me-1">Lunas - Sudah Diperiksa</span></td>
                        @endif
                        @if($row->status_pengantaran == 'belum diantar')
                        <td><span class="badge bg-label-danger me-1">Belum diantar</span></td>
                        @elseif($row->status_pengantaran == 'sudah diantar')
                        <td><span class="badge bg-label-success me-1">sudah diantar</span></td>
                        @endif
                        @if($row->bukti_pembayaran != null)
                        <td><b><a href="{{ asset($row->bukti_pembayaran) }}" target="_blank">Lihat Bukti</a></b></td>
                        @else
                        <td>Tidak Ada</td>
                        @endif
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                                <div class="dropdown-menu">
                                    @if($row->status_pembayaran == 'lunas')
                                    <a class="dropdown-item" href="{{ route('detailtransaksi', $row->id) }}"><i class=" bx bx-detail me-1"></i> Detail</a>
                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalHapusTransaksi{{ $row->id }}"><i class=" bx bx-trash me-1"></i> Delete</a>
                                    @else
                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalKonfirmasiTransaksi{{ $row->id }}"><i class=" bx bx-check me-1"></i> Konfirmasi</a>
                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalHapusTransaksi{{ $row->id }}"><i class=" bx bx-trash me-1"></i> Delete</a>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>

            <!-- untuk pelanggan saja -->
            @else
            <h5 class="card-header">Daftar Transaksi Saya</h5>
            <div class="table-responsive text-nowrap">

                <table class="table">
                    <thead>
                        <tr>
                            <th>Tanggal Ditimbang</th>
                            <th>Total Bayar</th>
                            <th>Status Pembayaran</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @if($transaksiDaftar->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center"><b>Transaksi belum ada</b></td>
                        </tr>
                        @endif
                        @foreach($transaksiDaftar as $key => $row)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($row->tgl_ditimbang)->translatedFormat('j F Y') }}</td>
                            <td>Rp{{ number_format($row->total_bayar, 0, ',', '.') }}</td>
                            @if($row->status_pembayaran == 'lunas')
                            <td><span class="badge bg-label-success me-1">Lunas</span></td>
                            @elseif($row->status_pembayaran == 'belum lunas')
                            <td><span class="badge bg-label-warning me-1">Belum Lunas</span></td>
                            @endif
                            <td>
                                <form action="{{ route('detailtransaksi', $row->id) }}" method="GET">
                                    <button type="submit" class="btn btn-primary">Detail
                                    </button>
                                </form>
                            </td>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>

        <!-- MODAL KONFIRMASI TRANSAKSI UNTUK ADMIN DAN KURIR -->
        @foreach($transaksiDaftar as $key => $row)
        <div class="modal fade" id="modalKonfirmasiTransaksi{{ $row->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Konfirmasi Transaksi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin untuk konfirmasi transaksi atas nama <b>{{ $row->user->name }} pada nomor {{ $key+1 }}</b> ?
                    </div>
                    <form action="{{ route('konfirmasitransaksi',$row->id) }}" method="POST">
                        @csrf
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Ya</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach

        <!-- END -->

        <!-- MODAL HAPUS TRANSAKSI UNTUK ADMIN DAN KURIR -->
        @foreach($transaksiDaftar as $row)
        <div class="modal fade" id="modalHapusTransaksi{{ $row->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Hapus Transaksi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin untuk menghapus transaksi atas nama <b>{{ $row->user->name }} pada nomor {{ $key+1 }}</b> ?
                    </div>
                    <form action="{{ route('hapustransaksi',$row->id) }}" method="POST">
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