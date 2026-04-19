<?php
session_start();
include 'db.php';


if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

// check id ada
if(!isset($_GET['id'])){
    header("Location: booking_history.php");
    exit();
}

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];


$stmt = $conn->prepare("SELECT * FROM bookings WHERE id=? AND user_id=?");
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// kalau ticket tak jumpa / bukan milik user
if(!$row){
    echo "Ticket not found or access denied";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Print Ticket</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<script>
function printPage(){
    window.print();
}
</script>
</head>

<body class="bg-light">

<div class="container mt-5">
<div class="card p-4">

<div class="d-flex justify-content-between align-items-center mb-3">
<h2 class="m-0">Aquaria Ticket</h2>
<a href="logout.php" class="btn btn-danger">Logout</a>
</div>

<hr>

<p>


Customer Name: <?php echo $_SESSION['fullname']; ?><br>

Booking Date: <?php echo date("d/m/Y",strtotime($row['booking_date'])); ?><br>

Category:<br>

<?php
if($row['qty_adult'] > 0){
    echo "Adult: ".$row['qty_adult']."<br>"; 
}
if($row['qty_child'] > 0){
    echo "Child: ".$row['qty_child']."<br>"; 
}
if($row['qty_senior'] > 0){
    echo "Senior: ".$row['qty_senior']."<br>"; 
}
?>

<br>

Total Quantity:
<?php
$total_qty = $row['qty_adult'] + $row['qty_child'] + $row['qty_senior'];
echo $total_qty; 
?>

<br>

Total Price: RM <?php echo $row['total_price']; ?>

</p>

<button onclick="printPage()" class="btn btn-success">Print Ticket</button>

</div>
</div>

</body>
</html>