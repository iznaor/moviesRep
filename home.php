<?php
session_start();
$isLoggedIn = false;
$isAdmin = false;

// Provjera prijave
if (isset($_SESSION['user_id'])) {
    $isLoggedIn = true;

    // FDohvaćanje podataka korisnika
    $userId = $_SESSION['user_id'];
    $conn = new mysqli("localhost", "root", "2023", "moviesdb");
    $query = "SELECT * FROM users WHERE user_id = $userId";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc();

        // Provjera admin ovlasti
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
            font-family: Arial, sans-serif;
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

        #logoutButton {
            color: #fff;
            border: none;
            cursor: pointer;
        }

        #logoutButton:hover {}

        section {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .news-card {

            background-color: rgba(51, 51, 51, 0.5);
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: scroll;
            overflow-x: hidden;
            width: 600px;
            height: 650px;
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }

        .news-card:hover {
            transform: translateY(-5px);
        }

        .news-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid #ddd;
        }

        .news-card h3 {
            padding: 10px;
            margin: 0;
            font-size: 18px;
            color: #fff;
        }

        .news-card p {
            padding: 10px;
            margin: 0;
            font-size: 14px;
            color: #fff;
        }

        .news-card::-webkit-scrollbar {
            width: 10px;
        }

        .news-card::-webkit-scrollbar-thumb {
            background-color: #34568B;
            border-radius: 5px;
        }

        .news-card::-webkit-scrollbar-track {
            background-color: rgba(51, 51, 51, 0.5);
        }

        .comments {
            background-color: rgba(51, 51, 51, 0.5);
            border-radius: 8px;
            margin-top: 10px;
            padding: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow-y: scroll;
            max-height: 300px;
        }

        .comments p {
            margin: 5px 0;
        }

        .comments a {
            color: #3498db;
            cursor: pointer;
            text-decoration: underline;
            margin-left: 10px;
        }

        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            resize: vertical;
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
        <?php
        $isLoggedIn = false;

        function checkLoginState()
        {
            global $isLoggedIn;
            $logoutButtonStyle = $isLoggedIn ? 'display: block;' : 'display: none;';
            echo '<button id="logoutButton" style="' . $logoutButtonStyle . '" onclick="logout()">Logout</button>';
        }

        checkLoginState();
        ?>
        <section>
            <h2>Latest News</h2>
            <?php
            $host = "localhost";
            $database = "moviesdb";
            $db_username = "admin";
            $db_password = "admin";

            $conn = new mysqli($host, $db_username, $db_password, $database);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $query = "SELECT * FROM news ORDER BY date DESC LIMIT 5";
            $result = $conn->query($query);

            // Prikaz vijesti
            while ($row = $result->fetch_assoc()) {
                echo '<div class="news-card">';
                echo '<h3>' . $row['title'] . '</h3>';
                echo '<p>Author: ' . $row['author'] . '</p>';
                echo '<p>Date: ' . $row['date'] . '</p>';
                $imagePath = basename($row['image']);

                if (!empty($row['image']) && file_exists($row['image'])) {
                    echo '<img src="' . $imagePath . '" alt="' . $row['image'] . '" style="max-width: 100%;">';
                }

                echo '<p>' . $row['content'] . '</p>';
                echo '<p>Tag: ' . $row['tag'] . '</p>';

                // Prikaz forme za komentare
                echo '<form action="process_comment.php" method="post">';
                echo '<input type="hidden" name="news_id" value="' . $row['id'] . '">';
                echo '<textarea name="comment" placeholder="Add a comment" required></textarea>';
                echo '<button type="submit">Submit Comment</button>';
                echo '</form>';

                // Prikaz komentara
                $newsId = $row['id'];
                $commentQuery = "SELECT comments.*, users.user_name 
                 FROM comments 
                 INNER JOIN users ON comments.user_id = users.user_id 
                 WHERE news_id = $newsId";
                $commentResult = $conn->query($commentQuery);

                $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

                echo '<div class="comments" style="overflow-y: auto; max-height: 300px;">';
                while ($comment = $commentResult->fetch_assoc()) {
                    echo '<p><strong>' . $comment['user_name'] . ':</strong> ' . $comment['comment'] . '</p>';

                    if ($userId !== null && $comment['user_id'] == $userId) {
                        echo '<a href="delete_comment.php?comment_id=' . $comment['comment_id'] . '">Delete Comment</a>';
                    }
                }
                echo '</div>';

                echo '</div>';
            }
            ?>
        </section>



        <footer>
            <p>&copy; 2023 Ivan Znaor</p>
        </footer>
    </div>



</body>



</html>