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

// ambil user info dari session
$user_id = $_SESSION['user_id'];
$fullname = $_SESSION['fullname'];

// ===============================
// FETCH BOOKING (FIXED RELATIONAL DB)
// ===============================
$stmt = $conn->prepare("SELECT * FROM bookings WHERE user_id=? ORDER BY booking_date DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// categories & harga
$categories = [
    "adult" => 80,
    "child" => 60,
    "senior" => 50
];
?>

<!DOCTYPE html>
<html>
<head>
<title>Booking History</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

<h2 class="text-center text-primary mb-4">Booking History</h2>

<table class="table table-bordered table-striped">
<tr>
<th>Customer Name</th>
<th>Booking Date</th>

<?php foreach($categories as $cat => $price){ ?>
<th><?php echo ucfirst($cat); ?> (RM <?php echo $price; ?>)</th>
<?php } ?>

<th>Total Price</th>
<th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()){ ?>
<tr>

<!-- USER INFO -->
<td><?php echo htmlspecialchars($fullname); ?></td>

<!-- BOOKING DATE -->
<td><?php echo date("d/m/Y", strtotime($row['booking_date'])); ?></td>

<!-- TICKET QUANTITY -->
<?php foreach($categories as $cat => $price){ 
    $db_col = "qty_$cat"; 
    $qty = isset($row[$db_col]) ? $row[$db_col] : 0; 
?>
<td><?php echo $qty; ?></td>
<?php } ?>

<!-- TOTAL PRICE -->
<td>RM <?php echo number_format($row['total_price'], 2); ?></td>

<!-- ACTION -->
<td>
<a href="edit_booking.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
<a href="delete_booking.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this booking?')">Delete</a>
<a href="print_ticket.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">Print</a>
</td>

</tr>
<?php } ?>

</table>

</div>
</body>
</html>