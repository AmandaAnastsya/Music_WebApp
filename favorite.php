<?php
// Sertakan file koneksi database dan inisialisasi session
session_start();
include 'database/connection.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Buat objek ConnectionDatabase
$db = new ConnectionDatabase();

// Ambil koneksi menggunakan metode getConnection()
$conn = $db->getConnection();

// Ambil user_id dari session
$userId = $_SESSION['user_id'];

// Query untuk mengambil lagu favorit berdasarkan user_id
$sql = "SELECT f.id, f.user_id, f.song_id, s.title AS song_name, s.artist, s.file_path, s.image, s.genre
        FROM favorites f
        JOIN songs s ON f.song_id = s.id
        WHERE f.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId); // Bind parameter user_id
$stmt->execute();
$result = $stmt->get_result();

// Siapkan array untuk menampung data
$hotSongs = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $hotSongs[] = $row; // Tambahkan setiap data lagu ke dalam array
    }
} else {
    $errorMessage = "You don't have any favorite songs yet.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorite Songs</title>
    <style>
        /* Gaya CSS untuk tampilan */
        .hot-songs { padding: 25px; }
        .hot-songs h2 { font-size: 24px; margin-bottom: 20px; color: #fff; text-align: center; }
        .hot-songs-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; }
        .song-item { display: flex; flex-direction: column; align-items: center; background-color: #333; padding: 15px; border-radius: 10px; text-align: center; }
        .song-item img { width: 100px; height: 100px; border-radius: 10px; margin-bottom: 10px; object-fit: cover; }
        .song-info { width: 100%; margin-bottom: 10px; }
        .song-info .song-title, .song-info .artist-name, .song-info .genre { color: #fff; }
        .favorite-btn { padding: 8px 12px; background-color: #e8413f; color: #fff; border: none; border-radius: 5px; cursor: pointer; }
        @media (max-width: 900px) { .hot-songs-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 600px) { .hot-songs-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body style="background-color:rgb(0, 0, 0); color: #fff; font-family: Arial, sans-serif;">
    <?php include('navbar.php'); ?>
    <section class="hot-songs">
        <h2>Favorite Songs</h2>
        <?php if (!empty($hotSongs)): ?>
            <div class="hot-songs-grid">
                <?php foreach ($hotSongs as $song): ?>
                    <div class="song-item">
                        <img src="img/<?= htmlspecialchars($song['image']) ?>" alt="<?= htmlspecialchars($song['song_name']) ?>" />
                        <div class="song-info">
                            <p class="song-title"><?= htmlspecialchars($song['song_name']) ?></p>
                            <p class="artist-name"><?= htmlspecialchars($song['artist']) ?></p>
                            <p class="genre"><?= htmlspecialchars($song['genre']) ?></p>
                        </div>
                        <!-- Tombol delete favorite -->
                        <button class="favorite-btn" onclick="deleteFavorite(<?= $song['id'] ?>, this)">Delete from Favorites</button>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p><?= htmlspecialchars($errorMessage) ?></p>
        <?php endif; ?>
    </section>  
    <?php include('player.php'); ?>
    <script>
        function deleteFavorite(favoriteId, buttonElement) {
            if (!confirm("Are you sure you want to delete this favorite?")) return;

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "controller/delete_favorite.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function () {
                if (xhr.status === 200) {
                    alert(xhr.responseText);
                    const songItem = buttonElement.closest(".song-item");
                    songItem.remove();
                } else {
                    alert("Failed to delete favorite. Please try again.");
                }
            };
            xhr.send("favoriteId=" + favoriteId);
        }
    </script>
</body>
</html>
