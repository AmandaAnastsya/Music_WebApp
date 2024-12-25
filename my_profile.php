<?php
// Mulai sesi
session_start();
include '../database/connection.php';
// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
// Ambil data pengguna dari database
$stmt = $pdo->prepare("SELECT username, email, birthdate, gender FROM users WHERE id = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$user_data = $stmt->fetch(PDO::FETCH_ASSOC);

// Pastikan data ditemukan
if (!$user_data) {
    echo "User not found.";
    exit;
}
?>

<!doctype html>
<html lang="en">
<head>
<?php include('header.php'); ?>
    <title>My Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #1d1d1d;
            color: white;
        }
        .modal-header {
            background-color: #00ffab;
        }
        .modal-footer {
            justify-content: space-between;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">My Profile</h1>
        <button class="btn btn-info" data-toggle="modal" data-target="#profileModal">View Profile</button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">Profile Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Username:</strong> <?php echo htmlspecialchars($user_data['username']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user_data['email']); ?></p>
                    <p><strong>Birthdate:</strong> <?php echo htmlspecialchars($user_data['birthdate']); ?></p>
                    <p><strong>Gender:</strong> <?php echo htmlspecialchars($user_data['gender']); ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="deleteAccountBtn">Delete Account</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script>
        document.getElementById('deleteAccountBtn').addEventListener('click', function() {
            if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
                // Logika untuk menghapus akun
                window.location.href = 'delete_account.php'; // Halaman untuk menghapus akun
            }
        });
    </script>
</body>
</html>