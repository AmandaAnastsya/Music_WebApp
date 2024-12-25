<?php
session_start();
include '../database/connection.php'; // Pastikan jalur ini benar

$conn = new ConnectionDatabase();
$db = $conn->getConnection();

// Pastikan user_id ada di session
if (!isset($_SESSION['user_id'])) {
    die("User ID tidak ditemukan, silakan login terlebih dahulu.");
}

$userId = $_SESSION['user_id'];

// Ambil nilai dari form
$name = isset($_POST['name']) && !empty($_POST['name']) ? $_POST['name'] : null;
$birthdate = isset($_POST['birthdate']) && !empty($_POST['birthdate']) ? $_POST['birthdate'] : null;
$gender = isset($_POST['gender']) && $_POST['gender'] !== '---' ? $_POST['gender'] : null;

// Proses upload foto
$profile_picture = null;
if (isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["error"] == UPLOAD_ERR_OK) {
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
    if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
        $profile_picture = $target_file;
    } else {
        die("Error: Gagal meng-upload file.");
    }
}

// Buat query dinamis
$fields = [];
$params = [];
$types = "";

// Tambahkan kolom yang ingin di-update
if ($name !== null) {
    $fields[] = "name=?";
    $params[] = $name;
    $types .= "s";
}
if ($birthdate !== null) {
    $fields[] = "birthdate=?";
    $params[] = $birthdate;
    $types .= "s";
}
if ($gender !== null) {
    $fields[] = "gender=?";
    $params[] = $gender;
    $types .= "s";
}
if ($profile_picture !== null) {
    $fields[] = "profile_picture=?";
    $params[] = $profile_picture;
    $types .= "s";
}

// Jika tidak ada kolom yang diubah, hentikan proses
if (empty($fields)) {
    $_SESSION['error_message'] = "Tidak ada perubahan data.";
    header("Location: ../edit_profile.php");
    exit();
}

// Tambahkan user ID ke parameter
$params[] = $userId;
$types .= "i";

// Susun query
$sql = "UPDATE users SET " . implode(", ", $fields) . " WHERE id=?";
$stmt = $db->prepare($sql);
$stmt->bind_param($types, ...$params);

// Eksekusi query
if ($stmt->execute()) {
    $_SESSION['success_message'] = "Data berhasil diperbarui.";
    header("Location: ../edit_profile.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

// Tutup statement dan koneksi
$stmt->close();
$db->close();
?>
