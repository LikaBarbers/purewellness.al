<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

require_once "../includes/db.php";

$categories = $pdo->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll();

if (isset($_POST['save'])) {

    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $category = $_POST['category'];
    $sku = $_POST['sku'];
    $short = $_POST['short_description'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $sale = $_POST['sale_price'];
    $stock = $_POST['stock'];
    $featured = isset($_POST['featured']) ? 1 : 0;
    $status = isset($_POST['status']) ? 1 : 0;

    $image = "";

    if (!empty($_FILES['image']['name'])) {

        $image = time() . "_" . basename($_FILES['image']['name']);

        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            "../assets/uploads/" . $image
        );
    }

    $stmt = $pdo->prepare("
        INSERT INTO products
        (
            category_id,
            name,
            brand,
            sku,
            short_description,
            description,
            price,
            sale_price,
            stock,
            image,
            featured,
            status
        )
        VALUES
        (?,?,?,?,?,?,?,?,?,?,?,?)
    ");

    $stmt->execute([
        $category,
        $name,
        $brand,
        $sku,
        $short,
        $description,
        $price,
        $sale,
        $stock,
        $image,
        $featured,
        $status
    ]);

    header("Location: products.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="sq">

<head>

<meta charset="UTF-8">

<title>Shto Produkt</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-success text-white">

<h3>Shto Produkt</h3>

</div>

<div class="card-body">

<form method="POST" enctype="multipart/form-data">

<div class="row">

<div class="col-md-6 mb-3">

<label>Emri</label>

<input
type="text"
name="name"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>Marka</label>

<input
type="text"
name="brand"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label>Kategoria</label>

<select
name="category"
class="form-select">

<?php foreach($categories as $cat){ ?>

<option value="<?= $cat['id']; ?>">

<?= $cat['name']; ?>

</option>

<?php } ?>

</select>

</div>

<div class="col-md-6 mb-3">

<label>SKU</label>

<input
type="text"
name="sku"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label>Çmimi</label>

<input
type="number"
step="0.01"
name="price"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label>Çmimi në Ofertë</label>

<input
type="number"
step="0.01"
name="sale_price"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label>Stoku</label>

<input
type="number"
name="stock"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label>Foto</label>

<input
type="file"
name="image"
class="form-control">

</div>

<div class="mb-3">

<label>Përshkrim i shkurtër</label>

<textarea
name="short_description"
class="form-control"></textarea>

</div>

<div class="mb-3">

<label>Përshkrim i plotë</label>

<textarea
name="description"
rows="6"
class="form-control"></textarea>

</div>

<div class="form-check">

<input
type="checkbox"
name="featured"
class="form-check-input">

<label class="form-check-label">

Featured Product

</label>

</div>

<div class="form-check mb-4">

<input
type="checkbox"
checked
name="status"
class="form-check-input">

<label class="form-check-label">

Aktiv

</label>

</div>

<button
name="save"
class="btn btn-success">

Ruaj Produktin

</button>

<a
href="products.php"
class="btn btn-secondary">

Anulo

</a>

</form>

</div>

</div>

</div>

</body>

</html>
