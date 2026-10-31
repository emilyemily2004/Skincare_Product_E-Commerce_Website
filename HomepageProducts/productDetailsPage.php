<!DOCTYPE html>
<html>

<head>
    <title>Aurévia | Product Details</title>
    <link rel="stylesheet" href="../style/productDetailsStyle.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
</head>

<body class="mainBody">
    <?php include('../includes/header.php'); ?>

    <div id="productDetails"></div>

    <?php
    $conn = mysqli_connect("localhost","root","","aurevia_db");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $productId = mysqli_real_escape_string($conn, $_GET['id']); 
    $query = "SELECT * FROM products WHERE id = '$productId' ";    
    $result = mysqli_query($conn,$query);
    $product = mysqli_fetch_assoc($result);

    if ($product) {
        if (!empty($product['skinType'])) {
            $product['skinType'] = json_decode($product['skinType'], true);
        } else {
            $product['skinType'] = [];
        }
        echo "<script>const product = " . json_encode($product) . ";</script>";
    } else {
        echo "<script>const product = null;</script>";
    }

    mysqli_close($conn);
    ?> 

    <script>
        const params = new URLSearchParams(window.location.search);
        const productId = params.get("id");

        fetch(`getProductDetails.php?id=${productId}`)
            .then(res => res.json())
            .then(data => {
                const productDetailsBlock = document.getElementById("productDetails");

                if (data.success) {
                    const product = data.product;

                    productDetailsBlock.innerHTML = `
                        <div class="product-img">
                            <img src="${product.image}" alt="${product.name}">
                        </div>
                        <div class="product-info">
                            <div class="product-header">
                                <h3>${product.brand}</h3>
                                <h1>${product.name}</h1>
                                <p>${product.briefDescription}</p>
                            </div>

                            <h2>RM ${parseFloat(product.price).toFixed(2)}</h2>

                            <div class="btn">
                                <div class="quantity">
                                    <button class="minusBtn" id="minusBtn" type="button">
                                        <i class="fa-solid fa-minus"></i>
                                    </button>

                                    <input type="number" id="quantityInput" value="1" min="1" step="1" />

                                    <button class="plusBtn" id="plusBtn" type="button">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>

                                <button id="cart">Add to Cart</button>
                            </div>

                            <div class="expandable-section">
                                <div class="expandable-header" onclick="toggleContent('description')">
                                    <p><strong>DETAILS:</strong></p>
                                    <span class="expand-toggle">+</span>
                                </div>
                                <p id="description" class="expandable">${product.description}</p>
                            </div>

                            <div class="expandable-section">
                                <div class="expandable-header" onclick="toggleContent('ingredients')">
                                    <p><strong>INGREDIENTS:</strong></p>
                                    <span class="expand-toggle">+</span>
                                </div>
                                <p id="ingredients" class="expandable">${product.ingredients}</p>
                            </div>

                            <div class="expandable-section">
                                <div class="expandable-header" onclick="toggleContent('skinType')">
                                    <p><strong>SUITABLE SKIN TYPE:</strong></p>
                                    <span class="expand-toggle">+</span>
                                </div>
                                <p id="skinType" class="expandable">
                                    ${product.skinType.map(type => type.charAt(0).toUpperCase() + type.slice(1)).join(", ")} skin
                                </p>
                            </div>
                        </div>
                    `;

                    document.getElementById("cart").addEventListener("click", addToCart);

                    document.getElementById("minusBtn").addEventListener("click", function() {
                        const quantityInput = document.getElementById("quantityInput");
                        if (quantityInput.value > 1) {
                            quantityInput.value = parseInt(quantityInput.value) - 1;
                        }
                    });

                    document.getElementById("plusBtn").addEventListener("click", function() {
                        const quantityInput = document.getElementById("quantityInput");
                        quantityInput.value = parseInt(quantityInput.value) + 1;
                    });

                } else {
                    productDetailsBlock.innerHTML = `<p>${data.message}</p>`;
                }
        });


        function toggleContent(section) {
            const content = document.getElementById(section);
            const toggleButton = content.previousElementSibling.querySelector(".expand-toggle");
            if (content.style.display === "none") {
                content.style.display = "block";
                toggleButton.textContent = "-"; // Change to collapse
            } else {
                content.style.display = "none";
                toggleButton.textContent = "+"; // Change to expand
            }
        }

        function addToCart() {
            const quantity = parseInt(document.getElementById("quantityInput").value);
            const data = JSON.stringify({
                productId: productId,
                quantity: quantity
            });

            // Create XMLHttpRequest object
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "addToCart.php", true);
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) { // request is done
                    if (xhr.status === 200) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            alert(response.message);
                        } catch (e) {
                            console.error("Invalid JSON response:", xhr.responseText);
                        }
                    } else {
                        console.error("Request failed with status:", xhr.status);
                    }
                }
            };
            xhr.send(data);
        }

    </script>

    <?php include('../includes/footer.php'); ?>
</body>

</html>
