<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['userID'])) {
    echo json_encode(["success" => false, "message" => "You must be logged in."]);
    exit;
}

$userID = $_SESSION['userID'];
$cartID = intval($_POST['cartID'] ?? 0);
$action = $_POST['action'] ?? '';
$quantity = intval($_POST['quantity'] ?? 1);

$conn = mysqli_connect("localhost", "root", "", "aurevia_db");
if (!$conn) {
    echo json_encode(["success" => false, "message" => "Database connection failed."]);
    exit;
}

// Get productID and price of the cart item
$stmt = mysqli_prepare($conn, "SELECT productID FROM cartItem WHERE id=? AND userID=?");
mysqli_stmt_bind_param($stmt, "ii", $cartID, $userID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$item = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$item) {
    echo json_encode(["success" => false, "message" => "Cart item not found."]);
    exit;
}

$productID = $item['productID'];

// Get product price
$stmt = mysqli_prepare($conn, "SELECT price FROM products WHERE id=?");
mysqli_stmt_bind_param($stmt, "s", $productID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$product) {
    echo json_encode(["success" => false, "message" => "Product not found."]);
    exit;
}

$price = $product['price'];

// Update or delete cart item
if ($quantity <= 0) {
    $stmt = mysqli_prepare($conn, "DELETE FROM cartItem WHERE id=? AND userID=?");
    mysqli_stmt_bind_param($stmt, "ii", $cartID, $userID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
} else {
    $subtotal = $quantity * $price;
    $stmt = mysqli_prepare($conn, "UPDATE cartItem SET quantity=?, subtotal=? WHERE id=? AND userID=?");
    mysqli_stmt_bind_param($stmt, "iidi", $quantity, $subtotal, $cartID, $userID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Calculate new subtotal for all items
$stmt = mysqli_prepare($conn, "SELECT SUM(subtotal) as subtotal FROM cartItem WHERE userID=?");
mysqli_stmt_bind_param($stmt, "i", $userID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$total = mysqli_fetch_assoc($result)['subtotal'] ?? 0;
mysqli_stmt_close($stmt);
mysqli_close($conn);

echo json_encode(["success" => true, "subtotal" => $total]);

?>