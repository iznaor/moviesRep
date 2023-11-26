<?php
session_start();
$isLoggedIn = false;
$isAdmin = false;

// Provjera prijave
if (isset($_SESSION['user_id'])) {
    $isLoggedIn = true;

    // Dohvaćanje podataka korisnika iz baze na temelju user_id
    // Unjeti nove podtake ovisno o nazivu baze i podacima za spajanje
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

$editMode = false;
$editNewsId = 0;

// Ako su dane admin ovlasti prikaz forme
if ($isAdmin) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Dohvaćanje podataka vezano za vijesti
        $title = $_POST["title"];
        $author = $_POST["author"];
        $content = $_POST["content"];
        $tag = $_POST["tag"];

        // Provjera radi li se o novoj vijesti ili prepravljanju 
        if (isset($_POST['edit_news_id'])) {
            // Prepravljanje
            $editNewsId = $_POST['edit_news_id'];

            // Update
            $conn = new mysqli("localhost", "root", "2023", "moviesdb");
            $query = "UPDATE news SET title='$title', author='$author', content='$content', tag='$tag' WHERE id=$editNewsId";
            $conn->query($query);

            // Reset edit
            $editMode = false;
        } else {
            // UNos nove vijesti
            $conn = new mysqli("localhost", "root", "2023", "moviesdb");
            $query = "INSERT INTO news (title, author, content, tag, date) VALUES ('$title', '$author', '$content', '$tag', NOW())";
            $conn->query($query);
        }

        $conn->close();
    }

    // Provjera prepravljanja za specifičnu vijest
    if (isset($_GET['edit_news_id'])) {
        $editNewsId = $_GET['edit_news_id'];
        $editMode = true;

        // Dohvaćanje trenutne vijesti za prepravke 
        $conn = new mysqli("localhost", "root", "2023", "moviesdb");
        $query = "SELECT * FROM news WHERE id=$editNewsId";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $editNewsData = $result->fetch_assoc();
        }

        $conn->close();
    }
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
            background-color: #f1f1f1;

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

        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: rgba(51, 51, 51, 0.3);
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        ul li {
            margin-bottom: 10px;
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

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
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
        // Korisnik mora biti admin da vidi formu
        if ($isAdmin && ($editMode || !isset($_GET['edit_news_id']))) {
            ?>
            <section>
                <h2>
                    <?php echo ($editMode) ? 'Edit News' : 'Add News'; ?>
                </h2>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" name="edit_news_id" value="<?php echo $editNewsId; ?>">
                    <label for="image">Image:</label>
                    <input type="file" id="image" name="image">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" required
                        value="<?php echo ($editMode) ? $editNewsData['title'] : ''; ?>">

                    <label for="author">Author:</label>
                    <input type="text" id="author" name="author" required
                        value="<?php echo ($editMode) ? $editNewsData['author'] : ''; ?>">

                    <label for="content">Content:</label>
                    <textarea id="content" name="content"
                        required><?php echo ($editMode) ? $editNewsData['content'] : ''; ?></textarea>

                    <label for="tag">Tag:</label>
                    <input type="text" id="tag" name="tag" value="<?php echo ($editMode) ? $editNewsData['tag'] : ''; ?>">

                    <button type="submit">
                        <?php echo ($editMode) ? 'Update' : 'Submit'; ?>
                    </button>
                </form>
            </section>
            <?php
        }
        ?>

        <?php
        // Dohvaćanje i prikaz postojećih vijesti
        $conn = new mysqli("localhost", "root", "2023", "moviesdb");
        $query = "SELECT * FROM news";
        $result = $conn->query($query);
        ?>

        <section>
            <h2>Existing News</h2>
            <ul>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "<li><a href='admin.php?edit_news_id={$row['id']}' style='color: white;'>{$row['title']}</a></li>";
                }
                ?>
            </ul>
        </section>



        <footer>
            <p>&copy; 2023 Ivan Znaor</p>
        </footer>
    </div>



</body>



</html>