<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

require_once "../includes/db.php";

$totalProducts = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$totalOrders = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$totalCustomers = $pdo->query("SELECT COUNT(*) FROM customers")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="sq">
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-success">

<div class="container">

<span class="navbar-brand">

Purewellness Admin

</span>

<a href="logout.php" class="btn btn-light">

Logout

</a>

</div>

</nav>

<div class="container mt-5">

<h2 class="mb-4">

Dashboard

</h2>

<div class="row">

<div class="col-md-4">

<div class="card shadow">

<div class="card-body text-center">

<h5>Produkte</h5>

<h2><?= $totalProducts ?></h2>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card shadow">

<div class="card-body text-center">

<h5>Porosi</h5>

<h2><?= $totalOrders ?></h2>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card shadow">

<div class="card-body text-center">

<h5>Klientë</h5>

<h2><?= $totalCustomers ?></h2>

</div>

</div>

</div>

</div>

<hr class="my-5">

<div class="d-grid gap-3">

<a href="products.php" class="btn btn-success btn-lg">

📦 Menaxho Produktet

</a>

<a href="orders.php" class="btn btn-primary btn-lg">

🛒 Menaxho Porositë

</a>

</div>

</div>

</body>

</html>
