<!DOCTYPE html>
<html>

<head>
    <title>Aurévia | Search</title>
    <link rel="stylesheet" href="../style/productListingStyle.css">
    <style>
        .search-box {
            text-align: center;
            margin: 20px;
        }

        .search-box input[type="text"] {
            width: 420px;
            height: 6vh;
            padding: 8px;
            border: none;
            border-radius: 5px;
        }

        .search-box input {
            border: 1px solid #0A171A;
            padding: 8px;
            border-radius: 5px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .search-box input:focus {
            border-color: #0A171A;
            /* custom border color when focused */
            box-shadow: 0 0 5px rgba(119, 140, 153, 0.5);
            /* optional glow */
        }
    </style>
</head>

<body class="mainBody">
    <?php include('../includes/header.php'); ?>

    <div class="search-box">
        <input type="text" id="searchInput" placeholder="Search for products...">
    </div>

    <div id="results" class="product-list">
        <!-- Products will load here -->
    </div>

    <?php include('../includes/footer.php'); ?>

    <script>
        const input = document.getElementById("searchInput");
        const resultsDiv = document.getElementById("results");

        function fetchProducts(query = "") {
            let xhr = new XMLHttpRequest();
            xhr.open("GET", "search.php?q=" + encodeURIComponent(query), true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    resultsDiv.innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }

        // Fetch all products on page load
        window.onload = function () {
            fetchProducts();
        };

        // Fetch filtered products when typing
        input.addEventListener("keyup", function () {
            fetchProducts(input.value.trim());
        });
    </script>
</body>

</html>