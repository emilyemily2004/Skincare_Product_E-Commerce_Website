<!DOCTYPE html>
<html>

<head>
    <title>Aurévia | Homepage</title>
    <link rel="stylesheet" href="../style/homepageStyle.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body class="mainBody">
    <?php include('../includes/header.php'); ?>

    <div class="bannerPic">
        <div class="bannerText">
            <h1 style="font-size:50px; padding-bottom:20px">Pure beauty, effortlessly.</h1>
            <p style="font-size:22px">Discover skincare that nurtures, protects, and revitalizes.</p>
        </div>
    </div>

    <div class="bestSeller">
        <h2>Best Seller</h2>
        <div class="product-list" id="bestSellerProducts"></div>
    </div>

    <div class="shopByBrand">
        <h2>Shop By Brand</h2>
        <div class="brands">
            <a href="productListingPage.php?brand=avene" class="brandCard">
                <div class="brandImg">
                    <img src="../image/brands/avene.jpg" class="normal" />
                    <img src="../image/brands/aveneProduct.jpg" class="hover" />
                </div>
                <span>Eau Thermale Avène</span>
            </a>

            <a href="productListingPage.php?brand=cerave" class="brandCard">
                <div class="brandImg">
                    <img src="../image/brands/cerave.jpg" class="normal" />
                    <img src="../image/brands/ceraveProduct.jpg" class="hover" />
                </div>
                <span>CeraVe</span>
            </a>

            <a href="productListingPage.php?brand=cetaphil" class="brandCard">
                <div class="brandImg">
                    <img src="../image/brands/cetaphil.jpg" class="normal" />
                    <img src="../image/brands/cetaphilProduct.jpg" class="hover" />
                </div>
                <span>Cetaphil</span>
            </a>

            <a href="productListingPage.php?brand=eucerin" class="brandCard">
                <div class="brandImg">
                    <img src="../image/brands/eucerin.jpg" class="normal" />
                    <img src="../image/brands/eucerinProduct.jpg" class="hover" />
                </div>
                <span>Eucerin</span>
            </a>

            <a href="productListingPage.php?brand=laRochePosay" class="brandCard">
                <div class="brandImg">
                    <img src="../image/brands/laRochePosay.jpg" class="normal" />
                    <img src="../image/brands/laRochePosayProduct.jpg" class="hover" />
                </div>
                <span>La Roche Posay</span>
            </a>
        </div>
    </div>

    <div class="locationBanner">
        <img src="../image/storePic.jpg">
        <div class="locationDescription">
            <h2>Our stores and Location</h2>
            <p>Visit our stores and experience skincare like never before. From expertly curated products to
                personalized advice, our friendly staff are here to help you find the perfect solutions for your skin.
                Whether you're exploring new routines or restocking your favorites, each store is designed to make your
                shopping experience enjoyable, convenient, and full of inspiration</p>
        </div>
    </div>

    <div class="promotionBanner">
        <h2>- Our Promise to You -</h2>
        <p>We believe skincare should be safe, effective, and worry-free.
            That is why we only bring you 100% authentic products from trusted brands, delivered with care right to your
            doorstep. From free gifts to exclusive deals, every order is our way of helping you feel confident in your
            own skin</p>

        <div class="promotionBannerItems">
            <div id="shipping">
                <i class="fa-solid fa-truck"></i>
                <br>
                <label>Free Shipping</label>
                <p>Enjoy fast and free shipping on orders over RM100, straight to your doorstep.</p>
            </div>

            <div id="gifts">
                <i class="fa-solid fa-gift"></i>
                <br>
                <label>Free Gifts</label>
                <p>Receive a surprise gift with every order — a little treat for your skin.</p>
            </div>

            <div id="authentication">
                <i class="fa-solid fa-shield"></i>
                <br>
                <label>100% Authentic</label>
                <p>All our products are 100% genuine, sourced from trusted and reputable brands.</p>
            </div>
        </div>
    </div>

    <?php
    $conn = mysqli_connect("localhost", "root", "", "aurevia_db");
    $query = "SELECT id, name, brand, price, image FROM products WHERE remark = 'bestSeller'";
    $result = mysqli_query($conn, $query);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $bestSellerProducts = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $bestSellerProducts[] = $row;
    }

    mysqli_close($conn);

    echo "<script>const bestSellerProducts = " . json_encode($bestSellerProducts) . ";</script>";
    ?>

    <script>
        function renderBestSellerProducts(products) {
            const productList = document.getElementById("bestSellerProducts");

            products.forEach(product => {
                const card = document.createElement("div");
                card.classList.add("product-card");

                const productDetailsUrl = `productDetailsPage.php?id=${product.id}`;

                card.innerHTML = `
                    <a href="${productDetailsUrl}" style="text-decoration:none; color:#3C4950">
                        <img src="${product.image}" alt="${product.name}">
                        <h5>${product.brand}</h5>
                        <h4>${product.name}</h4>
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
        }

        renderBestSellerProducts(bestSellerProducts);
    </script>
    <script src="addToCart.js"></script>

    <?php include('../includes/footer.php'); ?>
</body>

</html>