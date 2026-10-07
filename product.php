<?php
require_once "includes/db.php";

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    http_response_code(404);
    $pageTitle = 'Produkti nuk u gjet | Purewellness.al';
    $pageRobots = 'noindex,follow';
    include "includes/header.php";
    echo '<div class="container py-5"><h1>Produkti nuk u gjet.</h1></div>';
    include "includes/footer.php";
    exit;
}

$stmt = $pdo->prepare("\n    SELECT products.*, categories.name AS category_name\n    FROM products\n    LEFT JOIN categories ON products.category_id = categories.id\n    WHERE products.id = ? AND products.status = 1\n    LIMIT 1\n");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    http_response_code(404);
    $pageTitle = 'Produkti nuk ekziston | Purewellness.al';
    $pageRobots = 'noindex,follow';
    include "includes/header.php";
    echo '<div class="container py-5"><h1>Produkti nuk ekziston.</h1></div>';
    include "includes/footer.php";
    exit;
}

$productName = trim((string)$product['name']);
$descriptionSource = trim((string)($product['short_description'] ?: $product['description']));
$plainDescription = trim(preg_replace('/\s+/', ' ', strip_tags($descriptionSource)));
if ($plainDescription === '') {
    $plainDescription = $productName . ' në Purewellness.al.';
}
$pageDescription = mb_substr($plainDescription, 0, 155, 'UTF-8');
$pageTitle = $productName . ' | Purewellness.al';
$pageCanonical = 'https://purewellness.al/product.php?id=' . (int)$product['id'];
$pageRobots = 'index,follow';

$effectivePrice = ($product['sale_price'] !== null && (float)$product['sale_price'] > 0)
    ? (float)$product['sale_price']
    : (float)$product['price'];

$imageUrl = !empty($product['image'])
    ? 'https://purewellness.al/assets/uploads/' . rawurlencode($product['image'])
    : null;

$productSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'Product',
    'name' => $productName,
    'description' => $plainDescription,
    'url' => $pageCanonical,
    'sku' => !empty($product['sku']) ? (string)$product['sku'] : (string)$product['id'],
    'offers' => [
        '@type' => 'Offer',
        'url' => $pageCanonical,
        'priceCurrency' => 'ALL',
        'price' => number_format($effectivePrice, 2, '.', ''),
        'availability' => ((int)$product['stock'] > 0)
            ? 'https://schema.org/InStock'
            : 'https://schema.org/OutOfStock'
    ]
];

if ($imageUrl) {
    $productSchema['image'] = [$imageUrl];
}
if (!empty($product['brand'])) {
    $productSchema['brand'] = [
        '@type' => 'Brand',
        'name' => (string)$product['brand']
    ];
}

include "includes/header.php";
?>

<script type="application/ld+json"><?= json_encode($productSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?></script>

<div class="container py-5">

<div class="row">

<div class="col-md-6">

<?php if (!empty($product['image'])): ?>
<img
src="assets/uploads/<?= htmlspecialchars($product['image'], ENT_QUOTES, 'UTF-8'); ?>"
alt="<?= htmlspecialchars($productName, ENT_QUOTES, 'UTF-8'); ?>"
class="img-fluid rounded shadow">
<?php endif; ?>

</div>

<div class="col-md-6">

<?php if (!empty($product['category_name'])): ?>
<p class="text-muted mb-2">
    <a href="shop.php" class="text-decoration-none">Shop</a>
    &rsaquo; <?= htmlspecialchars($product['category_name'], ENT_QUOTES, 'UTF-8'); ?>
</p>
<?php endif; ?>

<h1><?= htmlspecialchars($productName, ENT_QUOTES, 'UTF-8'); ?></h1>

<?php if ($product['sale_price'] !== null && (float)$product['sale_price'] > 0): ?>
<h4 class="text-danger my-3">
<?= number_format((float)$product['sale_price'], 2); ?> Lek
</h4>
<p><s><?= number_format((float)$product['price'], 2); ?> Lek</s></p>
<?php else: ?>
<h4 class="text-success my-3">
<?= number_format((float)$product['price'], 2); ?> Lek
</h4>
<?php endif; ?>

<?php if (!empty($product['short_description'])): ?>
<p class="lead"><?= nl2br(htmlspecialchars($product['short_description'], ENT_QUOTES, 'UTF-8')); ?></p>
<?php endif; ?>

<p><?= nl2br(htmlspecialchars($product['description'], ENT_QUOTES, 'UTF-8')); ?></p>

<?php if ((int)$product['stock'] > 0): ?>
<a
href="cart.php?id=<?= (int)$product['id']; ?>"
class="btn btn-success btn-lg">
Shto në Shportë
</a>
<?php else: ?>
<button class="btn btn-secondary btn-lg" disabled>Jashtë stokut</button>
<?php endif; ?>

<p class="mt-4"><a href="shop.php">&larr; Kthehu te Shop</a></p>

</div>

</div>

</div>

<?php include "includes/footer.php"; ?>
