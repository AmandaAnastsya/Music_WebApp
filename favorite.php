<?php
// Sertakan file koneksi database dan inisialisasi session
session_start();
include 'database/connection.php';
require_once 'database/Music.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Buat objek ConnectionDatabase
$db = new ConnectionDatabase();
$conn = $db->getConnection();

// Ambil user_id dari session
$userId = $_SESSION['user_id'];

// Query untuk mengambil lagu favorit berdasarkan user_id
$sql = "SELECT f.id, f.user_id, f.song_id, s.title, s.file_path, s.image, 
        a.name AS artist_name, g.name AS genre_name
        FROM favorites f
        JOIN songs s ON f.song_id = s.id
        JOIN artist a ON s.artist_id = a.id
        JOIN genre g ON s.genre_id = g.id
        WHERE f.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

// Siapkan array untuk menampung data
$hotSongs = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $hotSongs[] = $row;
    }
} else {
    $errorMessage = "You don't have any favorite songs yet.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php include('header.php') ?>
   
</head>
<body style="background-color:rgb(0, 0, 0); color: #fff; font-family: Arial, sans-serif;">
    <?php include('navbar.php'); ?>
    <section class="hot-songs">
        <h2>Favorite Songs</h2>
        <?php if (!empty($hotSongs)): ?>
            <div class="hot-songs-grid">
                <?php foreach ($hotSongs as $song): ?>
                    <div class="song-item" onclick="playAudio('<?= htmlspecialchars($song['file_path']) ?>', 
                       '<?= htmlspecialchars($song['title']) ?>', 
                       '<?= htmlspecialchars($song['artist_name']) ?>')">
                       <img src="img/<?= htmlspecialchars($song['image']) ?>" alt="<?= htmlspecialchars($song['title']) ?>" />
                        <div class="song-info">
                            <p class="song-title"><?= htmlspecialchars($song['title']) ?></p>
                            <p class="artist-name"><?= htmlspecialchars($song['artist_name']) ?></p>
                        </div>
                        <button class="favorite-btn" onclick="deleteFavorite(<?= $song['id'] ?>, this)">
                            Delete from Favorites
                        </button>
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
                    const songItem = buttonElement.closest(".song-item");
                    songItem.remove();
                    alert("Song removed from favorites successfully!");
                } else {
                    alert("Failed to delete favorite. Please try again.");
                }
            };
            xhr.send("favoriteId=" + favoriteId);
        }

        function playAudio(filePath, title, artist) {
            // Memanggil fungsi playAudio yang ada di player.php
            if (typeof window.playAudio === 'function') {
                window.playAudio(filePath, title, artist);
            }
        }
    </script>
</body>
</html>