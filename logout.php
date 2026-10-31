<?php
session_start();

// remove userID session
if (isset($_SESSION['userID'])) {
    unset($_SESSION['userID']);
}

session_destroy();

header("Location: index.php");
exit;
?>