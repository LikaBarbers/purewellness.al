<?php
require_once "includes/db.php";

$pageTitle = 'Purewellness.al | Wellness, Skincare & Hair Care';
$pageDescription = 'Zbuloni produkte wellness, skincare, body care dhe hair care në Purewellness.al.';
$pageCanonical = 'https://purewellness.al/';

$featuredStmt = $pdo->query("
    SELECT id, name, image, price, sale_price
    FROM products
    WHERE status = 1
    ORDER BY featured DESC, id DESC
    LIMIT 8
");
$featuredProducts = $featuredStmt->fetchAll(PDO::FETCH_ASSOC);

include 'includes/header.php';
?>

<section class="hero d-flex align-items-center">
    <div class="container text-center">
        <h1>Natural Wellness & Skincare</h1>
        <p class="mt-3">
            Discover premium wellness and skincare products for a healthier lifestyle.
        </p>
        <a href="shop.php" class="btn btn-success btn-lg mt-3">Shop Now</a>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Shop by Category</h2>
        <div class="row g-4">
            <div class="col-md-3"><div class="category-card text-center">🌿<h4>Skincare</h4></div></div>
            <div class="col-md-3"><div class="category-card text-center">💊<h4>Wellness</h4></div></div>
            <div class="col-md-3"><div class="category-card text-center">🧴<h4>Body Care</h4></div></div>
            <div class="col-md-3"><div class="category-card text-center">💆<h4>Hair Care</h4></div></div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">Featured Products</h2>

        <div class="row g-4">
            <?php foreach ($featuredProducts as $product): ?>
                <?php
                $price = ($product['sale_price'] !== null && (float)$product['sale_price'] > 0)
                    ? (float)$product['sale_price']
                    : (float)$product['price'];
                ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card shadow-sm h-100">
                        <?php if (!empty($product['image'])): ?>
                            <a href="product.php?id=<?= (int)$product['id']; ?>">
                                <img
                                    src="assets/uploads/<?= htmlspecialchars($product['image'], ENT_QUOTES, 'UTF-8'); ?>"
                                    alt="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8'); ?>"
                                    class="card-img-top"
                                    style="height:260px;object-fit:cover;">
                            </a>
                        <?php endif; ?>

                        <div class="card-body d-flex flex-column">
                            <h5>
                                <a href="product.php?id=<?= (int)$product['id']; ?>" class="text-decoration-none text-dark">
                                    <?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8'); ?>
                                </a>
                            </h5>

                            <p class="text-success"><?= number_format($price, 2); ?> Lek</p>

                            <a href="product.php?id=<?= (int)$product['id']; ?>" class="btn btn-success w-100 mt-auto">
                                Shiko Produktin
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-5">
            <a href="shop.php" class="btn btn-outline-success btn-lg">Shiko të gjitha produktet</a>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4">
                <h2>🚚</h2>
                <h4>Dërgesë e Shpejtë</h4>
                <p>Në të gjithë Shqipërinë.</p>
            </div>
            <div class="col-md-4">
                <h2>🌿</h2>
                <h4>Produkte Origjinale</h4>
                <p>Vetëm marka të certifikuara.</p>
            </div>
            <div class="col-md-4">
                <h2>💚</h2>
                <h4>Mbështetje</h4>
                <p>Jemi gjithmonë pranë klientëve tanë.</p>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
