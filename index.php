<?php
  session_start();
  $error = '';

  $server = "localhost";
  $username = "root";
  $password = "";
  $db = "aurevia_db";

  $conn = mysqli_connect($server, $username, $password, $db);
  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $username = $_POST["username"] ?? '';
      $password = $_POST["password"] ?? '';

      // Fetch user by username
      $stmt = mysqli_prepare($conn, "SELECT * FROM user WHERE username = ?");
      mysqli_stmt_bind_param($stmt, "s", $username);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);

      if ($row = mysqli_fetch_assoc($result)) {
        $hashedPassword = $row['password'] ?? '';
        if (!empty($hashedPassword) && password_verify($password, $hashedPassword)) {
            $_SESSION['userID'] = $row['id']; 
            header("Location: HomepageProducts");
            exit();
        } else {
            $error = "Invalid username or password!";
        }
      } else {
          $error = "No user found with that username!";
      }


      mysqli_stmt_close($stmt);
  }

  mysqli_close($conn);
?>

<!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
  </head>

  <body>
    <div class="container">

      <!-- LEFT SIDE -->
      <div class="left">
        <video autoplay muted loop playsinline>
          <source src="SignUp/Intro.mp4" type="video/mp4">
          Your browser does not support the video tag.
        </video>
        <div class="overlay">
          <img class="logo" src="SignUp/Logo.png" alt="Shop Logo">
          <h1 class="shop-name">Welcome!</h1>
          <p class="welcome">Your Beauty Journey, One Click Away</p>
        </div>
      </div>

      <!-- RIGHT SIDE -->
      <div class="right">

        <!-- Login -->
        <div class="login">
          <form id="loginForm" method="POST">
            <h2>Welcome Back!</h2>
            <span>Please enter your details</span>

            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Password" required>

            

            <!-- <a href="link">Forget Password</a> -->

             <?php if ($error): ?>
              <p style="color:red; margin-bottom: 0%;"><?php echo $error; ?></p>
            <?php endif; ?>

            <button class="loginButton" type="submit">Login</button>

          </form>
          <button type="button" class="signupButton" onclick="navigateToSignup()">
            Not a member? Sign Up Now →
          </button>


          <script>
            function navigateToSignup() {
              window.location.href = "SignUp";
            }
          </script>
        </div>
      </div>
    </div>

  </body>

  </html>