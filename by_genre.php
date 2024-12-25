<?php
require_once 'database/Music.php';
$data = new Music();
$genres = $data->getAllGenres();

// Jika genre dipilih, ambil lagu-lagu dalam genre tersebut
$selectedGenre = isset($_GET['genre']) ? $_GET['genre'] : null;
$songsByGenre = $selectedGenre ? $data->getSongsByGenre($selectedGenre) : [];
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
                <a href="?genre=<?= urlencode($genre) ?>" 
                   class="genre-btn <?= ($selectedGenre === $genre) ? 'active' : '' ?>">
                    <?= htmlspecialchars($genre) ?>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Songs Grid -->
        <?php if ($selectedGenre): ?>
            <h3>Songs in <?= htmlspecialchars($selectedGenre) ?></h3>
            <div class="hot-songs-grid">
                <?php foreach ($songsByGenre as $song): ?>
                    <div class="song-item" onclick="playAudio('<?= htmlspecialchars($song['file_path']) ?>', '<?= htmlspecialchars($song['title']) ?>', '<?= htmlspecialchars($song['artist']) ?>')">
                        <img src="img/<?= htmlspecialchars($song['image']) ?>" alt="<?= htmlspecialchars($song['title']) ?>" />
                        <div class="song-info">
                            <p class="song-title"><?= htmlspecialchars($song['title']) ?></p>
                            <p class="artist-name"><?= htmlspecialchars($song['artist']) ?></p>
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
    </script>
</body>
</html>