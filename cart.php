<?php
session_start();
require_once "includes/db.php";
include "includes/header.php";

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_GET['id'])) {

    $id = (int)$_GET['id'];

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]++;
    } else {
        $_SESSION['cart'][$id] = 1;
    }

    header("Location: cart.php");
    exit;
}

$total = 0;
?>

<div class="container py-5">

<h2 class="mb-4">Shopping Cart</h2>

<table class="table table-bordered">

<thead>

<tr>

<th>Produkti</th>

<th>Çmimi</th>

<th>Sasia</th>

<th>Totali</th>

</tr>

</thead>

<tbody>

<?php

foreach($_SESSION['cart'] as $id=>$qty){

$stmt=$pdo->prepare("SELECT * FROM products WHERE id=?");

$stmt->execute([$id]);

$product=$stmt->fetch();

if(!$product) continue;

$price=$product['sale_price'] ?: $product['price'];

$subtotal=$price*$qty;

$total+=$subtotal;

?>

<tr>

<td><?= htmlspecialchars($product['name']); ?></td>

<td><?= number_format($price,2); ?> Lek</td>

<td><?= $qty; ?></td>

<td><?= number_format($subtotal,2); ?> Lek</td>

</tr>

<?php } ?>

</tbody>

</table>

<div class="text-end">

<h3>

Totali:

<?= number_format($total,2); ?> Lek

</h3>

<a href="checkout.php" class="btn btn-success btn-lg">

Vazhdo me Porosinë

</a>

</div>

</div>

<?php include "includes/footer.php"; ?>
