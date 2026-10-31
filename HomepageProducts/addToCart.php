<?php
    session_start();
    header('Content-Type: application/json');

    if (!isset($_SESSION['userID'])) {
        echo json_encode(["success" => false, "message" => "You must be logged in to add items to cart."]);
        exit();
    }

    $conn = mysqli_connect("localhost","root","","aurevia_db");

    if (!$conn) {
        echo json_encode(["success" => false, "message" => "Database connection failed"]);
        exit();
    }

    // Decode JSON body
    $input = json_decode(file_get_contents("php://input"), true);

    $productId = $input['productId'] ?? '';
    $quantity  = $input['quantity'] ?? 1;
    $userID    = $_SESSION['userID'];

    // Validate input
    if (empty($productId) || $quantity <= 0) {
        echo json_encode(["success" => false, "message" => "Invalid product or quantity"]);
        exit();
    }

    // Get product price to calculate subtotal
    $stmt = mysqli_prepare($conn, "SELECT price FROM products WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $productId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $product = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$product) {
        echo json_encode(["success" => false, "message" => "Product not found"]);
        exit();
    }

    $price    = $product['price'];
    $subtotal = $quantity * $price;

    // Insert or update existing cart item
    $query = "INSERT INTO cartItem (userID, productID, quantity, subtotal)
            VALUES (?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE 
                quantity = quantity + VALUES(quantity),
                subtotal = subtotal + VALUES(subtotal)";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "isid", $userID, $productId, $quantity, $subtotal);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(["success" => true, "message" => "Item added to cart"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to add item"]);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
?>
