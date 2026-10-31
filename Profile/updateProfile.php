<?php
    session_start();
    header('Content-Type: application/json');

    // Make sure user is logged in
    if (!isset($_SESSION['userID'])) {
        echo json_encode(['success' => false, 'message' => 'The user not logged in yet']);
        exit();
    }

    $server = "localhost";
    $username = "root";
    $password = "";
    $db = "aurevia_db";

    $conn = mysqli_connect($server, $username, $password, $db);
    if (!$conn) {
        echo json_encode(['success' => false, 'message' => 'DB connection failed']);
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['userID'])) {
        $id = $_SESSION['userID'];
        $username = trim($_POST['username']);
        $email    = trim($_POST['email']);
        $phone    = trim($_POST['phone']);

        $query = "UPDATE user SET username=?, email=?, phone=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $phone, $_SESSION['userID']);

        if (mysqli_stmt_execute($stmt)) {
            echo "success";
        } else {
            echo "error: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
?>
