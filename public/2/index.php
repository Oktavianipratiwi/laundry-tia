<!DOCTYPE html>
<html>
<head>
    <title>Data Berat</title>
</head>
<body>
    <h1>Data Berat</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Berat (kg)</th>
            <th>Tanggal</th>
        </tr>
        <?php
        $servername = "localhost";
        $username = "root"; // Nama pengguna MySQL Anda
        $password = ""; // Kata sandi MySQL Anda, biasanya kosong untuk instalasi default XAMPP
        $dbname = "laundry_ta"; // Nama database Anda

        // Membuat koneksi
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Memeriksa koneksi
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT id, weight, created_at FROM weight_data";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["id"]. "</td><td>" . $row["weight"]. "</td><td>" . $row["created_at"]. "</td></tr>";
            }
        } else {
            echo "0 results";
        }

        $conn->close();
        ?>
    </table>
</body>
</html>
