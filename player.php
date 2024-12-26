<?php
require_once 'database/music.php'; // Memasukkan file music.php yang sudah Anda buat

$music = new Music();
$songs = $music->getAllSongs();

$songId = isset($_GET['song_id']) ? intval($_GET['song_id']) : null;
$songUrl = null;

if ($songId) {
    $songUrl = $music->playSong($songId); // Menggunakan objek $music
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Music Player</title>
    <style>
        /* CSS untuk Pemutar Musik */
        .audio-player-container {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 20px;
            z-index: 1000;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.2);
        }
        .audio-player {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .control-btn {
            background: none;
            border: none;
            color: #fff;
            font-size: 20px;
            cursor: pointer;
        }
        .progress-bar {
            flex: 1;
            margin: 0 15px;
        }
        .volume-slider {
            width: 100px;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons"></script> 
</head>
<body>

<!-- Sticky Audio Player -->
<div class="audio-player-container">
    <div class="audio-player">
        <button class="control-btn prev" onclick="playPrevious()">
            <i data-feather="arrow-left"></i>
        </button>
        <button class="control-btn play" onclick="togglePlayPause()">
            <i id="play-pause-icon" data-feather="play"></i>
        </button>
        <button class="control-btn next" onclick="playNext()">
            <i data-feather="arrow-right"></i>
        </button>
    </div>
    <div class="track-info">
        <p id="track-title">Lagu Saat Ini</p>
        <p id="track-artist">Artis Saat Ini</p>
    </div>
    <div class="progress-bar">
        <input type="range" class="progress" id="progress-bar" value="0" max="100" oninput="seekAudio(this.value)">
    </div>
    <div class="extra-controls">
        <button class="extra-btn volume">
            <i data-feather="volume"></i>
        </button>
        <input type="range" class="volume-slider" id="volume-slider" value="50" max="100" oninput="setVolume(this.value)">
    </div>
</div>

<!-- Audio Element -->
<audio id="audio" src=""></audio>

<script>
    let currentSongIndex = 0;
    const audio = document.getElementById('audio');
    const trackTitle = document.getElementById('track-title');
    const trackArtist = document.getElementById('track-artist');
    const progressBar = document.getElementById('progress-bar');
    const volumeSlider = document.getElementById('volume-slider');

    // Data lagu dari PHP ke JavaScript
    const songs = <?php echo json_encode($songs); ?>;

    function loadSong(index) {
    const song = songs[index];
    audio.src = song.file_path;
    trackTitle.textContent = song.title;
    trackArtist.textContent = song.artist_name; // Ubah dari song.artist menjadi song.artist_name
    audio.load();
    audio.play();
}

function playAudio(filePath, title, artist) {
    const index = songs.findIndex(song => song.file_path === filePath);
    if (index !== -1) {
        currentSongIndex = index;
        loadSong(currentSongIndex);
    }
}

    function togglePlayPause() {
        const playPauseIcon = document.getElementById('play-pause-icon');
        if (audio.paused) {
            audio.play();
            playPauseIcon.setAttribute('data-feather', 'pause'); // Ganti ikon jadi pause
        } else {
            audio.pause();
            playPauseIcon.setAttribute('data-feather', 'play'); // Ganti ikon jadi play
        }
        feather.replace(); // Update Feather Icons
    }

    function playNext() {
        currentSongIndex = (currentSongIndex + 1) % songs.length;
        loadSong(currentSongIndex);
    }

    function playPrevious() {
        currentSongIndex = (currentSongIndex - 1 + songs.length) % songs.length;
        loadSong(currentSongIndex);
    }

    function seekAudio(value) {
        const seekTime = (audio.duration * value) / 100;
        audio.currentTime = seekTime;
    }

    function setVolume(value) {
        audio.volume = value / 100;
    }

    audio.addEventListener('timeupdate', () => {
        const progress = (audio.currentTime / audio.duration) * 100;
        progressBar.value = progress;
    });

    // Inisialisasi Feather Icons
    feather.replace();
</script>

</body>
</html>