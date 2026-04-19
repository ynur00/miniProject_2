

<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>Aquaria Central Ticketing System</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
  font-family: 'Poppins', sans-serif;
  background: #0b0f2a;
  color: white;
}

/* NAVBAR */
.navbar {
  background: transparent;
}

/* HERO */
.hero {
  min-height: 90vh;
  display: flex;
  align-items: center;
  background: linear-gradient(135deg, #0b0f2a, #1a1f4a);
}

.hero h1 {
  font-size: 3rem;
  font-weight: 700;
}

.hero p {
  color: #cfcfcf;
}

/* BUTTON */
.btn-custom {
  border-radius: 30px;
  padding: 10px 25px;
}

/* IMAGE */
.hero img {
  max-width: 100%;
  border-radius: 20px;
}

/* SECTION */
.section {
  padding: 60px 0;
}

.card-clean {
  background: #151a3a;
  border: none;
  border-radius: 15px;
  padding: 25px;
  transition: 0.3s;
}

.card-clean:hover {
  transform: translateY(-5px);
}

/* FOOTER */
footer {
  background: #050816;
}
</style>

</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">

    <a class="navbar-brand fw-bold" href="index.php">Aquaria System</a>

    <ul class="navbar-nav ms-auto d-flex flex-row gap-3">

      <li class="nav-item"><a class="nav-link text-white" href="index.php">Home</a></li>
      <li class="nav-item"><a class="nav-link text-white" href="about.php">About</a></li>
      <li class="nav-item"><a class="nav-link text-white" href="#contact">Contact</a></li>
  

      
    </ul>

  </div>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="container">
    <div class="row align-items-center">

      <!-- LEFT -->
      <div class="col-md-6">
        <h1>
          Aquaria Central <br> Ticketing System
        </h1>

        <p class="mt-3">
          Book your aquarium tickets easily with Aquaria Central Ticketing System. Our platform allows you to register, log in, and make bookings anytime with a simple and convenient process.
          Aquarium Central is a modern aquarium attraction that offers an exciting underwater experience for visitors of all ages. Explore marine life and enjoy a comfortable and memorable visit with our easy ticket booking system.
        </p>

        <?php if(!isset($_SESSION['user_id'])): ?>
          <a href="register.php" class="btn btn-primary btn-custom mt-3">Get Started</a>
        <?php else: ?>
          <p class="text-success fw-bold mt-3">Welcome back 👋</p>
        <?php endif; ?>

      </div>

      <!-- RIGHT -->
      <div class="col-md-6 text-center">
        <img src="bg1.jpg" alt="Aquaria">
      </div>

    </div>
  </div>
</section>

<!-- FEATURES -->
<section class="section">
  <div class="container text-center">

    <h3 class="mb-5">Features</h3>

    <div class="row g-4">

      <div class="col-md-6">
        <div class="card-clean">
          <h5>User Registration</h5>
          <p class="text-muted">Create your account quickly and securely.</p>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card-clean">
          <h5>Ticket Booking</h5>
          <p class="text-muted">Book aquarium tickets anytime, anywhere.</p>
        </div>
      </div>

    </div>

  </div>
</section>

<!-- HOW IT WORKS -->
<section class="section">
  <div class="container text-center">

    <h3 class="mb-4">How It Works</h3>

    <div class="row g-3">

      <div class="col-md-3"><div class="card-clean">1. Register Account</div></div>
      <div class="col-md-3"><div class="card-clean">2. Login</div></div>
      <div class="col-md-3"><div class="card-clean">3. Book Ticket</div></div>
      <div class="col-md-3"><div class="card-clean">4. Receive Ticket</div></div>

    </div>

  </div>
</section>

<!-- CONTACT -->
 <section class="section" id="contact">>
  <div class="container text-center">

    <h3 class="mb-4">Contact Us</h3>
    <p class="mb-4" style="color: white;">Have questions? Reach out to us anytime.</p>

    <div class="row justify-content-center">

      <div class="col-md-6">
        <div class="card-clean">

          <p><strong>Email:</strong> support@aquaria.com</p>
          <p><strong>Phone:</strong> +60 12-345 6789</p>
          <p><strong>Location:</strong> Kuala Terengganu, Malaysia</p>

        </div>
      </div>

    </div>

  </div>
</section>

<!-- FOOTER -->
<footer class="text-center p-3">
  <p class="mb-0">© 2026 Aquaria Central Ticketing System</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>