<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

$host = "localhost";
$database = "moviesdb";
$db_username = "admin";
$db_password = "admin";

// Stvaranje veze
$conn = new mysqli($host, $db_username, $db_password, $database);

// Provjera veze
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Provjera forme za stvaranje računa
if (isset($_POST['create_account'])) {
    createAccount($conn);
}

// Provjera forme za prijavu
if (isset($_POST['login'])) {
    loginUser($conn);
}

$conn->close();

function createAccount($conn)
{
    // Dobivanje podataka
    $username = $_POST['create_user_name'];
    $email = $_POST['create_user_email'];
    $password = $_POST['create_user_password'];

    // Hash lozinke
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Unos podataka u bazu
    $sql = "INSERT INTO users (user_name, user_email, user_password, date_creation, is_admin) 
            VALUES ('$username', '$email', '$hashedPassword', NOW(), 0)";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("You have created an account you are now able to log in!");</script>';

        echo '<script>window.location.href = "profile.php";</script>';
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

function loginUser($conn)
{

    $username = $_POST['login_user_name'];
    $password = $_POST['login_user_password'];

    // Uzimanje podataka iz tablice users
    $sql = "SELECT * FROM users WHERE user_name = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Provjera lozinke
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['user_password'])) {
            // Postavljanje sesije
            session_start();
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_name'] = $row['user_name'];

            header("Location: profile_page.php");
            exit();
        } else {
            echo "Incorrect password";
        }
    } else {
        echo '<script>alert("User not found");</script>';

        echo '<script>window.location.href = "profile.php";</script>';
    }
}

?>