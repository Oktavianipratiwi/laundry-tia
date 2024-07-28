<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tia Laundry - Kurir Sedang Menuju Lokasi untuk Penjemputan Pakaian</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2 style="color: #4a4a4a;">Hai {{ $name }},</h2>

        <p>Kami ingin memberitahu bahwa kurir kami sedang dalam perjalanan menuju lokasi Anda penjemputan pakaian. Mohon untuk tetap berada di lokasi pengambilan.</p>

        <h3 style="color: #4a4a4a;">Informasi Kurir:</h3>
        <ul style="list-style-type: none; padding-left: 0;">
            <li><strong>Nama Kurir:</strong> {{ $kurirName }}</li>
            <li><strong>Nomor Telepon Kurir:</strong> {{ $kurirPhone }}</li>
        </ul>

        <p>Jika Anda memiliki pertanyaan atau ada perubahan mendadak, silakan hubungi kurir langsung melalui nomor telepon yang tertera di atas.</p>

        <p>Terima kasih telah menggunakan layanan Tia Laundry. Kami berharap dapat terus memberikan pelayanan terbaik untuk Anda.</p>

        <p style="font-style: italic; margin-top: 20px;">Salam hangat,<br>Tim Tia Laundry</p>
    </div>
</body>

</html>