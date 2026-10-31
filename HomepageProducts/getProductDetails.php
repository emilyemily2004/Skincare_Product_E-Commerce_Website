<?php
    $conn = mysqli_connect("localhost","root","","aurevia_db");
    if (!$conn) { 
        die("Connection failed: " . mysqli_connect_error()); 
    }

    $productId = mysqli_real_escape_string($conn, $_GET['id']); 
    $query = "SELECT * FROM products WHERE id = '$productId'";    
    $result = mysqli_query($conn,$query);
    $product = mysqli_fetch_assoc($result);

    if ($product) {
        if (!empty($product['skinType'])) {
            $decoded = json_decode($product['skinType'], true);
            $product['skinType'] = is_array($decoded) ? $decoded : [$product['skinType']];
        } else {
            $product['skinType'] = [];
        }
        echo json_encode(['success'=>true, 'product'=>$product]);
    } else {
        echo json_encode(['success'=>false, 'message'=>'Product not found']);
    }

    mysqli_close($conn);
?>