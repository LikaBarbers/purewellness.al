<?php

require_once "includes/db.php";
include "includes/header.php";

if(!isset($_GET['id'])){

die("Produkti nuk u gjet.");

}

$stmt=$pdo->prepare("SELECT * FROM products WHERE id=?");

$stmt->execute([$_GET['id']]);

$product=$stmt->fetch();

if(!$product){

die("Produkti nuk ekziston.");

}

?>

<div class="container py-5">

<div class="row">

<div class="col-md-6">

<img
src="assets/uploads/<?= htmlspecialchars($product['image']); ?>"
class="img-fluid rounded shadow">

</div>

<div class="col-md-6">

<h2>

<?= htmlspecialchars($product['name']); ?>

</h2>

<h4 class="text-success my-3">

<?= number_format($product['price'],2); ?> Lek

</h4>

<p>

<?= nl2br(htmlspecialchars($product['description'])); ?>

</p>

<a
href="cart.php?id=<?= $product['id']; ?>"
class="btn btn-success btn-lg">

Shto në Shportë

</a>

</div>

</div>

</div>

<?php include "includes/footer.php"; ?>
