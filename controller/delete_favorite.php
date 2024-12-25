<?php
// Sertakan file koneksi database
include '../database/connection.php'; // Pastikan jalur ini benar

// Periksa apakah ID lagu favorit dikirim melalui POST
if (isset($_POST['favoriteId'])) {
    $favoriteId = intval($_POST['favoriteId']);

    // Buat objek ConnectionDatabase
    $db = new ConnectionDatabase();

    // Ambil koneksi menggunakan metode getConnection()
    $conn = $db->getConnection();

    // Query untuk menghapus lagu favorit berdasarkan ID
    $sql = "DELETE FROM favorites WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $favoriteId);

    if ($stmt->execute()) {
        echo "Favorite song deleted successfully.";
    } else {
        echo "Failed to delete favorite song.";
    }

    // Tutup koneksi
    $stmt->close();
    $db->closeConnection();
} else {
    echo "Invalid request.";
}
?>
