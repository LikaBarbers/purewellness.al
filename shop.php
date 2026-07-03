<?php
require_once "includes/db.php";
include "includes/header.php";

$search = $_GET['search'] ?? '';

if($search != ''){

    $stmt = $pdo->prepare("
    SELECT products.*, categories.name AS category_name
    FROM products
    LEFT JOIN categories
    ON products.category_id = categories.id
    WHERE products.status = 1
    AND products.name LIKE ?
    ORDER BY products.id DESC
    ");

    $stmt->execute(["%$search%"]);

}else{

    $stmt = $pdo->query("
    SELECT products.*, categories.name AS category_name
    FROM products
    LEFT JOIN categories
    ON products.category_id = categories.id
    WHERE products.status = 1
    ORDER BY products.id DESC
    ");

}

$products = $stmt->fetchAll();
?>

<div class="container py-5">

    <h2 class="mb-5 text-center">
        Shop
    </h2>

    <div class="row">

<?php foreach($products as $product){ ?>

<div class="col-lg-3 col-md-4 col-sm-6 mb-4">

<div class="card shadow-sm h-100">

<?php if($product['image']){ ?>

<img
src="assets/uploads/<?= htmlspecialchars($product['image']); ?>"
class="card-img-top"
style="height:260px;object-fit:cover;">

<?php } ?>

<div class="card-body">

<h5>

<?= htmlspecialchars($product['name']); ?>

</h5>

<p class="text-success">

<?= htmlspecialchars($product['category_name']); ?>

</p>

<?php if($product['sale_price']){ ?>

<h5 class="text-danger">

<?= number_format($product['sale_price'],2); ?> Lek

</h5>

<small>

<s>

<?= number_format($product['price'],2); ?> Lek

</s>

</small>

<?php }else{ ?>

<h5>

<?= number_format($product['price'],2); ?> Lek

</h5>

<?php } ?>

<a
href="product.php?id=<?= $product['id']; ?>"
class="btn btn-success w-100 mt-3">

Shiko Produktin

</a>

</div>

</div>

</div>

<?php } ?>

</div>

</div>

<?php include "includes/footer.php"; ?>
