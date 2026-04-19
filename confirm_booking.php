<?php
session_start();
include 'db.php';

// ===============================
// SESSION CHECK (FIXED MP2)
// ===============================
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

// ambil data dari GET
$booking_date = $_GET['booking_date'] ?? '';
$adult = $_GET['adult'] ?? 0;
$child = $_GET['child'] ?? 0;
$senior = $_GET['senior'] ?? 0;

// harga tiket
$adult_price = 80;
$child_price = 60;
$senior_price = 50;

// kira total harga
$total =
($adult * $adult_price) +
($child * $child_price) +
($senior * $senior_price);

// ===============================
// CONFIRM BOOKING INSERT
// ===============================
if(isset($_POST['confirm'])){

    // ===============================
    // FIX: guna user_id (MP2 STANDARD)
    // ===============================
    $user_id = $_SESSION['user_id'];

    // ambil quantity
    $adult = $_POST['adult'];
    $child = $_POST['child'];
    $senior = $_POST['senior'];

    // kira total
    $total =
    ($adult * $adult_price) +
    ($child * $child_price) +
    ($senior * $senior_price);

    $category = "Multiple";
    $qty = $adult + $child + $senior;

    // ===============================
    // FIX DATABASE STRUCTURE (MP2 BEST PRACTICE)
    // ===============================
    $stmt = $conn->prepare("
        INSERT INTO bookings
        (user_id, booking_date, category, qty, qty_adult, qty_child, qty_senior, total_price)
        VALUES (?,?,?,?,?,?,?,?)
    ");

    $stmt->bind_param(
        "isiiiiii",
        $user_id,
        $booking_date,
        $category,
        $qty,
        $adult,
        $child,
        $senior,
        $total
    );

    $stmt->execute();

    header("Location: booking_history.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Confirm Booking</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="d-flex justify-content-center align-items-center min-vh-100">
<div class="card p-4 shadow-lg w-75" style="max-width:600px;">

<h2 class="text-primary mb-4 text-center">Confirm Booking</h2>

<h5>User Information</h5>

<p>
Name: <?php echo $_SESSION['fullname']; ?><br>
Phone: <?php echo $_SESSION['phone']; ?><br>
Role: <?php echo $_SESSION['role']; ?><br>
</p>

<h5>Booking Information</h5>

<p>
Booking Date: <?php echo date("d/m/Y",strtotime($booking_date)); ?><br>
Adult Ticket: <?php echo $adult; ?><br>
Child Ticket: <?php echo $child; ?><br>
Senior Ticket: <?php echo $senior; ?><br>
<br>
Total Price: RM <?php echo $total; ?>
</p>

<form method="POST">

<input type="hidden" name="adult" value="<?php echo $adult; ?>">
<input type="hidden" name="child" value="<?php echo $child; ?>">
<input type="hidden" name="senior" value="<?php echo $senior; ?>">

<button type="submit" name="confirm" class="btn btn-primary w-100">
Confirm Booking
</button>

</form>

</div>
</div>
</body>
</html>