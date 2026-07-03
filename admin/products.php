<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>

<meta charset="UTF-8">

<title>Produktet</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h2>Menaxhimi i Produkteve</h2>

<p>Këtu do të shtojmë listën e produkteve.</p>

<a href="dashboard.php" class="btn btn-secondary">

Kthehu te Dashboard

</a>

</div>

</body>

</html>
