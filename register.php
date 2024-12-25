<!doctype html>
<html lang="en">
<head>
    <?php include('header.php') ?>
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

        .register-container {
            background-color: var(--bg-dark);
            max-width: 400px;
            margin: 50px auto;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.5s ease forwards;
        }

        .register-container h5 {
            text-align: center;
            margin-bottom: 25px;
            color: var(--primary-color);
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            color: #ddd;
            font-size: 14px;
            margin-bottom: 8px;
            display: block;
        }

        .form-group input {
            background-color: rgba(255, 255, 255, 0.05);
            border: none;
            border-bottom: 2px solid var(--primary-color);
            color: var(--text-light);
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-bottom: 2px solid var(--hover-color);
            background-color: rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 12px rgba(0, 255, 171, 0.1);
        }

        .register-container button {
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
            margin-top: 10px;
        }

        .register-container button:hover {
            background-color: var(--hover-color);
            color: var(--text-light);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 255, 171, 0.2);
        }

        .register-container a {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: var(--primary-color);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .register-container a:hover {
            color: var(--hover-color);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 576px) {
            .register-container {
                margin: 20px;
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <main role="main" class="container">
        <div class="register-container">
            <h5>Register</h5>
            <form action="controller/auth.php?action=register" method="POST">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" placeholder="Input your name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Input your email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Input your password" required>
                </div>
                <button type="submit">Submit</button>
            </form>
            <a href="login.php">Sudah punya akun? Login di sini</a>
        </div>
    </main>

    <?php include('footer.php') ?>
</body>
</html>