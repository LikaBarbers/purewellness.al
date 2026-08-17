<?php
require_once 'includes/db.php';

header('Content-Type: application/xml; charset=UTF-8');

$base = 'https://purewellness.al/';

$staticPages = [
    ['loc' => $base, 'changefreq' => 'weekly', 'priority' => '1.0'],
    ['loc' => $base . 'shop.php', 'changefreq' => 'daily', 'priority' => '0.9'],
    ['loc' => $base . 'about.php', 'changefreq' => 'monthly', 'priority' => '0.5'],
    ['loc' => $base . 'contact.php', 'changefreq' => 'monthly', 'priority' => '0.5'],
];

$stmt = $pdo->query("\n    SELECT id, updated_at\n    FROM products\n    WHERE status = 1\n    ORDER BY id ASC\n");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

function xmlEscape(string $value): string {
    return htmlspecialchars($value, ENT_XML1 | ENT_QUOTES, 'UTF-8');
}

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

foreach ($staticPages as $page) {
    echo "  <url>\n";
    echo '    <loc>' . xmlEscape($page['loc']) . "</loc>\n";
    echo '    <changefreq>' . $page['changefreq'] . "</changefreq>\n";
    echo '    <priority>' . $page['priority'] . "</priority>\n";
    echo "  </url>\n";
}

foreach ($products as $product) {
    $loc = $base . 'product.php?id=' . (int)$product['id'];
    echo "  <url>\n";
    echo '    <loc>' . xmlEscape($loc) . "</loc>\n";
    if (!empty($product['updated_at'])) {
        $timestamp = strtotime($product['updated_at']);
        if ($timestamp) {
            echo '    <lastmod>' . date('Y-m-d', $timestamp) . "</lastmod>\n";
        }
    }
    echo "    <changefreq>weekly</changefreq>\n";
    echo "    <priority>0.8</priority>\n";
    echo "  </url>\n";
}

echo '</urlset>';
