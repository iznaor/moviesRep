<?php
session_start();
$isLoggedIn = false;
$isAdmin = false;

if (isset($_SESSION['user_id'])) {
    $isLoggedIn = true;

    $userId = $_SESSION['user_id'];
    $conn = new mysqli("localhost", "root", "2023", "moviesdb");
    $query = "SELECT * FROM users WHERE user_id = $userId";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc();

        $isAdmin = $userData['is_admin'];
    }

    $conn->close();
}
?>
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

        .light-mode {
            background: linear-gradient(to right top, #691212, #75122f, #781f4d, #72316b, #614484, #4d5292, #325f9c, #006ba0, #00769e, #007f98, #158791, #3b8e89);
        }

        .dark-mode {
            background: linear-gradient(to right top, #320909, #340b19, #341125, #301731, #281e3a, #1f243f, #152942, #092d43, #023141, #03343e, #0c373b, #173937);
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

        #logoutButton {
            color: #fff;
            border: none;
            cursor: pointer;
        }

        #logoutButton:hover {}

        section {
            padding: 20px;
            max-width: 800px;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            position: relative;
        }


        #searchResults {
            position: absolute;
            top: 10;
            left: calc(50% + 10px);
            width: 1200px;
            overflow-y: auto;
            background-color: rgba(51, 51, 51, 0.3);
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            z-index: 1;
            max-height: 550px;
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
            <?php
            if ($isLoggedIn) {
                echo '<a href="profile_page.php"><img src="profile.png"></a>';
            } else {
                echo '<a href="profile.php"><img src="profile.png"></a>';
            }
            ?>
            <?php
            if ($isLoggedIn && $isAdmin) {
                echo '<a href="admin.php"><img src="admin.png"></a>';
            }
            ?>
            <?php
            if ($isLoggedIn) {
                echo '<a id="logoutButton" href="logout.php"><img src="exit.png"></a>';
            }
            ?>
        </nav>

        <button id="modeToggle" onclick="toggleMode()">
            <img src="moon.png">
        </button>

        <section style="display: flex; justify-content: space-between;">
            <form id="searchForm" onsubmit="searchMovies(); return false;">
                <label for="searchTitle">Search by Title:</label>
                <input type="text" id="searchTitle" name="searchTitle" placeholder="Try Star Wars or Lord of the Rings"
                    required>
                <button type="submit">Search</button>
            </form>

            <div id="searchResults"></div>
        </section>




        <footer>
            <p>&copy; 2023 Ivan Znaor</p>
        </footer>
    </div>


</body>

</html>