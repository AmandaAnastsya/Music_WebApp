<?php
// Mengambil data genre dan lagu berdasarkan genre
require_once 'database/Music.php';
$data = new Music();
$genres = $data->getAllGenres();

// Jika genre dipilih, ambil lagu-lagu dalam genre tersebut
$selectedGenreId = isset($_GET['genre']) ? $_GET['genre'] : null;
$songsByGenre = $selectedGenreId ? $data->getSongsByGenre($selectedGenreId) : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music by Genre</title>
    <link rel="stylesheet" href="style.css" />
     <style>
        .genre-container {
            padding: 20px;
        }
        .genre-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }
        .genre-btn {
            padding: 8px 16px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .genre-btn:hover {
            background-color: #555;
        }
        .genre-btn.active {
            background-color: #1DB954;
        }
    </style> 
</head>
<body>
    <section class="genre-container">
        <h2>Browse by Genre</h2>
        
        <!-- Genre Buttons -->
        <div class="genre-buttons">
            <?php foreach ($genres as $genre): ?>
                <a href="?genre=<?= urlencode($genre['id']) ?>" 
                   class="genre-btn <?= ($selectedGenreId === (int)$genre['id']) ? 'active' : '' ?>">
                    <?= htmlspecialchars($genre['genre_name']) ?>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Songs Grid -->
        <?php if ($selectedGenreId): ?>
            <h3>Songs in <?= htmlspecialchars($genres[array_search($selectedGenreId, array_column($genres, 'id'))]['genre_name']) ?></h3>
            <div class="hot-songs-grid">
                <?php foreach ($songsByGenre as $song): ?>
                    <div class="song-item" onclick="playAudio('<?= htmlspecialchars($song['file_path']) ?>', 
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
        <?php else: ?>
            <p>Please select a genre to see songs.</p>
        <?php endif; ?>
    </section>

    <script>
    function addFavorite(songId) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "add_favorite.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    console.log(xhr.responseText);
                    alert("Song added to favorites!");
                } else {
                    console.error("Error: " + xhr.status);
                }
            }
        };
        xhr.send("song_id=" + songId);
    }

    function playAudio(audioUrl, title, artist) {
        alert("Now playing: " + title + " by " + artist + "\nURL: " + audioUrl);
        // Integrasikan player audio di sini jika diinginkan
    }
    </script>
</body>
</html>
