<?php
// Memanggil Music.php untuk mengakses kelas Music
require_once 'database/Music.php';

// Membuat instance dari kelas Music
$data = new Music();

// Mengambil data lagu (semua lagu)
$allSongs = $data->getAllSongs(); 
?>

<!-- Explore Section -->
<div class="container explore">
    <h2 class="section-title">Explore</h2>
    <div class="playlist">
        <?php foreach ($allSongs as $song): ?>
            <div class="playlist-item" onclick="playAudio('<?= htmlspecialchars($song['file_path']) ?>', 
                       '<?= htmlspecialchars($song['title']) ?>', 
                       '<?= htmlspecialchars($song['artist_name']) ?>')">
                       <img src="img/<?= htmlspecialchars($song['image']) ?>" alt="<?= htmlspecialchars($song['title']) ?>" />
                        <div class="song-info">
                            <p class="song-title"><?= htmlspecialchars($song['title']) ?></p>
                            <p class="artist-name"><?= htmlspecialchars($song['artist_name']) ?></p>
                        </div>
                        <button class="favorite-btn" onclick="event.stopPropagation(); addFavorite(<?= $song['id'] ?>)">
                            Add to Favorites
                        </button>
                    </div>
        <?php endforeach; ?>
        
    </div>
</div>

<script>
function addFavorite(songId) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "add_favorite.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Menggunakan onreadystatechange untuk memantau status request
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {  // Jika request sudah selesai
            if (xhr.status == 200) {  // Jika status HTTP adalah OK (200)
                console.log(xhr.responseText); // Menampilkan respons dari server di konsol
                alert("Song added to favorites!");
            } else {
                console.error("Error: " + xhr.status); // Menampilkan error jika status bukan 200
            }
        }
    };

    // Mengirim data song_id ke server
    xhr.send("song_id=" + songId);
}
</script>

