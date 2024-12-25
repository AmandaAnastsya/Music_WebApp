<?php
include('connection.php');

class Auth {
    function __construct() {
        $this->database = new ConnectionDatabase();
    }

    function register($name, $email, $password) {
        $query = "INSERT INTO `users` (`name`, `email`, `password`) VALUES (?, ?, ?)";

        $process = $this->database->connection->prepare($query);

        if ($process) {
            $hashedPassword = md5($password); // Gunakan hashing yang lebih aman di produksi
            $process->bind_param('sss', $name, $email, $hashedPassword);
            $process->execute();
        } else {
            $error = $this->database->connection->errno . ' ' . $this->database->connection->error;
            echo $error;
        }

        $process->close();
        $this->database->closeConnection();

        return true;
    }

    function login($email, $password) {
        $result = null;
        $query = "SELECT * FROM `users` WHERE email = ?";
        $process = $this->database->connection->prepare($query);

        if ($process) {
            $process->bind_param('s', $email);
            $process->execute();

            $result = $process->get_result();
            $user = $result->fetch_assoc();

            // Cek kecocokan password
            if ($user && $user['password'] === md5($password)) {
                // Set session variables setelah login berhasil
                $_SESSION['user_id'] = $user['id']; // Simpan ID pengguna dalam sesi
                $_SESSION['user_name'] = $user['name']; // Simpan nama pengguna dalam sesi
                return $user; // Kembalikan data pengguna
            } else {
                return false; // Login gagal
            }
        } else {
            $error = $this->database->connection->errno . ' ' . $this->database->connection->error;
            echo $error;
        }

        $process->close();
        $this->database->closeConnection();

        return false; // Jika tidak ada hasil
    }
}
?>