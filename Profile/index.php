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

// Handle update request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $newUsername = trim($_POST['username']);
  $email = trim($_POST['email']);
  $phone = trim($_POST['phone']);

  if (!empty($newUsername) && !empty($email) && !empty($phone)) {
    $query = "UPDATE user_table SET username=?, email=?, phone=? WHERE userID=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssss", $newUsername, $email, $phone, $username);

    if (mysqli_stmt_execute($stmt)) {
      $_SESSION['username'] = $newUsername; // Update session
      $message = "Profile updated successfully!";
      $username = $newUsername; // refresh username
    } else {
      $message = "Database error: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
  } else {
    $message = "All fields are required.";
  }
}

$query = "SELECT * FROM user WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $userID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html>

<head>
  <!-- <meta charset="UTF-8"> -->
  <title>Profile</title>
  <link rel="stylesheet" href="../style/profileStyle.css">
</head>

<body>
  <?php include("../includes/header.php"); ?>

  <div class="page-container">
    <main class="main-content">
      <div class="profile-container">
        <!-- Profile Header -->
        <div class="profile-header">
          <div class="card">
            <div class="profile-info">
              <div class="avatar-section">
                <div class="avatar">
                  <div class="avatar-fallback" id="avatarFallback">
                    <?php echo substr($user['username'], 0, 1); ?>
                  </div>
                </div>
                <div class="user-details">
                  <h1 id="userFullName"><?php echo htmlspecialchars($user['username']); ?></h1>
                  <p id="userEmail"><?php echo htmlspecialchars($user['email']); ?></p>
                </div>
              </div>
              <button class="edit-btn" id="editProfileBtn">Edit Profile</button>
            </div>
          </div>
        </div>

        <!-- Account Information -->
        <div class="profile-section">
          <div class="card">
            <div class="card-header">
              <h2 class="card-title">Personal Information</h2>
              <p class="card-description">Update your details</p>
            </div>

            <?php if ($message): ?>
              <p style="color: green; font-weight: bold;"><?php echo $message; ?></p>
            <?php endif; ?>

            <form class="card-content" id="profileForm" method="POST" action="profile.php">
              <div class="form-group">
                <label for="username">Full Name</label>
                <input type="text" id="username" name="username"
                  value="<?php echo htmlspecialchars($user['username']); ?>" disabled>
              </div>
              <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"
                  disabled>
              </div>
              <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>"
                  disabled>
              </div>
              <button type="submit" class="save-btn" id="saveBtn" style="display:none;">
                Save Changes
              </button>
            </form>
          </div>
        </div>
      </div>
    </main>
  </div>

  <script src="profile.js"></script>

  <?php include('../includes/footer.php'); ?>
</body>

</html>