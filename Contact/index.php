<?php
session_start();

$server = "localhost";
$db_user = "root";
$password = "";
$db = "aurevia_db";

$conn = mysqli_connect($server, $db_user, $password, $db);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$userID = $_SESSION['userID'];
$message = "";

$query = "SELECT * FROM user WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $userID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Contact Us</title>
    <link rel="stylesheet" href="../style/contactStyle.css" />
</head>

<body>

    <?php include("../includes/header.php"); ?>

    <div id="contactPage">
        <!-- form to submit comments or complaints -->
        <section id="getInTouch">
            <h2>Get in Touch</h2>
            <form action="post-message.php" method="post" id="contactForm">

                <div class="form-group">
                    <label for="name">Username:</label>
                    <input type="text" id="name" name="name" value="<?= $user['username'] ?? '' ?>" />
                    <div id="messageName" class="message"></div>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?= $user['email'] ?? '' ?>" />
                    <div id="messageEmail" class="message"></div>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number:</label>
                    <input type="tel" id="phone" name="phone" value="<?= $user['phone'] ?? '' ?>" />
                    <div id="messagePhone" class="message"></div>
                </div>

                <div class="form-group">
                    <label for="comment">Comment:</label>
                    <textarea id="comment" name="comment" placeholder="How can I help you?"></textarea>
                    <div id="messageComment" class="message"></div>
                </div>

                <div class="form-group">
                    <input type="button" id="submitBtn" value="Submit" onclick="validateForm()" />
                </div>
            </form>
        </section>

        <!-- Contact information of our shop -->
        <section id="contactInfo">
            <h2 style="text-align: center;">Contact Information</h2>
            <table>
                <!-- Whatsapp number -->
                <tr>
                    <td>
                        <img src="LogoImages/whatsapp.png" weight="20px" height="20px">
                    </td>
                    <td>
                        <a href="https://wa.me/60171235677" target="_blank">+6017-1235677</a>
                    </td>
                </tr>
                <!-- gmail account -->
                <tr>
                    <td>
                        <img src="LogoImages/gmail.jpg" weight="25px" height="25px">
                    </td>
                    <td>
                        <a href="mailto:Aurévia@gmail.com" target="_blank">Aurévia@gmail.com</a>
                    </td>
                </tr>
                <!-- facebook account -->
                <tr>
                    <td>
                        <img src="LogoImages/facebook.png" weight="25px" height="25px">
                    </td>
                    <td>
                        <a href="https://www.facebook.com/lumina" target="_blank">Facebook</a>
                    </td>
                </tr>
                <!-- instagram account -->
                <tr>
                    <td>
                        <img src="LogoImages/instagram.png" weight="20px" height="20px">
                    </td>
                    <td>
                        <a href="https://www.instagram.com/lumina" target="_blank">Instagram</a>
                    </td>
                </tr>
                <!-- shop address -->
                <tr>
                    <td>
                        <img src="LogoImages/location.png" weight="20px" height="20px">
                    </td>
                    <td>
                        <a href="https://maps.app.goo.gl/yKZwAUmYgG8WWz3N7" target="_blank">Address</a>
                    </td>
                </tr>
            </table>
        </section>
    </div>
    <?php include("../includes/footer.php"); ?>

    <script>
        function validateForm() {
            var isValid = true;
            var form = document.getElementById('contactForm');

            // Clear previous error messages
            document.querySelectorAll('.message').forEach(function (div) {
                div.textContent = '';
            });

            // Validate Username
            if (form['name'].value.trim() === '') {
                document.getElementById('messageName').textContent = 'Username is required.';
                isValid = false;
            }

            // Validate Email
            let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (form['email'].value.trim() === '') {
                document.getElementById('messageEmail').textContent = 'Email is required.';
                isValid = false;
            } else if (!emailPattern.test(form['email'].value)) {
                document.getElementById('messageEmail').textContent = 'Email is not valid.';
                isValid = false;
            }

            // Validate Phone
            if (form['phone'].value.trim() === '') {
                document.getElementById('messagePhone').textContent = 'Phone number is required.';
                isValid = false;
            } else if (isNaN(form['phone'].value.trim())) {
                document.getElementById('messagePhone').textContent = 'Phone must contain only numbers.';
                isValid = false;
            }

            // Validate Comment
            if (form['comment'].value.trim() === '') {
                document.getElementById('messageComment').textContent = 'Comment is required.';
                isValid = false;
            }

            // Submit only if valid
            if (isValid) {
                form.submit();
                alert("Your message has been submitted successfully!");
                window.location.href = "../HomepageProducts";
            }
        }
    </script>

</body>

</html>