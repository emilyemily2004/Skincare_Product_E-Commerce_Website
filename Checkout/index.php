<html>

<head>
    <title>CheckOut</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../style/checkoutStyle.css">
    <style>
        .message {
            color: red;
            font-style: italic;
        }
    </style>
</head>

<body>
    <?php
    session_start();
    include("../includes/header.php");

    echo "
            <div class='container'>
                <section class='form-section'>
                     <h2>Contact</h2>
        ";

    $server = "localhost";
    $username = "root";
    $password = "";
    $db = "aurevia_db";

    $conn = mysqli_connect($server, $username, $password, $db);
    if (!$conn) {
        die("Connection failed" . mysqli_connect_error());
    }

    $userID = $_SESSION['userID'] ?? 0;

    if ($userID > 0) {
        $stmt = mysqli_prepare($conn, "SELECT email, phone FROM user WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $userID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $email, $phone);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }

    $query = "SELECT ci.id, ci.productID, ci.quantity, ci.subtotal, p.name, p.price, p.image FROM cartItem ci JOIN products p ON ci.productID=p.id WHERE ci.userID=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $userID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $items = [];
    $totalPrice = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = $row;
        $totalPrice += $row['subtotal'];
    }
    mysqli_stmt_close($stmt);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pay_now'])) {
        $errors = [];

        $email = $_POST['email'] ?? '';
        $country = $_POST['country'] ?? '';
        $firstName = $_POST['firstName'] ?? '';
        $lastName = $_POST['lastName'] ?? '';
        $address = $_POST['address'] ?? '';
        $apartment = $_POST['apartment'] ?? '';
        $postcode = $_POST['postcode'] ?? '';
        $city = $_POST['city'] ?? '';
        $state = $_POST['state'] ?? '';
        $phone = $_POST['phone'] ?? '';

        $billingType = $_POST['billing'] ?? 'same-billing';

        // safely fetch billing fields
        $billingEmail = $_POST['billingEmail'] ?? '';
        $billingFirstName = $_POST['billingFirstName'] ?? '';
        $billingLastName = $_POST['billingLastName'] ?? '';
        $billingAddress = $_POST['billingAddress'] ?? '';
        $billingApartment = $_POST['billingApartment'] ?? '';
        $billingPostcode = $_POST['billingPostcode'] ?? '';
        $billingCity = $_POST['billingCity'] ?? '';
        $billingState = $_POST['billingState'] ?? '';
        $billingCountry = $_POST['billingCountry'] ?? '';
        $billingPhone = $_POST['billingPhone'] ?? '';


        // email regex
        $emailPattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i";

        // MAIN ADDRESS VALIDATION
        if (empty($country))
            $errors['country'] = "Invalid Country";
        if (empty($firstName))
            $errors['firstName'] = "Invalid First Name";
        if (empty($lastName))
            $errors['lastName'] = "Invalid Last Name";
        if (empty($email) || !preg_match($emailPattern, $email))
            $errors['email'] = "Invalid Email Format";
        if (empty($address))
            $errors['address'] = "Invalid Address";
        if (empty($apartment))
            $errors['apartment'] = "Invalid Apartment";
        if (empty($postcode))
            $errors['postcode'] = "Invalid Postcode";
        if (empty($city))
            $errors['city'] = "Invalid City";
        if (empty($state))
            $errors['state'] = "Invalid State";
        if (empty($phone)) {
            $errors['phone'] = "Invalid Phone";
        } elseif (!ctype_digit($phone)) {
            $errors['phone'] = "Phone must contain only numbers";
        }

        // BILLING ADDRESS VALIDATION (only if different)
        if ($billingType === 'different-billing') {
            foreach ([
                'billingEmail' => $billingEmail,
                'billingFirstName' => $billingFirstName,
                'billingLastName' => $billingLastName,
                'billingAddress' => $billingAddress,
                'billingPostcode' => $billingPostcode,
                'billingCity' => $billingCity,
                'billingState' => $billingState,
                'billingCountry' => $billingCountry,
                'billingPhone' => $billingPhone,
            ] as $field => $value) {
                if (empty($value)) {
                    $errors[$field] = "Invalid $field";
                }
            }

            if (!ctype_digit($billingPhone)) {
                $errors['billingPhone'] = "Phone must contain only numbers";
            }

            if (!preg_match($emailPattern, $billingEmail)) {
                $errors['billingEmail'] = "Invalid Email Format";
            }
        } else {
            // copy shipping -> billing
            $billingFirstName = $firstName;
            $billingLastName = $lastName;
            $billingAddress = $address;
            $billingPostcode = $postcode;
            $billingCity = $city;
            $billingState = $state;
            $billingCountry = $country;
            $billingPhone = $phone;
            $billingEmail = $email;
        }


        if (empty($errors)) {
            $insertQuery = "INSERT INTO orders (userID, totalPrice, orderDate, status, address) VALUE (?,?,NOW(),?,?)";
            $stmt = mysqli_prepare($conn, $insertQuery);
            $status = 'Pending';
            $fullAddress = $address . ', ' . $apartment . ', ' . $city . ', ' . $state . ', ' . $postcode . ', ' . $country;
            mysqli_stmt_bind_param($stmt, "idss", $userID, $totalPrice, $status, $fullAddress);
            mysqli_stmt_execute($stmt);
            $orderID = mysqli_insert_id($conn);
            mysqli_stmt_close($stmt);

            $insertItem = "INSERT INTO orderItem (orderID, productID, quantity, subtotal) VALUE (?,?,?,?)";
            $stmt = mysqli_prepare($conn, $insertItem);
            foreach ($items as $item) {
                mysqli_stmt_bind_param($stmt, "isid", $orderID, $item['productID'], $item['quantity'], $item['subtotal']);
                mysqli_stmt_execute($stmt);
            }
            mysqli_stmt_close($stmt);

            $deleteQuery = "DELETE FROM cartItem WHERE userID=?";
            $stmt = mysqli_prepare($conn, $deleteQuery);
            mysqli_stmt_bind_param($stmt, "i", $userID);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            echo "<script>
                    alert('Payment Successful! Thank you, $firstName $lastName');
                    window.location.href='../HomepageProducts';
                  </script>";
        } else {
            include("main_form.php");
        }

    } else {
        $errors = [];
        include("main_form.php");
    }

    echo "
            <div class='footer-links'>
                <a>Refund policy</a>
                <a>Shipping</a>
                <a>Privacy policy</a>
                <a>Term of service</a>
            </div>
            </section>

            <div class='summary-section'>
                <div id='cart-item'>";
    foreach ($items as $item) {
        echo "
                        <div class='cart-item'>
                            <img src='" . htmlspecialchars($item['image']) . "' alt='" . htmlspecialchars($item['name']) . "'>
                            <div class='cart-details'>
                                <div class='cart-header'>
                                    <p>" . htmlspecialchars($item['name']) . "</p>
                                </div>
                                <div class='cart-price'>
                                    <p><small>RM" . htmlspecialchars($item['price']) . " x " . htmlspecialchars($item['quantity']) . "</small></p>
                                    <div class='product-price'>RM" . number_format($item['subtotal'], 2) . "</div>
                                </div>
                            </div>
                        </div>";
    }
    echo "</div>

                <div class='summary-line'>
                    <div class='label'>Subtotal</div>
                    <div class='value' id='payment-subtotal'>RM" . number_format($totalPrice, 2) . "</div>
                </div>

                <div class='summary-line'>
                    <div class='label'>Shipping</div>
                    <div class='value' id='shipping-summary' style='color: #555;'>Choose shipping Fee</div>
                </div>

                <div class='summary-line total'>
                    <div class='label'>Total</div>
                    <div class='value'>
                        <div id='payment-total'>RM" . number_format($totalPrice, 2) . "</div>
                    </div>
                </div>

                <p class='tax'>Tax included. Complimentary Shipping on all orders</p>
            </div>
        </div>
        ";
    ?>

    <script>

        const radios = document.querySelectorAll('input[name="billing"]');
        const billingForm = document.getElementById("billing-form");

        radios.forEach(radio => {
            radio.addEventListener("change", () => {
                if (radio.value === "different-billing" & radio.checked) {
                    billingForm.classList.remove("hidden");
                } else {
                    billingForm.classList.add("hidden");
                }
            })
        });

        const shippingDetails = document.querySelectorAll('input[name="shipping"]');
        const shippingSummary = document.getElementById("shipping-summary");
        const totalPrice = document.getElementById("payment-total"); // your total price element
        const subtotalSummary = <?= json_encode($totalPrice) ?>;

        shippingDetails.forEach(details => {
            details.addEventListener("change", function () {
                let shippingCost = 0;
                if (this.value === "west-shipping") {
                    shippingCost = 4.00;
                    shippingSummary.textContent = "RM4.00";
                } else if (this.value === "north-shipping") {
                    shippingCost = 8.00;
                    shippingSummary.textContent = "RM8.00";
                }
                totalPrice.textContent = "RM" + (subtotalSummary + shippingCost).toFixed(2);
            });
        });

    </script>

    <?php
    include("../includes/footer.php");
    ?>
</body>

</html>