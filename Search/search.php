<?php
$server = "localhost";
$username = "root";
$password = "";
$db = "aurevia_db";

$conn = mysqli_connect($server, $username, $password, $db);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$search = isset($_GET['q']) ? trim($_GET['q']) : "";

if ($search !== "") {
    $searchTerm = "%" . $search . "%";
    $query = "SELECT id, name, brand, price, image, briefDescription 
              FROM products 
              WHERE name LIKE ? 
                 OR brand LIKE ? 
                 OR category LIKE ?
                 OR description LIKE ?
                 OR ingredients LIKE ?
              ORDER BY name ASC";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
} else {
    $query = "SELECT id, name, brand, price, image, briefDescription 
              FROM products 
              ORDER BY name ASC";
    $stmt = mysqli_prepare($conn, $query);
}

mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $productLink = "../HomepageProducts/productDetailsPage.php?id=" . htmlspecialchars($row['id']);
        echo "
        <div class='product-card'>
            <a href='{$productLink}' class='card-link'>
                <img src='" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['name']) . "'>
                <h5>" . htmlspecialchars($row['brand']) . "</h5>
                <h4>" . htmlspecialchars($row['name']) . "</h4>
                <p>" . htmlspecialchars($row['briefDescription']) . "</p>
                <p class='price'>RM " . number_format($row['price'], 2) . "</p>
                <button>Add to Cart</button>
            </a>
        </div>
        ";
    }
} else {
    echo "<p>No products found.</p>";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>