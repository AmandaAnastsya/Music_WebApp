<?php
session_start();
include '../database/connection.php'; // Pastikan jalur ini benar

$conn = new ConnectionDatabase();
$db = $conn->getConnection();

if (!isset($_SESSION['user_id'])) {
    die("User  ID tidak ditemukan, silakan login terlebih dahulu.");
}

$userId = $_SESSION['user_id'];
$password = $_POST['password'];

// Cek password pengguna
$sql = "SELECT password FROM users WHERE id=?";
$stmt = $db->prepare($sql);
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    
    // Verifikasi password menggunakan MD5
    if ($user['password'] === md5($password)) {
        // Hapus akun dan set kolom deleted_at
        $sqlDelete = "UPDATE users SET deleted_at = NOW() WHERE id=?";
        $stmtDelete = $db->prepare($sqlDelete);
        $stmtDelete->bind_param('i', $userId);
        
        if ($stmtDelete->execute()) {
            session_destroy();
            $_SESSION['success_message'] = "Akun berhasil dihapus.";
            header("Location: ../register.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Gagal menghapus akun. Silakan coba lagi.";
            header("Location: ../edit_profile.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "Password salah. Akun tidak dihapus.";
        header("Location: ../edit_profile.php"); // Kembali ke halaman edit profile
        exit();
    }
} else {
    die("Data pengguna tidak ditemukan.");
}

// Tutup statement dan koneksi
$stmt->close();
$db->close();
?>