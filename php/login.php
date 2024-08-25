<?php
// login.php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM AppUsers WHERE Username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['Password'])) {
        session_start();
        $_SESSION['user_id'] = $user['AppUserID'];
        header("Location: ../index.php");
    } else {
        echo "Invalid credentials!";
    }
}
?>
