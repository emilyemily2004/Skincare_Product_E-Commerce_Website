<?php
include("../includes/header.php");

$server = "localhost";
$username = "root";
$password = "";
$db = "aurevia_db";

$conn = mysqli_connect($server, $username, $password, $db);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();
$userID = $_SESSION['userID'] ?? 0;
if ($userID == 0) {
    echo "<p style='text-align:center; margin-top: 50px;'>Please login to view your cart.</p>";
    exit;
}

// Fetch cart items
$calQuery = "SELECT ci.id, ci.quantity, p.id AS productID, ci.subtotal, p.name, p.price, p.image 
             FROM cartItem ci 
             JOIN products p ON ci.productID = p.id 
             WHERE ci.userID=?";
$stmt = mysqli_prepare($conn, $calQuery);
mysqli_stmt_bind_param($stmt, "i", $userID);
mysqli_stmt_execute($stmt);
$cartItemResult = mysqli_stmt_get_result($stmt);

$items = [];
$total = 0;
while ($row = mysqli_fetch_assoc($cartItemResult)) {
    $total += $row['subtotal'];
    $items[] = $row;
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Your Cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../style/cartStyle.css">
</head>

<body>
    <content class='cart-content'>
        <h2 style='text-align: center'>Your Cart</h2>

        <?php if (empty($items)): ?>
            <div style="text-align:center; margin: 40px 0px;">
                <p style="margin-bottom: 7vh">Your cart is currently empty.</p>
                <button onclick="window.location.href='../HomepageProducts'" style="margin-top:10px;">Continue Shopping</button>
            </div>
        <?php else: ?>
            <div class="cart-table-wrapper">
                <table class='cart-table'>
                    <thead>
                        <tr>
                            <th style='text-align: left; padding-left: 70px;'>PRODUCT</th>
                            <th style='text-align: left;'>QUANTITY</th>
                            <th style='text-align: left;'>TOTAL</th>
                            <th style='text-align: left;'>REMOVE</th>
                        </tr>
                    </thead>
                    <tbody id='cart-item'>
                        <?php foreach ($items as $rows): ?>
                            <tr data-id='<?= $rows['id'] ?>' data-price='<?= $rows['price'] ?>'>
                                <td class='product-details' data-label="Product">
                                    <div id="image"><img src='<?= $rows['image'] ?>' alt='<?= htmlspecialchars($rows['name']) ?>'></div>
                                    <div class='info-part'>
                                        <p><?= htmlspecialchars($rows['name']) ?></p>
                                        <p>RM<?= number_format($rows['price'], 2) ?></p>
                                    </div>
                                </td>
                                <td data-label="Quantity">
                                    <div class="quantity">
                                        <i class="fa-solid fa-minus" data-action="minus"></i>
                                        <span class="qty"><?= $rows['quantity'] ?></span>
                                        <i class="fa-solid fa-plus" data-action="plus"></i>
                                    </div>
                                </td>
                                <td class='total' data-label="Total">RM<?= number_format($rows['subtotal'], 2) ?></td>
                                <td id="cartDelete" data-label="Remove">
                                    <i class="fa-solid fa-trash-can fa-lg delete-btn" data-action="delete"></i>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class='summary'>
                <p style="font-weight: bold;">Subtotal: <span id='subtotal'>RM<?= number_format($total, 2) ?></span></p>
                <h6 style='margin-top: 0;'>Tax included. Complimentary Shipping on all orders</h6>
            </div>

            <div class='cart-button'>
                <button onclick="window.location.href='../Checkout'">Check Out</button>
                <button onclick="window.location.href='../HomepageProducts'">Continue Shopping</button>
            </div>
        <?php endif; ?>
    </content>

    <script src="cart.js"></script>

    <?php include("../includes/footer.php"); ?>
</body>
</html>
