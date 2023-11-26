<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        #container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .light-mode-container {
            background: linear-gradient(to right top, #691212, #75122f, #781f4d, #72316b, #614484, #4d5292, #325f9c, #006ba0, #00769e, #007f98, #158791, #3b8e89);
            color: #fff;
            flex: 1;
        }

        .dark-mode-container {
            background: linear-gradient(to right top, #320909, #340b19, #341125, #301731, #281e3a, #1f243f, #152942, #092d43, #023141, #03343e, #0c373b, #173937);
            color: #fff;
            flex: 1;
        }

        header {
            background-color: rgba(51, 51, 51, 0.3);
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        nav {
            display: flex;
            justify-content: space-around;
            background-color: rgba(51, 51, 51, 0.3);
            padding: 5px;
            height: 35px;
        }

        nav a {
            text-decoration: none;
        }

        nav img {
            width: 30px;
            height: 30px;
            transition: transform 0.3s ease;
        }

        nav img:hover {
            transform: scale(1.2);
        }

        section {
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
        }

        footer {
            background-color: rgba(51, 51, 51, 0.3);
            color: #fff;
            text-align: center;
            padding: 10px;
            margin-top: auto;
        }

        .light-mode-container {
            background: linear-gradient(to right top, #691212, #75122f, #781f4d, #72316b, #614484, #4d5292, #325f9c, #006ba0, #00769e, #007f98, #158791, #3b8e89);
            color: #fff;
            flex: 1;
        }


        .dark-mode-container {
            background: linear-gradient(to right top, #320909, #340b19, #341125, #301731, #281e3a, #1f243f, #152942, #092d43, #023141, #03343e, #0c373b, #173937);
            color: #fff;
            flex: 1;
        }

        #modeToggle {
            background-color: rgba(51, 51, 51, 0);
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            position: fixed;
            top: 10px;
            right: 10px;
        }

        #modeToggle img {
            width: 25px;
            height: 25px;
            transition: transform 0.3s ease;
        }

        #modeToggle img:hover {
            transform: scale(1.2);
        }

        form {
            background-color: rgba(51, 51, 51, 0);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        form label {
            display: block;
            margin-bottom: 8px;
            color: #ffffff;
        }

        form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        form button {
            background-color: #4CAF50;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        form button:hover {
            background-color: #45a049;
        }

        form h2 {
            color: #ffffff;
        }
    </style>
    <script src="script.js"></script>


</head>

<body>
    <div id="container" class="light-mode-container">
        <header>
            <h1>𝕄𝕠𝕧𝕚𝕖𝕤</h1>
        </header>

        <nav>
            <a href="home.php"><img src="home.png"></a>
            <a href="movies.php"><img src="movies.png"></a>
            <a href="#"><img src="profile.png"></a>
            <?php
            if ($isLoggedIn && $isAdmin) {
                echo '<a href="#"><img src="admin.png"></a>';
            }
            ?>
        </nav>

        <button id="modeToggle" onclick="toggleMode()">
            <img src="moon.png">
        </button>

        <section style="display: flex; justify-content: space-between;">

            <form action="process_form.php" method="post" style="flex: 1; margin-right: 20px;">
                <h2>Create Account</h2>
                <input type="hidden" name="create_account" value="create_account">

                <label for="create_user_name">Username:</label>
                <input type="text" id="create_user_name" name="create_user_name" required>

                <label for="create_user_email">Email:</label>
                <input type="email" id="create_user_email" name="create_user_email" required>

                <label for="create_user_password">Password:</label>
                <input type="password" id="create_user_password" name="create_user_password" required>

                <button type="submit">Create Account</button>
            </form>

            <!-- Forma za prijavu -->
            <form action="process_form.php" method="post" style="flex: 1; margin-left: 20px;">
                <h2>Login</h2>
                <input type="hidden" name="login" value="login">

                <label for="login_user_name">Username:</label>
                <input type="text" id="login_user_name" name="login_user_name" required>

                <label for="login_user_password">Password:</label>
                <input type="password" id="login_user_password" name="login_user_password" required>

                <button type="submit">Login</button>
            </form>

        </section>



        <footer>
            <p>&copy; 2023 Ivan Znaor</p>
        </footer>
    </div>


</body>

</html>