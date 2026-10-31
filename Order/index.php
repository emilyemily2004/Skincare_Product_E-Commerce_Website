<!DOCTYPE html>
<html>

<head>
    <title>Order Screen</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../style/orderStyle.css">
</head>

<body>
    <?php
    include("../includes/header.php");

    $conn = mysqli_connect("localhost", "root", "", "aurevia_db");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    function getUserName($conn, $userID)
    {
        $query = "SELECT username FROM user WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $userID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        return ($row = mysqli_fetch_assoc($result)) ? $row['username'] : null;
    }

    function getUserOrders($conn, $userID)
    {
        $query = "SELECT * FROM orders WHERE userID = ? ORDER BY orderDate DESC";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $userID);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_get_result($stmt);
    }

    function getOrderItems($conn, $orderID)
    {
        $query = "SELECT oi.quantity, p.name, p.price, p.image
                  FROM orderItem oi 
                  JOIN products p ON oi.productID = p.id
                  WHERE oi.orderID = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $orderID);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_get_result($stmt);
    }

    session_start();
    $userID = $_SESSION['userID'] ?? 0;

    $userName = getUserName($conn, $userID);
    $orders = getUserOrders($conn, $userID);
    ?>

    <h2 id="title">My Orders</h2>
    <div id="orders">
        <?php if (mysqli_num_rows($orders) > 0): ?>
            <?php while ($order = mysqli_fetch_assoc($orders)): ?>
                <?php $statusCategory = strtolower(trim($order['status'])); ?>
                <div class="orders">
                    <!-- Order Header -->
                    <div class="order-header">
                        <span class="status <?= $statusCategory ?>">
                            <?= htmlspecialchars($order['status']) ?>
                        </span>
                    </div>

                    <div class="order-time">
                        <span>
                            <?= htmlspecialchars($order['orderDate']) ?> |
                            Order ID: <?= htmlspecialchars($order['id']) ?>
                        </span>
                        <div class="total">Total: RM<?= htmlspecialchars($order['totalPrice']) ?></div>
                    </div>
                    <hr class="line" />

                    <!-- Order Items -->
                    <?php $items = getOrderItems($conn, $order['id']); ?>
                    <?php while ($item = mysqli_fetch_assoc($items)): ?>
                        <div class="order-body">
                            <div class="order-product">
                                <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>"
                                    class="product-img">
                                <div class="order-details">
                                    <h3><?= htmlspecialchars($item['name']) ?></h3>
                                    <div class="price-line">
                                        RM<?= number_format($item['price'], 2) ?> × <?= htmlspecialchars($item['quantity']) ?>
                                    </div>
                                    <div class="subtotal">
                                        RM<?= number_format($item['price'] * $item['quantity'], 2) ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <?php endwhile; ?>

                    <!-- Order Footer -->
                    <div class="order-footer">
                        <hr class="line" style="margin-top: 25px;">
                        <div class="address">
                            <p style="font-size: 15px">
                                Delivery Address: <?= htmlspecialchars($order['address']) ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align: center; margin: 15vh 0;">No orders found.</p>
        <?php endif; ?>
    </div>

    <?php include("../includes/footer.php"); ?>
</body>

</html>