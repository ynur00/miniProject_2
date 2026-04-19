

<?php
session_start();
include 'db.php';

$error = "";
$success = "";

if(isset($_SESSION['success'])){
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
}

$saved_email = "";
if(isset($_COOKIE['remember_user'])){
    $saved_email = $_COOKIE['remember_user'];
}

if(isset($_POST['login'])){

    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    if(empty($email) || empty($password)){
        $error = "Sila isi email dan password!";
    } else {

        $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows === 1){

            $row = $result->fetch_assoc();

            if(password_verify($password, $row['password'])){

                session_regenerate_id(true);

                $_SESSION['user_id'] = $row['id'];
                $_SESSION['fullname'] = $row['fullname'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['phone'] = $row['phone'];
                $_SESSION['role'] = $row['role'];

                if(isset($_POST['remember'])){
                    setcookie("remember_user", $email, time() + (86400*7), "/");
                } else {
                    setcookie("remember_user", "", time() - 3600, "/");
                }

                if($row['role'] == "admin"){
                    header("Location: admin_dashboard.php");
                } else {
                    header("Location: dashboard.php");
                }
                exit();

            } else {
                $error = "Password salah!";
            }

        } else {
            $error = "Email tidak dijumpai!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
  font-family: 'Poppins', sans-serif;
  background: #0b0f2a;
  color: white;
}

/* card form */
.card {
  background: #ffffff;
  border: none;
  color: #000;
}
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


/* button */
.btn-primary {
  background: #4f6cff;
  border: none;
}

.btn-primary:hover {
  background: #3b55d9;
}

/* link */
a {
  color: #8aa0ff;
}
a:hover {
  color: white;
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
    <div class="card p-5 shadow-lg w-75" style="max-width:600px;">

        <h2 class="mb-4 text-center">Login</h2>

        <?php
        if($success != ""){
            echo "<div class='alert alert-success'>$success</div>";
        }

        if($error != ""){
            echo "<div class='alert alert-danger'>$error</div>";
        }
        ?>

        <form method="POST">

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email"
                       class="form-control"
                       name="email"
                       value="<?php echo htmlspecialchars($saved_email); ?>"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password"
                       class="form-control"
                       name="password"
                       required>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input"
                       type="checkbox"
                       name="remember"
                       id="remember">
                <label class="form-check-label" for="remember">
                    Remember Me
                </label>
            </div>

            <button type="submit" name="login" class="btn btn-primary w-100">
                Login
            </button>

            <div class="text-center mt-3">
              <a href="index.php" class="btn btn-outline-secondary w-100">
                Back to Home
              </a>
            </div>

            <div class="text-center mt-3">
                <small>
                    Don't have an account?
                    <a href="register.php">Register here</a>
                </small>
            </div>

        </form>
    </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>