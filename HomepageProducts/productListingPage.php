<!DOCTYPE html>
<html>

<head>
    <title>Aurévia | Category</title>
    <link rel="stylesheet" href="../style/productListingStyle.css">
</head>

<body class="mainBody">
    <?php include('../includes/header.php'); ?>

    <div id="categoryDescription"></div>
    <div class="product-list" id="productList"></div>

    <script src="categories.js"></script>
    <script src="brands.js"></script>

    <?php
    $conn = mysqli_connect("localhost", "root", "", "aurevia_db");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = "SELECT id, brand, productKey, name, price, briefDescription, category, skinType, image FROM products";
    $result = mysqli_query($conn, $query);

    $products = [];
    while ($row = mysqli_fetch_assoc($result)) {
        if (!empty($row['skinType'])) {
            $row['skinType'] = explode(",", $row['skinType']);
        } else {
            $row['skinType'] = [];
        }
        $products[] = $row;
    }

    echo "<script>const products = " . json_encode($products) . ";</script>";

    mysqli_close($conn);
    ?>

    <script>
        let originalProducts = products;

        const params = new URLSearchParams(window.location.search);
        const selectedCat = params.get("cat");
        const selectedBrand = params.get("brand");
        const selectedConcerns = params.get("concern");

        const categoryBlock = document.getElementById("categoryDescription");
        const productList = document.getElementById("productList");

        const foundBrand = brands.find(b => b.key.toLowerCase() === (selectedBrand || "").toLowerCase());
        const foundCat = categories.find(c => c.category.toLowerCase() === (selectedCat || 'all').toLowerCase());

        let filteredProducts = originalProducts;

        if (selectedCat && selectedCat.toLowerCase() !== "all") {
            filteredProducts = filteredProducts.filter(p =>
                p.category.toLowerCase() === selectedCat.toLowerCase()
            );
        }

        if (foundBrand) {
            filteredProducts = filteredProducts.filter(p =>
                p.productKey.toLowerCase() === foundBrand.key.toLowerCase()
            );
        }

        if (foundBrand) {
            categoryBlock.innerHTML = `
                <h1>${foundBrand.name}</h1>
                <p id="brandDescription">${foundBrand.description}</p>
                <div class="controls">
                    <div class="left-controls">
                        <div class="selection">
                            <label for="skinType">Filter:</label>
                            <select id="skinType">
                                <option value="">All</option>
                                <option value="acne">Acne</option>
                                <option value="aging">Aging & Wrinkles</option>
                                <option value="dehydrated">Dehydrated</option>
                                <option value="sensitive">Sensitive & Redness</option>
                                <option value="uneven">Uneven Skin</option>
                            </select>
                        </div>
                        <div class="selection">
                            <label for="sort">Sort by:</label>
                            <select id="sort">
                                <option value="default">Default</option>
                                <option value="priceLowHigh">Price: Low → High</option>
                                <option value="priceHighLow">Price: High → Low</option>
                                <option value="nameAZ">Name: A → Z</option>
                                <option value="nameZA">Name: Z → A</option>
                            </select>
                        </div>
                    </div>
                    <div class="right-controls">
                        <span>${filteredProducts.length} products</span>
                    </div>
                </div>
            `;
        } else if (foundCat) {
            categoryBlock.innerHTML = `
                <h1>${foundCat.name}</h1>
                <p id="catDescription">${foundCat.description}</p>
                <div class="controls">
                    <div class="left-controls">
                        <div class="selection">
                            <label for="skinType">Filter:</label>
                            <select id="skinType">
                                <option value="">All</option>
                                <option value="acne">Acne</option>
                                <option value="aging">Aging & Wrinkles</option>
                                <option value="dehydrated">Dehydrated</option>
                                <option value="sensitive">Sensitive & Redness</option>
                                <option value="uneven">Uneven Skin</option>
                            </select>
                        </div>
                        <div class="selection">
                            <label for="sort">Sort by:</label>
                            <select id="sort">
                                <option value="default">Default</option>
                                <option value="priceLowHigh">Price: Low → High</option>
                                <option value="priceHighLow">Price: High → Low</option>
                                <option value="nameAZ">Name: A → Z</option>
                                <option value="nameZA">Name: Z → A</option>
                            </select>
                        </div>
                    </div>
                    <div class="right-controls">
                        <span>${filteredProducts.length} products</span>
                    </div>
                </div>
            `;
        }

        function renderProducts(list) {
            productList.innerHTML = "";

            const productCount = list.length;
            const productCountText = `${productCount} product${productCount !== 1 ? 's' : ''}`;

            const countDisplay = document.querySelector('.right-controls span');
            if (countDisplay) {
                countDisplay.textContent = productCountText;
            }

            if (list.length > 0) {
                list.forEach(product => {
                    const card = document.createElement("div");
                    card.classList.add("product-card");

                    const productLink = selectedCat
                        ? `productDetailsPage.php?cat=${selectedCat}&id=${product.id}`
                        : selectedBrand
                            ? `productDetailsPage.php?brand=${selectedBrand}&id=${product.id}`
                            : `productDetailsPage.php?id=${product.id}`;

                    card.innerHTML = `
                    <a href="${productLink}" class="card-link">
                        <img src="${product.image}" alt="${product.name}">
                        <h5>${product.brand}</h5>
                        <h4>${product.name}</h4>
                        <p>${product.briefDescription}</p>
                        <p class="price">RM ${parseFloat(product.price).toFixed(2)}</p>
                    </a>
                        <button class="cartBtn" data-id="${product.id}">Add to Cart</button>
                `;
                    productList.appendChild(card);
                });

                document.querySelectorAll(".cartBtn").forEach(btn => {
                    btn.addEventListener("click", function () {
                        const productId = this.dataset.id;
                        addToCart(productId);
                    });
                });

            } else {
                productList.innerHTML = `<p style="text-align:center">No products available.</p>`;
            }
        }

        function applyFilterSort() {
            const skinType = document.getElementById("skinType")?.value || "";
            const sort = document.getElementById("sort")?.value || "";
            const cat = selectedCat || "";
            const brand = selectedBrand || "";

            fetch(`getProducts.php?cat=${cat}&brand=${brand}&skinType=${skinType}&sort=${sort}`)
                .then(response => response.json())
                .then(data => {
                    renderProducts(data);
                })
                .catch(error => console.error("Error fetching products:", error));
        }

        document.addEventListener("change", (e) => {
            if (e.target.id === "skinType" || e.target.id === "sort") {
                applyFilterSort();
            }
        });

        renderProducts(filteredProducts);
    </script>
    <script src="addToCart.js"></script>

    <?php include('../includes/footer.php'); ?>
</body>

</html>