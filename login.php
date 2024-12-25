<!doctype html>
<html lang="en">
<head>
    <?php session_start(); ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pop-Up Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        :root {
            --primary-color: #00ffab;
            --hover-color: #1c782b;
            --bg-dark: #1a1a2e;
            --text-light: #ffffff;
        }

        body {
            background-color: #000000;
            color: var(--text-light);
            font-family: 'Poppins', sans-serif;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.85);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            backdrop-filter: blur(8px);
        }

        .login-box {
            background-color: var(--bg-dark);
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 400px;
            text-align: center;
            position: relative;
            animation: fadeIn 0.5s ease forwards;
        }

        .login-box input {
            background-color: rgba(255, 255, 255, 0.05);
            border: none;
            border-bottom: 2px solid var(--primary-color);
            color: var(--text-light);
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .login-box input:focus {
            outline: none;
            border-bottom: 2px solid var(--hover-color);
            background-color: rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 12px rgba(0, 255, 171, 0.1);
        }

        .login-box button {
            background-color: var(--primary-color);
            border: none;
            padding: 12px 24px;
            border-radius: 25px;
            color: var(--bg-dark);
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
        }

        .login-box button:hover {
            background-color: var(--hover-color);
            color: var(--text-light);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 255, 171, 0.2);
        }

        .close-btn {
            position: absolute;
            top: -40px;
            right: -40px;
            font-size: 28px;
            color: var(--text-light);
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .close-btn:hover {
            color: var(--primary-color);
        }

        .login-box a {
            display: block;
            margin-top: 15px;
            color: var(--primary-color);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .login-box a:hover {
            color: var(--hover-color);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 576px) {
            .login-box {
                margin: 20px;
                padding: 1.5rem;
            }

            .close-btn {
                top: 10px;
                right: 10px;
            }
        }
    </style>
</head>
<body>
    <main role="main" class="container text-center py-5">
        <h1>Welcome to MUSIIK App</h1>
        <p class="lead">Dengarkan, Rasakan, Nikmati.</p>
        <p>Temukan Ritme Hidupmu di Musiik</p>
        <button class="btn btn-primary mt-4" onclick="openLogin()">Login</button>
    </main>

    <div class="overlay" id="loginOverlay">
        <div class="login-box">
            <span class="close-btn" onclick="closeLogin()">&times;</span>
            <h4>Log in or create a new account.</h4>
            <form action="controller/auth.php?action=login" method="POST">
                <input type="email" placeholder="Email" name="email" required>
                <input type="password" placeholder="Password" name="password" required>
                <button type="submit">Sign In</button>
            </form>
            <a href="register.php">Tidak punya akun? Buat di sini</a>
        </div>
    </div>

    <script>
        function openLogin() {
            document.getElementById('loginOverlay').style.display = 'flex';
        }

        function closeLogin() {
            document.getElementById('loginOverlay').style.display = 'none';
        }
    </script>
</body>
</html>