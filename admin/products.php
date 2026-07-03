<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

require_once "../includes/db.php";

$stmt = $pdo->query("
SELECT
products.*,
categories.name AS category_name
FROM products
LEFT JOIN categories
ON products.category_id = categories.id
ORDER BY products.id DESC
");

$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="sq">
<head>

<meta charset="UTF-8">

<title>Produktet</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2>Produktet</h2>

<a href="add-product.php" class="btn btn-success">
+ Shto Produkt
</a>

</div>

<div class="card shadow">

<div class="card-body">

<table class="table table-bordered table-hover align-middle">

<thead class="table-success">

<tr>

<th>ID</th>

<th>Foto</th>

<th>Emri</th>

<th>Kategoria</th>

<th>Çmimi</th>

<th>Stoku</th>

<th>Veprime</th>

</tr>

</thead>

<tbody>

<?php foreach($products as $product){ ?>

<tr>

<td><?= $product['id']; ?></td>

<td>

<?php if($product['image']){ ?>

<img
src="../assets/uploads/<?= $product['image']; ?>"
width="70">

<?php } ?>

</td>

<td><?= htmlspecialchars($product['name']); ?></td>

<td><?= htmlspecialchars($product['category_name']); ?></td>

<td><?= number_format($product['price'],2); ?> Lek</td>

<td><?= $product['stock']; ?></td>

<td>

<a
href="edit-product.php?id=<?= $product['id']; ?>"
class="btn btn-warning btn-sm">

Edit

</a>

<a
href="delete-product.php?id=<?= $product['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Fshi produktin?')">

Delete

</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</body>

</html>
