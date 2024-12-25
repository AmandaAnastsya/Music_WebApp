
<?php
class Music {
    private $conn;

    public function __construct() {
        require_once 'connection.php'; // Pastikan path file benar
        $db = new ConnectionDatabase();
        $this->conn = $db->connection;
    }

    public function getAllSongs() {
        $query = "SELECT * FROM songs";
        $result = $this->conn->query($query);

        $songs = [];
        while ($row = $result->fetch_assoc()) {
            $songs[] = $row;
        }
        return $songs;
    }

    public function getHotSongs() {
        $query = "SELECT * FROM songs ORDER BY id DESC LIMIT 10";
        $result = $this->conn->query($query);

        $songs = [];
        while ($row = $result->fetch_assoc()) {
            $songs[] = $row;
        }
        return $songs;
    }

    public function getSongById($songId) {
        $query = "SELECT audio_url FROM songs WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $songId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    // Fungsi untuk memutar lagu berdasarkan ID
    public function playSong($songId) {
        $song = $this->getSongById($songId);
        return $song ? $song['audio_url'] : null; // Mengembalikan URL audio atau null jika tidak ditemukan
    }

    public function getAllGenres() {
        $query = "SELECT DISTINCT genre FROM songs WHERE genre IS NOT NULL";
        $result = $this->conn->query($query);
        $genres = [];
        while ($row = $result->fetch_assoc()) {
            $genres[] = $row['genre'];
        }
        return $genres;
    }
    
    // Method untuk mendapatkan lagu berdasarkan genre
    public function getSongsByGenre($genre) {
        $query = "SELECT * FROM songs WHERE genre = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $genre);
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
