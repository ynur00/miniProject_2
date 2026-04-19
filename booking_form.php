<?php
session_start();
include 'db.php';


if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$error = "";


if($_SERVER['REQUEST_METHOD']=="POST"){

    // ambil data
    $booking_date = $_POST['booking_date'];
    $adult = $_POST['adult_qty'];
    $child = $_POST['child_qty'];
    $senior = $_POST['senior_qty'];

    
    if(strtotime($booking_date) < strtotime(date("Y-m-d"))){

        $error = "Cannot book past date!";

    }elseif($adult==0 && $child==0 && $senior==0){

        $error = "Please select at least 1 ticket!";

    }else{

        
        header("Location: confirm_booking.php?booking_date=$booking_date&adult=$adult&child=$child&senior=$senior");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Booking Form</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="d-flex justify-content-center align-items-center min-vh-100">
<div class="card p-4 shadow-lg w-75" style="max-width:600px;">

<h2 class="text-primary mb-4 text-center">Booking Form</h2>

<h5>User Information</h5>

<p>
Name: <?php echo $_SESSION['fullname']; ?><br>
Phone: <?php echo $_SESSION['phone']; ?><br>
Role: <?php echo $_SESSION['role']; ?><br>
</p>

<?php
if($error!=""){
    echo "<div class='alert alert-danger'>$error</div>";
}
?>

<form method="POST">

<div class="mb-3">
<label class="form-label">Booking Date</label>
<input type="date" name="booking_date" class="form-control" required>
</div>

<h5>Ticket Quantity</h5>

<div class="mb-3">
<label>Adult (RM80)</label>
<input type="number" name="adult_qty" class="form-control" min="0" value="0">
</div>

<div class="mb-3">
<label>Child (RM60)</label>
<input type="number" name="child_qty" class="form-control" min="0" value="0">
</div>

<div class="mb-3">
<label>Senior (RM50)</label>
<input type="number" name="senior_qty" class="form-control" min="0" value="0">
</div>

<button type="submit" class="btn btn-primary w-100">
Proceed Booking
</button>

</form>

</div>
</div>

</body>
</html>