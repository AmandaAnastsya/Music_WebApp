<?php
session_start();
include 'database/connection.php';

// Pastikan hanya menerima permintaan POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['song_id'])) {
        $songId = intval($_POST['song_id']); // Pastikan song_id adalah integer
        $userId = $_SESSION['user_id'] ?? null; // Ambil user_id dari session

        // Periksa apakah user sudah login
        if (!$userId) {
            echo json_encode(["status" => "error", "message" => "Unauthorized. Please log in first."]);
            exit;
        }

        try {
            // Buat objek koneksi database
            $db = new ConnectionDatabase();
            $pdo = $db->getConnection(); // Gunakan fungsi getConnection()

            // Periksa apakah lagu sudah ada di tabel favorit
            $checkQuery = "SELECT COUNT(*) FROM favorites WHERE user_id = ? AND song_id = ?";
            $stmt = $pdo->prepare($checkQuery);
            $stmt->bind_param("ii", $userId, $songId);
            $stmt->execute();
            $stmt->bind_result($exists);
            $stmt->fetch();
            $stmt->close();

            if ($exists) {
                // Lagu sudah ada di favorit
                echo json_encode(["status" => "exists", "message" => "This song is already in your favorites."]);
            } else {
                // Tambahkan lagu ke favorit
                $insertQuery = "INSERT INTO favorites (user_id, song_id) VALUES (?, ?)";
                $stmt = $pdo->prepare($insertQuery);
                $stmt->bind_param("ii", $userId, $songId);

                if ($stmt->execute()) {
                    echo json_encode(["status" => "success", "message" => "Song added to favorites!"]);
                } else {
                    echo json_encode(["status" => "error", "message" => "Failed to add song to favorites."]);
                }

                $stmt->close();
            }
        } catch (Exception $e) {
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Song ID is missing."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
?>
