<?php
$servername = "localhost"; // Nama server database, biasanya 'localhost'
$username = "root"; // Nama pengguna MySQL Anda
$password = ""; // Kata sandi MySQL Anda, biasanya kosong untuk instalasi default XAMPP
$dbname = "laundry_ta"; // Nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data mentah dari HTTP request body
    $rawData = file_get_contents("php://input");
    // Menguraikan data JSON menjadi array PHP
    $data = json_decode($rawData, true);

    // Memastikan data JSON berhasil diuraikan dan memiliki field 'weight'
    if (json_last_error() === JSON_ERROR_NONE && isset($data['weight'])) {
        $weight = $data['weight'];
        
        // Menghindari SQL Injection dengan menggunakan prepared statement
        $stmt = $conn->prepare("INSERT INTO weight_data (weight) VALUES (?)");
        $stmt->bind_param("d", $weight); // "d" untuk tipe data double (float)

        if ($stmt->execute() === TRUE) {
            echo json_encode(["status" => "success", "message" => "New record created successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => $stmt->error]);
        }

        $stmt->close();
    } else {
        // Menangani kesalahan JSON atau data yang tidak valid
        echo json_encode(["status" => "error", "message" => "Invalid JSON data"]);
    }
}

$conn->close();
?>
