<!doctype html>
<html lang="en">
<head>
    <?php 
    session_start(); 
    include('header.php'); 
    
    // Tampilkan pesan sukses/error jika ada
    if (isset($_SESSION['success_message'])) {
        echo "<script>
                alert('" . $_SESSION['success_message'] . "');
                window.location.href = 'index.php'; // Redirect ke index.php setelah pop-up
              </script>";
        unset($_SESSION['success_message']); // Hapus pesan setelah ditampilkan
    }
    if (isset($_SESSION['error_message'])) {
        echo "<script>
                alert('" . $_SESSION['error_message'] . "');
              </script>";
        unset($_SESSION['error_message']);
    }
    ?>

<style>
    body {
        background-color:rgb(19, 19, 19);
        color: white;
        font-family: 'Segoe UI', Arial, sans-serif;
        margin: 0;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        text-align: center;
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

    h1 {
        margin: 30px 0;
        font-size: 2.5em;
        color: #007bff;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }

    .form-group {
        margin-bottom: 25px;
        position: relative;
        width: 100%;
        max-width: 400px;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-size: 1.1em;
        color: #007bff;
        text-align: left;
        transition: color 0.3s;
    }

    input[type="text"],
    input[type="date"],
    select,
    input[type="file"] {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #333;
        border-radius: 8px;
        background-color: rgba(34, 34, 34, 0.8);
        color: white;
        font-size: 1em;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    input[type="text"]:focus,
    input[type="date"]:focus,
    select:focus,
    input[type="file"]:focus {
        border-color: #007bff;
        box-shadow: 0 0 8px rgba(0,123,255,0.5);
        outline: none;
    }

    input[type="file"] {
        padding: 8px;
    }

    button {
        background: linear-gradient(45deg, #007bff, #00a1ff);
        color: white;
        border: none;
        padding: 12px 20px;
        cursor: pointer;
        border-radius: 8px;
        margin-top: 15px;
        width: 100%;
        max-width: 400px;
        font-size: 1.1em;
        font-weight: bold;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0,123,255,0.3);
    }

    button:hover {
        background: linear-gradient(45deg, #0056b3, #007bff);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,123,255,0.4);
    }

    .delete-button {
        background: linear-gradient(45deg, #ff3333, #ff0000);
        margin-top: 15px;
        box-shadow: 0 4px 15px rgba(255,0,0,0.3);
    }

    .delete-button:hover {
        background: linear-gradient(45deg, #cc0000, #ff3333);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255,0,0,0.4);
    }

    /* Animasi untuk form elements */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .form-group {
        animation: fadeIn 0.5s ease-out forwards;
    }
</style>

   
</head>
<body>
<div class="back-icon" onclick="window.history.back();">
        &larr; <!-- Simbol panah kiri -->
    </div>

    <h1>Edit Profile</h1>
    <form action="controller/update_profile.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
             <label for="name">Name:</label>
             <input type="text" id="name" name="name" placeholder="Enter your name">
        </div>

        <div class="form-group">
            <label for="birthdate">Birthdate:</label>
            <input type="date" id="birthdate" name="birthdate">
        </div>
        <div class="form-group">
            <label for="gender">Gender:</label>
            <select id="gender" name="gender">
            <option value="---">-</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>
        <div class="form-group">
            <label for="profile_picture">Upload Profile Picture:</label>
            <input type="file" id="profile_picture" name="profile_picture">
        </div>
        <button type="submit">Save</button>
        <button type="button" class="delete-button" onclick="confirmDelete()">Delete Your Account</button>
    </form>

    <script>
        function confirmDelete() {
            const confirmation = confirm("Are you sure you want to delete your data?");
            if (confirmation) {
                const password = prompt("Please enter your password to confirm deletion:");
                if (password) {
                    // Kirim password ke server untuk validasi
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = 'controller/delete_account.php'; // Ganti dengan jalur ke file pemrosesan
                    const passwordInput = document.createElement('input');
                    passwordInput.type = 'hidden';
                    passwordInput.name = 'password';
                    passwordInput.value = password;
                    form.appendChild(passwordInput);
                    document.body.appendChild(form);
                    form.submit(); // Kirim form
                }
            }
        }
    </script>
</body>
</html>