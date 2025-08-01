<?php
include 'db.php';
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, full_name, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $full_name, $hashedPassword, $role);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['full_name'] = $full_name;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $role;

            if ($role === 'admin') {
                header("Location: dashboard/admin.php");
            } elseif ($role === 'seller') {
                header("Location: dashboard/seller.php");
            } else {
                header("Location: dashboard/buyer.php");
            }
            exit;
        } else {
            $message = "❌ Incorrect password.";
        }
    } else {
        $message = "❌ User not found.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>AutoParts – Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    .form-control {
      position: relative;
    }

    .form-control input[type="password"],
    .form-control input[type="text"] {
      width: 100%;
      padding-right: 40px; /* space for icon */
    }

    .toggle-password {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #666;
    }
  </style>
</head>
<body>
  <!-- Header Logo -->
  <header class="main-header">
    <img src="images/logo.png" alt="AutoParts Logo" class="site-logo">
  </header>

  <!-- Hero Background -->
  <div class="hero">
    <div class="hero-content">
      <h1>Log in to<br>buy and sell<br>auto parts</h1>
      <div class="buttons">
        <a href="login.php" class="btn login">Log in</a>
        <a href="signup.php" class="btn signup">Sign up</a>
      </div>
    </div>
  </div>

  <!-- Login Modal -->
  <div class="login-modal" role="dialog" aria-modal="true">
    <div class="modal-header">
      <button class="close-btn" onclick="window.history.back()">&times;</button>
      <h1>Welcome Back</h1>
    </div>
    <p class="subtext">Login to continue shopping with AutoParts</p>

    <?php if (!empty($message)) echo "<p style='color:#fff; text-align:center;'>$message</p>"; ?>

    <form class="login-form" method="POST" action="">
      <div class="form-control">
        <input type="email" name="email" placeholder="E‑mail" required />
      </div>
      <div class="form-control">
        <input type="password" name="password" placeholder="Password" id="password" required />
        <i class="fa-solid fa-eye toggle-password" id="togglePassword"></i>
      </div>

      <button class="login-btn" type="submit">Login</button>
    </form>

    <p class="signup-link">New to AutoParts? <a href="signup.php">Create an account</a></p>
  </div>

  <script>
    const togglePassword = document.getElementById("togglePassword");
    const password = document.getElementById("password");

    togglePassword.addEventListener("click", function () {
      const type = password.getAttribute("type") === "password" ? "text" : "password";
      password.setAttribute("type", type);
      this.classList.toggle("fa-eye-slash");
    });
  </script>
</body>
</html>
