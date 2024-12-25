<?php
// Mengimpor model Music.php untuk akses database
include('../database/Music.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_favorite'])) {
        // Menambahkan lagu ke favorit
        $songId = $_POST['song_id'];
        $music = new Music();
        if ($music->addToFavorites($songId)) {
            echo "Lagu berhasil ditambahkan ke favorit!";
        } else {
            echo "Terjadi kesalahan saat menambahkan lagu ke favorit.";
        }
    }

    if (isset($_POST['remove_favorite'])) {
        // Menghapus lagu dari favorit
        $songId = $_POST['song_id'];
        $music = new Music();
        if ($music->removeFromFavorites($songId)) {
            echo "Lagu berhasil dihapus dari favorit.";
        } else {
            echo "Terjadi kesalahan saat menghapus lagu dari favorit.";
        }
    }

    if (isset($_POST['delete_song'])) {
        // Menghapus lagu dari database
        $songId = $_POST['song_id'];
        $music = new Music();
        if ($music->deleteSong($songId)) {
            echo "Lagu berhasil dihapus dari database.";
        } else {
            echo "Terjadi kesalahan saat menghapus lagu dari database.";
        }
    }
} else {
    echo "Aksi tidak valid!";
}
?>
