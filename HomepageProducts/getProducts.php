<?php
    $conn = mysqli_connect("localhost","root","","aurevia_db");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $cat = $_GET['cat'] ?? '';
    $brand = $_GET['brand'] ?? '';
    $skinType = $_GET['skinType'] ?? '';
    $sort = $_GET['sort'] ?? '';

    $query = "SELECT id, brand, productKey, name, price, briefDescription, category, skinType, image FROM products WHERE 1=1";

    if (!empty($cat) && strtolower($cat) !== "all") {
        $query .= " AND LOWER(category) = '".mysqli_real_escape_string($conn, strtolower($cat))."'";
    }
    if (!empty($brand)) {
        $query .= " AND LOWER(productKey) = '".mysqli_real_escape_string($conn, strtolower($brand))."'";
    }
    if (!empty($skinType)) {
        $query .= " AND LOWER(skinType) LIKE '%".mysqli_real_escape_string($conn, strtolower($skinType))."%'";
    }

    if ($sort === "priceLowHigh") {
        $query .= " ORDER BY price ASC";
    } elseif ($sort === "priceHighLow") {
        $query .= " ORDER BY price DESC";
    } elseif ($sort === "nameAZ") {
        $query .= " ORDER BY name ASC";
    } elseif ($sort === "nameZA") {
        $query .= " ORDER BY name DESC";
    }

    $result = mysqli_query($conn,$query);

    $products = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $row['skinType'] = !empty($row['skinType']) ? explode(",", $row['skinType']) : [];
        $products[] = $row;
    }

    mysqli_close($conn);

    header('Content-Type: application/json');
    echo json_encode($products);
?>