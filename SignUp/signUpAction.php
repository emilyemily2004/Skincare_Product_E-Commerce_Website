<?php
session_start();

$server = "localhost";
$username = "root";
$password = "";
$db = "aurevia_db";

$conn = mysqli_connect($server, $username, $password, $db);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["username"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirm_password = $_POST["confirm_password"] ?? "";

    $status = "error";

    // Validate required fields
    if (empty($name) || empty($email) || empty($phone) || empty($password)) {
        $message = "All fields are required.";
    }
    // Check passwords match
    elseif ($password !== $confirm_password) {
        $message = "Passwords do not match.";
    }
    else {
        // Check if username or email already exists
        $checkQuery = "SELECT id FROM user WHERE username = ? OR email = ?";
        $checkStmt = mysqli_prepare($conn, $checkQuery);
        mysqli_stmt_bind_param($checkStmt, "ss", $name, $email);
        mysqli_stmt_execute($checkStmt);
        mysqli_stmt_store_result($checkStmt);

        if (mysqli_stmt_num_rows($checkStmt) > 0) {
            $message = "Username or Email already exists!";
        } else {
            // Safe to insert
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO user (username,email,phone,password) VALUES (?,?,?,?)";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $phone, $hashedPassword);

            if (!mysqli_stmt_execute($stmt)) {
                // Catch duplicate key error (just in case)
                if (mysqli_errno($conn) == 1062) {
                    $message = "Username or Email already exists!";
                } else {
                    $message = "Error: " . mysqli_error($conn);
                }
            } else {
                $status = "success";
                $message = "Registration Successful! Welcome <a href='../index.php'>Please Login here</a>";
            }

            mysqli_stmt_close($stmt);
        }

        mysqli_stmt_close($checkStmt);
    }

    mysqli_close($conn);

    // Redirect back to index.php(Sign Up) with message and status
    header("Location: index.php?message=" . urlencode($message) . "&status=" . urlencode($status));
    exit();
}
?>
