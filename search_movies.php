<?php
$host = "localhost";
$database = "moviesdb";
$db_username = "admin";
$db_password = "admin";

$conn = new mysqli($host, $db_username, $db_password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // dohvaćanje naziva
    $searchTitle = $_POST['searchTitle'];

    // pretraga
    $query = "SELECT * FROM movies WHERE title LIKE '%$searchTitle%'";
    // dohvaćanje rezultata
    $result = $conn->query($query);

    // prikaz rezultata
    while ($row = $result->fetch_assoc()) {
        echo '<div class="movie-card">';

        // dohvaćanje putanje slike
        $imagePath = basename($row['movie_image']);

        // smanjivanje slike
        $downscaledImagePath = downscaleImage($imagePath, 400, 600); // Adjust dimensions as needed

        // provjera uspješnosti
        if ($downscaledImagePath) {
            // prikaz skalirane slike
            echo '<div style="float: left; margin-right: 20px;">';
            echo '<img src="' . $downscaledImagePath . '" alt="' . $row['title'] . '" style="max-width: 100%;">';
            echo '</div>';
        } else {
            echo 'Error processing image.';

            continue;
        }

        // Prikaz detalja filma
        echo '<div>';
        echo '<h2>' . $row['title'] . '</h2>';
        echo '<p>Release Date: ' . $row['release_date'] . '</p>';
        echo '<p>Genre: ' . $row['genre'] . '</p>';

        // Dohvaćanje povezanih glumaca
        $movieId = $row['movie_id'];
        $actorsQuery = "SELECT a.actor_name FROM actors a
                        JOIN movie_actor ma ON a.actor_id = ma.actor_id
                        WHERE ma.movie_id = $movieId";
        $actorsResult = $conn->query($actorsQuery);
        echo '<p>Actors: ';
        while ($actor = $actorsResult->fetch_assoc()) {
            echo $actor['actor_name'] . ', ';
        }
        echo '</p>';

        // Dohvaćanje povezanih producenata
        $producersQuery = "SELECT p.producer_name FROM producers p
                           JOIN movie_producer mp ON p.producer_id = mp.producer_id
                           WHERE mp.movie_id = $movieId";
        $producersResult = $conn->query($producersQuery);
        echo '<p>Producers: ';
        while ($producer = $producersResult->fetch_assoc()) {
            echo $producer['producer_name'] . ', ';
        }
        echo '</p>';


        $directorsQuery = "SELECT d.director_name FROM directors d
                           JOIN movie_director md ON d.director_id = md.director_id
                           WHERE md.movie_id = $movieId";
        $directorsResult = $conn->query($directorsQuery);
        echo '<p>Directors: ';
        while ($director = $directorsResult->fetch_assoc()) {
            echo $director['director_name'] . ', ';
        }
        echo '</p>';

        // prikaz youtube isječka
        echo '<div>';
        echo '<iframe width="560" height="315" src="' . $row['movie_trailer'] . '" frameborder="0" allowfullscreen></iframe>';
        echo '</div>';

        echo '</div>';

        // Prostor za sljedeći film
        echo '<div style="clear: both;"></div>';

        echo '</div>';
    }
}

$conn->close();

/**
 * 
 *
 * @param string $imagePath 
 * @param int $width 
 * @param int $height 
 * @return string|false 
 */
function downscaleImage($imagePath, $width, $height)
{
    // putanja do slike
    $absoluteImagePath = $_SERVER['DOCUMENT_ROOT'] . '/' . $imagePath;

    // provjera postojanosti 
    if (!file_exists($absoluteImagePath)) {
        echo 'Image file not found: ' . $absoluteImagePath;
        return false;
    }

    // dohvaćanje detalja slike
    list($originalWidth, $originalHeight) = getimagesize($absoluteImagePath);

    // stvaranje novog resursa
    $downscaledImage = imagecreatetruecolor($width, $height);

    // učitavanje
    $originalImage = imagecreatefromjpeg($absoluteImagePath);

    // provjera uspješnog stvaranja
    if (!$originalImage) {
        echo 'Failed to create image from ' . $absoluteImagePath;
        return false;
    }

    // promjena veličine
    if (!imagecopyresampled($downscaledImage, $originalImage, 0, 0, 0, 0, $width, $height, $originalWidth, $originalHeight)) {
        echo 'Image resize failed';
        return false;
    }

    // spremanje nove slike
    $downscaledImagePath = 'downscaled_' . basename($absoluteImagePath);
    if (!imagejpeg($downscaledImage, $downscaledImagePath)) {
        echo 'Failed to save downscaled image';
        return false;
    }

    // oslobađanje memorije
    imagedestroy($downscaledImage);
    imagedestroy($originalImage);

    return $downscaledImagePath;
}
?>