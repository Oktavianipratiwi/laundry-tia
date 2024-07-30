<?php
//Koneksi ke Database:
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "laundry_ta";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Menerima dan Memproses Data POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rawData = file_get_contents("php://input");
    $data = json_decode($rawData, true);

    if (json_last_error() === JSON_ERROR_NONE && isset($data['weight'])) {
        $weight = $data['weight'];

        // Memeriksa apakah ada data penimbangan sebelumnya
        $checkStmt = $conn->prepare("SELECT id FROM weight_data LIMIT 1");
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows > 0) {

            // Data sudah ada, lakukan update
            $row = $result->fetch_assoc();
            $id = $row['id'];
            $updateStmt = $conn->prepare("UPDATE weight_data SET weight = ?, created_at = CURRENT_TIMESTAMP WHERE id = ?");
            $updateStmt->bind_param("di", $weight, $id);

            if ($updateStmt->execute() === TRUE) {
                $updateStmt->close();
                $selectStmt = $conn->prepare("SELECT weight, created_at FROM weight_data WHERE id = ?");
                $selectStmt->bind_param("i", $id);
                $selectStmt->execute();
                $result = $selectStmt->get_result();
                $updatedData = $result->fetch_assoc();
                echo json_encode([
                    "status" => "success",
                    "message" => "Record updated successfully",
                    "weight" => $updatedData['weight'],
                    "created_at" => $updatedData['created_at']
                ]);
                $selectStmt->close();
            } else {
                echo json_encode(["status" => "error", "message" => $updateStmt->error]);
                $updateStmt->close();
            }
        } else {
            // Tidak ada data, lakukan insert
            $insertStmt = $conn->prepare("INSERT INTO weight_data (weight, created_at) VALUES (?, CURRENT_TIMESTAMP)");
            $insertStmt->bind_param("d", $weight);

            if ($insertStmt->execute() === TRUE) {
                $id = $conn->insert_id;
                $insertStmt->close();
                $selectStmt = $conn->prepare("SELECT weight, created_at FROM weight_data WHERE id = ?");
                $selectStmt->bind_param("i", $id);
                $selectStmt->execute();
                $result = $selectStmt->get_result();
                $insertedData = $result->fetch_assoc();
                echo json_encode([
                    "status" => "success",
                    "message" => "New record created successfully",
                    "weight" => $insertedData['weight'],
                    "created_at" => $insertedData['created_at']
                ]);
                $selectStmt->close();
            } else {
                echo json_encode(["status" => "error", "message" => $insertStmt->error]);
                $insertStmt->close();
            }
        }

        $checkStmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid JSON data"]);
    }
}

$conn->close();
