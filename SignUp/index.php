<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
  <link rel="stylesheet" href="../style/signupStyle.css">
  <style>
    .message-success {
      color: green;
      font-weight: bold;
      margin: 10px 0;
    }
    .message-error {
      color: red;
      font-weight: bold;
      margin: 10px 0;
    }
  </style>
</head>

<body>
  <div class="container">

    <!-- LEFT SIDE -->
    <div class="left">
      <video autoplay muted loop playsinline>
        <source src="Intro.mp4" type="video/mp4">
        Your browser does not support the video tag.
      </video>
      <div class="overlay">
        <img class="logo" src="Logo.png" alt="Shop Logo">
        <h1 class="shop-name">Welcome!</h1>
        <p class="welcome">Your Beauty Journey, Just One Sign Up Away</p>
      </div>
    </div>

    <!-- RIGHT SIDE -->
    <div class="right">
      <div class="signUp">
        <form id="signupForm" method="POST" action="signUpAction.php" onsubmit="return validateForm(event);">
          <a href="../index.php" id="backButton">←</a>
          <h2>Join Us!</h2>
          <span>Please enter your details</span>
          <br/>

          <!-- PHP message -->
          <div id="register_message">
          <?php if (!empty($_GET['message'])): ?>
              <?php 
                $status = $_GET['status'] ?? 'error'; 
                $class = $status === 'success' ? 'message-success' : 'message-error';
              ?>
              <p class="<?php echo $class; ?>">
                <?php echo $_GET['message']; ?>
              </p>
          <?php endif; ?>
        </div>


          <label for="username">Username</label>
          <input type="text" id="username" name="username" placeholder="Username">
          <span id="nameError" class="error"></span>

          <label for="email">Email</label>
          <input type="text" id="email" name="email" placeholder="Email Address">
          <span id="emailError" class="error"></span>

          <label for="phone">Phone</label>
          <input type="tel" id="phone" name="phone" placeholder="Phone Number">
          <span id="phoneError" class="error"></span>

          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Password">
          <div id="passwordError" class="error"></div>

          <label for="confirm-password">Confirm Password</label>
          <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
          <span id="confirmPasswordError" class="error"></span>

          <button class="signUpButton" type="submit">Sign Up</button>
        </form>
      </div>
    </div>
  </div>

  <script>
    function validateForm(event) {
      var isValid = true;
      var form = document.getElementById('signupForm');

      // Clear errors
      document.querySelectorAll('.error').forEach(el => el.textContent = '');

      // Username
      if (form['username'].value.trim() === '') {
        document.getElementById('nameError').textContent = 'Username is required.';
        isValid = false;
      }

      // Email
      let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
      if (form['email'].value.trim() === '') {
        document.getElementById('emailError').textContent = 'Email is required.';
        isValid = false;
      } else if (!emailPattern.test(form['email'].value)) {
        document.getElementById('emailError').textContent = 'Email is not valid.';
        isValid = false;
      }

      // Phone
      if (form['phone'].value.trim() === '') {
        document.getElementById('phoneError').textContent = 'Phone number is required.';
        isValid = false;
      } else if (!/^\d{10,15}$/.test(form['phone'].value)) {
        document.getElementById('phoneError').textContent = 'Enter a valid phone number (10-15 digits).';
        isValid = false;
      }

      // Password
      const password = form['password'].value.trim();
      const passwordRegex = /^(?=.*[A-Z])(?=.*[!@#$%^&*(),.?":{}|<>]).{8,}$/;
      if (password === '') {
        document.getElementById('passwordError').textContent = 'Password is required.';
        isValid = false;
      } else if (!passwordRegex.test(password)) {
        document.getElementById('passwordError').textContent =
          'Password must be at least 8 characters, include at least 1 uppercase letter and 1 special character.';
        isValid = false;
      }

      // Confirm Password
      if (form['confirm_password'].value.trim() === '') {
        document.getElementById('confirmPasswordError').textContent = 'Please confirm your password.';
        isValid = false;
      } else if (form['password'].value !== form['confirm_password'].value) {
        document.getElementById('confirmPasswordError').textContent = 'Passwords do not match.';
        isValid = false;
      }

      if (!isValid) event.preventDefault();
      return isValid;
    }
  </script>
</body>

</html>
