<?php
// register.php
require 'db.php'; // Ensure the database connection is properly set up

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $password_confirm = htmlspecialchars($_POST['password_confirmation']);

    // Check if passwords match
    if ($password !== $password_confirm) {
        header("Location: ../html/register_form.php?status=error&message=password_mismatch");
        exit;
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check if username already exists
    try {
        $stmt = $conn->prepare("SELECT * FROM AppUsers WHERE Username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Username already exists
            header("Location: ../html/register_form.php?status=duplicate");
        } else {
            // Insert new user into the database
            $stmt = $conn->prepare("INSERT INTO AppUsers (Username, Password) VALUES (:username, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->execute();

            // Registration successful, redirect with success status
            header("Location: ../html/register_form.php?status=success");
        }
    } catch (PDOException $e) {
        // Handle any errors that occur
        error_log("Error during registration: " . $e->getMessage());
        header("Location: ../html/register_form.php?status=error");
    }
}
?>
