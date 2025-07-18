<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>AutoParts - Home</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>

<!-- 🔵 Login Popup -->
<div class="login-popup" id="loginPopup">
  <div class="popup-box">
    <a href="login.php" class="login-btn">Login Now</a>
    <div class="popup-arrow"></div>
  </div>
</div>

<header class="main-nav">
  <div class="logo">
    <a href="index.html"><img src="logo.png" alt="AutoParts Logo" /></a>
  </div>

  <div class="search-box">
    <input type="text" placeholder="Search in AutoParts Store" />
    <button><i class="fas fa-search"></i></button>
  </div>

  <div class="nav-links">
    <div class="dropdown">
      <a href="login.php" id="navLoginBtn" class="nav-login-btn">
        <i class="fas fa-user"></i>
        Login
        <i class="fas fa-chevron-down chevron"></i>
      </a>
      <ul class="login-menu">
        <li class="header">
          <span>New customer?</span><a href="signup.php">Sign Up</a>
        </li>
        <li><a href="#"><i class="fas fa-user-circle"></i> My Profile</a></li>
        <li><a href="#"><i class="fas fa-box"></i> Orders</a></li>
        <li><a href="#"><i class="fas fa-heart"></i> Wishlist</a></li>
      </ul>
    </div>
    <a href="#"><i class="fas fa-shopping-cart"></i> Cart</a>
  </div>

  <div class="menu-toggle"><i class="fas fa-bars"></i></div>
</header>

<!-- Sidebar Menu -->
<div class="sidebar" id="sidebar">
  <div class="sidebar-header">
    <span>Menu</span>
    <i class="fas fa-times" id="closeSidebar"></i>
  </div>
  <a href="#"><i class="fas fa-question-circle"></i> FAQ</a>
  <a href="#"><i class="fas fa-envelope"></i> Contact Us</a>
</div>

<div class="overlay" id="overlay"></div>

<!-- Category Navigation -->
<nav class="category-bar">
  <a href="#">Suspension</a>
  <a href="#">Body</a>
  <a href="#">HVAC</a>
  <a href="#">Engine</a>
  <a href="#">Transmission</a>
  <a href="#">Brake</a>
  <a href="#">Electrical</a>
  <a href="#">Accessories</a>
</nav>

<!-- JavaScript -->
<script>
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const loginPopup = document.getElementById('loginPopup');
  const navLoginBtn = document.getElementById('navLoginBtn');
  const popupBox = document.querySelector('.popup-box');

  document.querySelector('.menu-toggle').onclick = () => {
    sidebar.classList.add('active');
    overlay.classList.add('active');
  };

  document.getElementById('closeSidebar').onclick = () => {
    sidebar.classList.remove('active');
    overlay.classList.remove('active');
  };

  overlay.onclick = () => {
    sidebar.classList.remove('active');
    overlay.classList.remove('active');
  };

  // ✅ Show login popup once per session
  setTimeout(() => {
    if (!sessionStorage.getItem('loginPopupShown')) {
      const rect = navLoginBtn.getBoundingClientRect();
      loginPopup.style.top = rect.bottom + window.scrollY + 10 + "px";
      loginPopup.style.left = rect.left + window.scrollX + "px";
      loginPopup.style.display = 'block';

      sessionStorage.setItem('loginPopupShown', 'true');

      // 🔁 Shake every 3 seconds for 15 seconds
      let shakeCount = 0;
      const maxShakes = 5;
      const shakeInterval = setInterval(() => {
        popupBox.classList.add('shaking');
        setTimeout(() => {
          popupBox.classList.remove('shaking');
        }, 500);
        shakeCount++;
        if (shakeCount >= maxShakes) {
          clearInterval(shakeInterval);
        }
      }, 3000);

      setTimeout(() => {
        loginPopup.style.display = 'none';
      }, 15000);
    }
  }, 2000);
</script>

</body>
</html>
