<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tia Laundry - Tolak Pesanan</title>
</head>

<body>
    <p>Maaf, pesanan Anda atas nama {{ $user->nama }} ditolak karena {{ $pemesanan->alasan_penolakan }}</p>
</body>

</html>