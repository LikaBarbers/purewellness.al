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
