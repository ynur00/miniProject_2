<?php
session_start();
include 'db.php'; 

$error = "";

if(isset($_POST['register'])){

    $fullname = htmlspecialchars($_POST['fullname']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);

    // password validation
    if(strlen($_POST['password']) < 6){

        $error = "Password must be at least 6 characters.";

    }else{


      
        // hash password
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // check duplicate email
        $check = $conn->prepare("SELECT id FROM users WHERE email=?");
        $check->bind_param("s",$email);
        $check->execute();
        $result = $check->get_result();

        if($result->num_rows > 0){

            $error = "Email already registered!";

        }else{

            // insert user
            $sql="INSERT INTO users(fullname,email,password,phone,regdate,role)
                  VALUES(?,?,?,?,NOW(),'customer')";

            $stmt=$conn->prepare($sql);
            $stmt->bind_param("ssss",$fullname,$email,$password,$phone);

            if($stmt->execute()){

                $_SESSION['success'] = "Registration Successful! Please Login";

                header("Location: login.php");
                exit();

            }else{

                $error = "Registration failed! Try again.";

            }

        }

    }

} 
?>



<!DOCTYPE html>
<html>
<head>
<title>AQUARIA CENTRAL TICKETING SYSTEM</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
  font-family: 'Poppins', sans-serif;
  background: #0b0f2a;
  color: white;
}

/* CARD (WHITE BOX) */
.card {
  background: #ffffff;
  border: none;
  color: #000;
  border-radius: 15px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

/* INPUT */
.form-control {
  background: #f8f9fa;
  border: 1px solid #ccc;
  color: #000;
}

.form-control:focus {
  background: #fff;
  color: #000;
  border-color: #4f6cff;
  box-shadow: none;
}

/* BUTTON */
.btn-primary {
  background: #4f6cff;
  border: none;
}

.btn-primary:hover {
  background: #3b55d9;
}

/* LINK */
a {
  color: #4f6cff;
  text-decoration: none;
}

a:hover {
  color: #1e3cff;
}

/* TITLE */
h2 {
  color: #0b0f2a;
  font-weight: bold;
}
</style>
</head>

<body>

<div class="d-flex justify-content-center align-items-center min-vh-100">

  <div class="card p-5 w-75" style="max-width:600px;">

    <h2 class="mb-4 text-center">Register</h2>

    <?php if($error != ""){ echo "<div class='alert alert-danger'>$error</div>"; } ?>

    <form method="POST">

      <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" class="form-control" name="fullname" required>
      </div>

      <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" class="form-control" name="password" required minlength="6">
      </div>

      <div class="mb-3">
        <label class="form-label">Phone Number</label>
        <input type="text" class="form-control" name="phone" required pattern="[0-9]+">
      </div>

      <button type="submit" name="register" class="btn btn-primary w-100">
        Register
      </button>

      <div class="text-center mt-3">
        <a href="index.php" class="btn btn-outline-secondary w-100">
          Back to Home
        </a>
      </div>

      <div class="text-center mt-3">
        <small>
          Already registered?
          <a href="login.php">Login here</a>
        </small>
      </div>

    </form>
  </div>

</div>

</body>
</html>