<?php

session_start();

require_once "../includes/db.php";

$error = "";

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username=?");
    $stmt->execute([$username]);

    $admin = $stmt->fetch();

    if($admin && password_verify($password,$admin['password'])){

        $_SESSION['admin']=$admin['id'];

        header("Location: dashboard.php");
        exit;

    }else{

        $error="Username ose Password gabim.";

    }

}

?>

<!DOCTYPE html>
<html lang="sq">

<head>

<meta charset="UTF-8">

<title>Admin Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container">

<div class="row justify-content-center">

<div class="col-md-4 mt-5">

<div class="card shadow">

<div class="card-body">

<h3 class="text-center mb-4">Purewellness Admin</h3>

<?php if($error){ ?>

<div class="alert alert-danger">

<?php echo $error; ?>

</div>

<?php } ?>

<form method="POST">

<input
class="form-control mb-3"
type="text"
name="username"
placeholder="Username"
required>

<input
class="form-control mb-3"
type="password"
name="password"
placeholder="Password"
required>

<button
class="btn btn-success w-100"
name="login">

Login

</button>

</form>

</div>

</div>

</div>

</div>

</div>

</body>

</html>
