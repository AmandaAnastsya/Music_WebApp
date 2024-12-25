
<?php
class ConnectionDatabase {
    var $db_host = "localhost";
    var $db_username = "root";
    var $db_pass = "";
    var $db_name = "music_app";
    var $connection;

    function __construct() {
        // Buat koneksi ke database
        $this->connection = new mysqli(
            $this->db_host, 
            $this->db_username, 
            $this->db_pass, 
            $this->db_name
        );

        // Periksa apakah koneksi berhasil
        if ($this->connection->connect_error) {
            die("Koneksi database gagal: " . $this->connection->connect_error);
        }
    }

    // Tambahkan metode getConnection
    function getConnection() {
        return $this->connection;
    }

    function closeConnection() {
        return $this->connection->close();
    }
}
?>