<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tia Laundry - Faktur Elektronik</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
        }

        .header,
        .footer {
            text-align: center;
            margin-bottom: 20px;
        }

        .details,
        .terms {
            margin-bottom: 20px;
        }

        .details strong {
            display: block;
            margin-top: 10px;
        }

        .terms p {
            margin: 5px 0;
        }

        .terms ol {
            padding-left: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>FAKTUR ELEKTRONIK TRANSAKSI REGULER</h1>
            <p>TIA LAUNDRY</p>
            <p>Perumahan Taruko Permai IV Blk. A No.13, Bungo Pasang, Kec. Koto Tangah, Kota Padang, Sumatera Barat 25586</p>
            <p>085355340303</p>
        </div>

        <div class="details">
            <p>Pelanggan Yth:</p>
            <p><strong>{{ $name }}</strong></p>
            <p>Tgl Jemput: {{ \Carbon\Carbon::parse($pemesanan->tgl_penjemputan)->translatedFormat('l, j F Y') }} - {{ \Carbon\Carbon::parse($pemesanan->jam_jemput)->format('H:i') }} WIB</p>
            <p>Tgl Antar: {{ \Carbon\Carbon::parse($pemesanan->tgl_pengantaran)->translatedFormat('l, j F Y') }} - {{ \Carbon\Carbon::parse($pemesanan->jam_antar)->format('H:i') }} WIB</p>
        </div>

        <div class="order-details">
            <p><strong>Detail pesanan:</strong></p>
            <p>Layanan:</p>
            @if($total_berat != null)
            <ul>
                <li>✅ {{ $layanan->jenis_layanan }}, {{ $total_berat }} Kg, kiloan</li>
                <li>✅ {{ $transaksi->helai_pakaian }} Pcs Helai </li>
            </ul>
            @elseif($jumlah != null)
            <ul>
                <li>✅ {{ $layanan->jenis_layanan }}, satuan </li>
                <li>✅ {{ $jumlah }} Pcs</li>
            </ul>
            @endif
        </div>

        <div class="cost-details">
            <p><strong>Detail biaya:</strong></p>
            <p>Total tagihan: Rp{{ number_format($total_bayar, 0, ',', '.') }}</p>
            <p>Grand total: Rp{{ number_format($total_bayar, 0, ',', '.') }}</p>
        </div>

        <div class="payment-details">
            <p><strong>Pembayaran:</strong></p>
            <p>Status: {{ $status_pembayaran }}</p>
        </div>

        <div class="terms">
            <p><strong>Syarat dan ketentuan:</strong></p>
            <p>PERHATIAN:</p>
            <ol>
                <li>Pengambilan barang harap disertai nota</li>
                <li>Barang yang tidak diambil selama 1 bulan, hilang / rusak tidak diganti</li>
                <li>Klaim luntur tidak dipisah diluar tanggungan</li>
                <li>Hak klaim berlaku 2 jam setelah barang diambil</li>
                <li>Setiap konsumen dianggap setuju dengan isi perhitungan tersebut diatas</li>
            </ol>
        </div>

        <div class="footer">
            <p>Terima kasih</p>
        </div>
    </div>
</body>

</html>