<?php
class Music {
    private $conn;

    public function __construct() {
        require_once 'connection.php'; // Pastikan path file benar
        $db = new ConnectionDatabase();
        $this->conn = $db->connection;
    }

    public function getAllSongs() {
        $query = "
            SELECT songs.id, songs.title, songs.file_path, songs.image,
                   artist.name AS artist_name, genre.name AS genre_name
            FROM songs
            JOIN artist ON songs.artist_id = artist.id
            JOIN genre ON songs.genre_id = genre.id
        ";
        $result = $this->conn->query($query);
    
        $songs = [];
        while ($row = $result->fetch_assoc()) {
            $songs[] = $row;
        }
        return $songs;
    }
    
    public function getHotSongs() {
        $query = "
            SELECT songs.id, songs.title, songs.file_path, songs.image,
                   artist.name AS artist_name, genre.name AS genre_name
            FROM songs
            JOIN artist ON songs.artist_id = artist.id
            JOIN genre ON songs.genre_id = genre.id
            ORDER BY songs.id DESC
            LIMIT 10
        ";
        $result = $this->conn->query($query);
    
        $songs = [];
        while ($row = $result->fetch_assoc()) {
            $songs[] = $row;
        }
        return $songs;
    }

    // Mendapatkan path file lagu berdasarkan ID
    public function getSongById($songId) {
        $query = "SELECT file_path FROM songs WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $songId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Fungsi untuk memutar lagu berdasarkan ID
    public function playSong($songId) {
        $song = $this->getSongById($songId);
        return $song ? $song['file_path'] : null; // Mengembalikan path file atau null jika tidak ditemukan
    }

    // Mendapatkan semua genre dari tabel `genre`
    public function getAllGenres() {
        $query = "SELECT id, name AS genre_name FROM genre";
        $result = $this->conn->query($query);
        $genres = [];
        while ($row = $result->fetch_assoc()) {
            $genres[] = $row;
        }
        return $genres;
    }

    // Mendapatkan lagu berdasarkan genre
    public function getSongsByGenre($genreId) {
        $query = "
            SELECT songs.id, songs.title, songs.file_path, songs.image, 
                   artist.name AS artist_name, genre.name AS genre_name
            FROM songs
            JOIN artist ON songs.artist_id = artist.id
            JOIN genre ON songs.genre_id = genre.id
            WHERE songs.genre_id = ?
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $genreId);
        $stmt->execute();
        $result = $stmt->get_result();
        $songs = [];
        while ($row = $result->fetch_assoc()) {
            $songs[] = $row;
        }
        return $songs;
    }

    // Mendapatkan semua artis dari tabel `artist`
    public function getAllArtists() {
        $query = "SELECT id, name AS artist_name FROM artist";
        $result = $this->conn->query($query);
        $artists = [];
        while ($row = $result->fetch_assoc()) {
            $artists[] = $row;
        }
        return $artists;
    }

    // Mendapatkan lagu berdasarkan artis
    public function getSongsByArtist($artistId) {
        $query = "
            SELECT songs.id, songs.title, songs.file_path, artist.name AS artist_name, genre.name AS genre_name
            FROM songs
            JOIN artist ON songs.artist_id = artist.id
            JOIN genre ON songs.genre_id = genre.id
            WHERE songs.artist_id = ?
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $artistId);
        $stmt->execute();
        $result = $stmt->get_result();
        $songs = [];
        while ($row = $result->fetch_assoc()) {
            $songs[] = $row;
        }
        return $songs;
    }
}
?>
