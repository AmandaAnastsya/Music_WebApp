<?php
session_start();
include 'database/connection.php'; // Pastikan jalur ini benar

$conn = new ConnectionDatabase();
$db = $conn->getConnection();

// Pastikan user_id ada di session
if (!isset($_SESSION['user_id'])) {
    die("User ID tidak ditemukan, silakan login terlebih dahulu.");
}

$userId = $_SESSION['user_id'];

// Ambil data pengguna dari database
$sql = "SELECT name, email, birthdate, gender, profile_picture FROM users WHERE id=?";
$stmt = $db->prepare($sql);
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    die("Data pengguna tidak ditemukan.");
}

// Tutup statement dan koneksi
$stmt->close();
$db->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('header.php') ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Info</title>
    <style>
        body {
            background-color:rgb(19, 19, 19);
            color: white;
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .back-icon {
            position: absolute;
            top: 20px;
            left: 20px;
            color: white;
            font-size: 24px;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .back-icon:hover {
            transform: scale(1.2);
        }

        .user-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: rgba(34, 34, 34, 0.8);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            max-width: 400px;
            width: 100%;
            animation: fadeIn 0.5s ease-out forwards;
        }

        .profile-pic {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            overflow: hidden;
            margin-bottom: 25px;
            border: 3px solid #007bff;
            box-shadow: 0 0 15px rgba(0,123,255,0.3);
            transition: transform 0.3s ease;
        }

        .profile-pic:hover {
            transform: scale(1.05);
        }

        .profile-pic img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .p {
            font-size: 2em;
            margin: 0 0 20px 0;
            color: #007bff;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .info {
            width: 100%;
            text-align: left;
        }

        .info p {
            margin: 12px 0;
            padding: 10px;
            background-color: rgba(51, 51, 51, 0.5);
            border-radius: 8px;
            border-left: 3px solid #007bff;
            transition: transform 0.3s ease;
        }

        .info p:hover {
            transform: translateX(5px);
            background-color: rgba(51, 51, 51, 0.8);
        }

        .edit-button {
            background: linear-gradient(45deg, #007bff, #00a1ff);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 25px;
            font-size: 1.1em;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,123,255,0.3);
            width: 100%;
        }

        .edit-button:hover {
            background: linear-gradient(45deg, #0056b3, #007bff);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,123,255,0.4);
        }

        @keyframes fadeIn {
            from { 
                opacity: 0; 
                transform: translateY(20px); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0); 
            }
        }
    </style>
</head>
<body>
    <div class="back-icon" onclick="window.history.back();">
        &larr;
    </div>

    <div class="user-info">
        <div class="profile-pic">
            <img src="<?php echo htmlspecialchars('uploads/' . $user['profile_picture']); ?>" alt="Profile Picture">
        </div>
        <h2 class="p"><?php echo htmlspecialchars($user['name']); ?></h2>
        <div class="info">
            <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
            <p>Birthdate: <?php echo htmlspecialchars($user['birthdate']); ?></p>
            <p>Gender: <?php echo htmlspecialchars($user['gender']); ?></p>
            <p>Updated At: <?php echo date('Y-m-d H:i:s'); ?></p>
        </div>
        <a href="edit_profile.php" style="width: 100%; text-decoration: none;">
            <button class="edit-button">Edit Your Profile</button>
        </a>
    </div>
</body>
</html>