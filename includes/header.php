<header class="pageHeader">
    <link rel="stylesheet" href="../style/headerStyle.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&display=swap"
        rel="stylesheet">

    <!-- Store Name (Aurévia) -->
    <a href="../HomepageProducts" id="storeName">Aurévia</a>


    <div class="hamburger-menu" id="hamburgerMenu">
        <i class="fa fa-bars"></i>
    </div>

    <div class="navigationBanner" id="navLinks">
        <div class="navigationLinks">
            <a href="../HomepageProducts" class="category">Home</a>
            <a href="../HomepageProducts/productListingPage.php?cat=all" class="category">All Products</a>
            <a href="../HomepageProducts/productListingPage.php?cat=cleanser" class="category">Cleanser</a>
            <a href="../HomepageProducts/productListingPage.php?cat=toner" class="category">Toner</a>
            <a href="../HomepageProducts/productListingPage.php?cat=moisturizer" class="category">Moisturizer</a>
            <a href="../HomepageProducts/productListingPage.php?cat=serum-treatment" class="category">Serum &
                Treatment</a>
            <a href="../HomepageProducts/productListingPage.php?cat=suncare" class="category">Suncare</a>
            <a href="../HomepageProducts/productListingPage.php?cat=lip-eyeCare" class="category">Lip & Eye Care</a>
        </div>
    </div>

    <div class="bannerRight">
        <a href="../Search"><i class="fa-solid fa-magnifying-glass"></i></a>
        <a href="../Cart"><i class="fa-solid fa-cart-shopping"></i></a>
        <a href="../Order"><i class="fa-solid fa-receipt"></i></a>
        <a href="../Profile"><i class="fa-solid fa-user"></i></a>
        <a href="../logout.php" onclick="return confirm('Are you sure you want to logout?');">
            <i class="fa fa-sign-out" aria-hidden="true"></i>
        </a>
    </div>

    <script>
        const hamburgerMenu = document.getElementById("hamburgerMenu");
        const navLinks = document.querySelector(".navigationBanner");
        const closeMenu = document.getElementById("close");

        hamburgerMenu.addEventListener("click", function () {
            navLinks.classList.toggle("show");
        });

    </script>
</header>