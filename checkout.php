<?php
session_start();

require_once "includes/db.php";
include "includes/header.php";

if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    echo "<div class='container py-5'><div class='alert alert-warning'>Shporta është bosh.</div></div>";
    include "includes/footer.php";
    exit;
}

if(isset($_POST['place_order'])){

    $fullname = trim($_POST['fullname']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $city = trim($_POST['city']);
    $address = trim($_POST['address']);

    $stmt = $pdo->prepare("
        INSERT INTO customers(fullname,phone,email,address,city)
        VALUES(?,?,?,?,?)
    ");

    $stmt->execute([
        $fullname,
        $phone,
        $email,
        $address,
        $city
    ]);

    $customer_id = $pdo->lastInsertId();

    $total = 0;

    foreach($_SESSION['cart'] as $id=>$qty){

        $stmt=$pdo->prepare("SELECT * FROM products WHERE id=?");
        $stmt->execute([$id]);

        $product=$stmt->fetch();

        $price=$product['sale_price'] ?: $product['price'];

        $total += $price*$qty;
    }

    $stmt=$pdo->prepare("
        INSERT INTO orders(customer_id,total)
        VALUES(?,?)
    ");

    $stmt->execute([$customer_id,$total]);

    $order_id=$pdo->lastInsertId();

    foreach($_SESSION['cart'] as $id=>$qty){

        $stmt=$pdo->prepare("SELECT * FROM products WHERE id=?");
        $stmt->execute([$id]);

        $product=$stmt->fetch();

        $price=$product['sale_price'] ?: $product['price'];

        $stmt=$pdo->prepare("
        INSERT INTO order_items
        (order_id,product_id,quantity,price)
        VALUES(?,?,?,?)
        ");

        $stmt->execute([
            $order_id,
            $id,
            $qty,
            $price
        ]);

    }

    unset($_SESSION['cart']);

    echo "<div class='container py-5'>";
    echo "<div class='alert alert-success'>";
    echo "<h3>Faleminderit!</h3>";
    echo "<p>Porosia juaj u regjistrua me sukses.</p>";
    echo "</div>";
    echo "</div>";

    include "includes/footer.php";

    exit;
}
?>

<div class="container py-5">

<h2>Përfundimi i Porosisë</h2>

<form method="POST">

<div class="row">

<div class="col-md-6 mb-3">

<label>Emri dhe Mbiemri</label>

<input
type="text"
name="fullname"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>Telefoni</label>

<input
type="text"
name="phone"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>Email</label>

<input
type="email"
name="email"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label>Qyteti</label>

<input
type="text"
name="city"
class="form-control"
required>

</div>

<div class="col-12 mb-3">

<label>Adresa</label>

<textarea
name="address"
class="form-control"
required></textarea>

</div>

</div>

<div class="alert alert-success">

Metoda e pagesës:
<strong>Cash on Delivery</strong>

</div>

<button
name="place_order"
class="btn btn-success btn-lg">

Dërgo Porosinë

</button>

</form>

</div>

<?php include "includes/footer.php"; ?>
