
<?php
session_start();
include 'db.php';

// check login
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$fullname = $_SESSION['fullname'];

// check id
if(!isset($_GET['id'])){
    header("Location: booking_history.php");
    exit();
}

$id = intval($_GET['id']);

// categories
$categories = [
    "adult" => 80,
    "child" => 60,
    "senior" => 50
];

// GET BOOKING (FIXED)
$stmt = $conn->prepare("SELECT * FROM bookings WHERE id=? AND user_id=?");
$stmt->bind_param("ii",$id,$user_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 0){
    die("Booking tidak ditemui");
}

$row = $result->fetch_assoc();

// prevent edit last 1 day
if(strtotime($row['booking_date']) <= strtotime('+1 day')){
    die("Anda tidak boleh mengubah booking kurang daripada 1 hari sebelum tarikh booking.");
}

// UPDATE BOOKING
if(isset($_POST['update'])){
    $booking_date = $_POST['booking_date'];
    $qty_adult = intval($_POST['adult']);
    $qty_child = intval($_POST['child']);
    $qty_senior = intval($_POST['senior']);

    $today = date('Y-m-d');
    if(strtotime($booking_date) <= strtotime($today)){
        die("Ralat: Tarikh booking mesti sekurang-kurangnya satu hari ke hadapan.");
    }

    $total_price = ($qty_adult*$categories['adult']) + 
                   ($qty_child*$categories['child']) + 
                   ($qty_senior*$categories['senior']);

    // UPDATE (FIXED)
    $stmt = $conn->prepare("
        UPDATE bookings 
        SET booking_date=?, qty_adult=?, qty_child=?, qty_senior=?, total_price=? 
        WHERE id=? AND user_id=?
    ");

    $stmt->bind_param(
        "siiiiii",
        $booking_date,
        $qty_adult,
        $qty_child,
        $qty_senior,
        $total_price,
        $id,
        $user_id
    );

    if(!$stmt->execute()){
        die("Ralat mengemaskini booking: " . $stmt->error);
    }

    header("Location: booking_history.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Booking</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
<h2 class="text-center text-primary mb-4">Edit Booking</h2>

<form method="POST">
<div class="mb-3">
    <label>Nama Pelanggan</label>
    <input type="text" class="form-control" value="<?php echo htmlspecialchars($fullname); ?>" readonly>
</div>

<div class="mb-3">
    <label>Tarikh Booking</label>
    <input type="date" name="booking_date" class="form-control"
           value="<?php echo $row['booking_date']; ?>"
           min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
</div>

<?php foreach($categories as $cat => $price): 
    $db_col = "qty_$cat";
    $value = isset($row[$db_col]) ? $row[$db_col] : 0;
?>
<div class="mb-3">
    <label><?php echo ucfirst($cat); ?> (RM <?php echo $price; ?>)</label>
    <input type="number" name="<?php echo $cat; ?>" class="form-control qty" min="0" value="<?php echo $value; ?>" data-price="<?php echo $price; ?>">
</div>
<?php endforeach; ?>

<div class="mb-3">
    <label>Jumlah Harga</label>
    <input type="text" id="total_price" class="form-control" value="<?php echo $row['total_price']; ?>" readonly>
</div>

<button type="submit" name="update" class="btn btn-primary">Kemaskini Booking</button>
<a href="booking_history.php" class="btn btn-secondary">Batal</a>
</form>
</div>

<script>
document.addEventListener("DOMContentLoaded", function(){
    const qtyInputs = document.querySelectorAll('.qty');
    const total = document.getElementById('total_price');

    function updateTotal(){
        let sum = 0;
        qtyInputs.forEach(input => {
            const val = parseInt(input.value) || 0;
            const price = parseInt(input.dataset.price);
            sum += val * price;
        });
        total.value = sum;
    }

    qtyInputs.forEach(input => {
        input.addEventListener('input', updateTotal);
    });
});
</script>

</body>
</html>