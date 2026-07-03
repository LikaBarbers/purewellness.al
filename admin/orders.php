<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

require_once "../includes/db.php";

$stmt=$pdo->query("
SELECT
orders.*,
customers.fullname,
customers.phone
FROM orders
JOIN customers
ON customers.id=orders.customer_id
ORDER BY orders.id DESC
");

$orders=$stmt->fetchAll();
?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>Porositë</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h2>Porositë</h2>

<table class="table table-bordered">

<thead>

<tr>

<th>ID</th>

<th>Klienti</th>

<th>Telefoni</th>

<th>Totali</th>

<th>Statusi</th>

</tr>

</thead>

<tbody>

<?php foreach($orders as $order){ ?>

<tr>

<td><?= $order['id']; ?></td>

<td><?= htmlspecialchars($order['fullname']); ?></td>

<td><?= htmlspecialchars($order['phone']); ?></td>

<td><?= number_format($order['total'],2); ?> Lek</td>

<td><?= htmlspecialchars($order['status']); ?></td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</body>

</html>
