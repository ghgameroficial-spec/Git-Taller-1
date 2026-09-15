<?php
require_once __DIR__ . '/db.php';

// Authentication Check
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userName     = $_SESSION['user_name'] ?? 'Usuario';
$userLastName = $_SESSION['user_lastname'] ?? '';
$userEmail    = $_SESSION['user_email'] ?? '';
$initial      = strtoupper(substr($userName, 0, 1));

// Fetch all promotional products
$db = getDBConnection();
$stmt = $db->query("SELECT * FROM productos ORDER BY id ASC");
$productos = $stmt->fetchAll();

// Extract unique categories
$categories = array_unique(array_column($productos, 'categoria'));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Promociones - <?= APP_NAME ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header class="navbar">
        <div class="brand">
            <div class="brand-icon">⚡</div>
            <span><?= APP_NAME ?></span>
        </div>
        <div class="user-nav-info">
            <div class="user-badge">
                <div class="avatar"><?= $initial ?></div>
                <div>
                    <strong><?= htmlspecialchars($userName . ' ' . $userLastName) ?></strong>
                    <div style="font-size: 0.75rem; color: var(--text-muted);"><?= htmlspecialchars($userEmail) ?></div>
                </div>
            </div>
            <a href="logout.php" class="btn-logout">Cerrar Sesión</a>
        </div>
    </header>

    <main class="main-container">
        <!-- Hero Section -->
        <section class="catalog-hero">
            <h1>🔥 Catálogo Exclusivo en Promoción</h1>
            <p>Bienvenido/a <strong><?= htmlspecialchars($userName) ?></strong>. Explora nuestras ofertas exclusivas con descuentos de hasta el 50% por tiempo limitado.</p>
        </section>

        <!-- Filter & Search Bar -->
        <section class="filter-bar">
            <div class="search-box">
                <span class="search-icon">🔍</span>
                <input type="text" id="searchInput" class="search-input" placeholder="Buscar productos en oferta...">
            </div>

            <div class="category-tags">
                <button class="cat-btn active" data-cat="all">Todos</button>
                <?php foreach ($categories as $cat): ?>
                    <button class="cat-btn" data-cat="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></button>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Product Grid -->
        <section class="products-grid" id="productsGrid">
            <?php foreach ($productos as $prod): ?>
                <article class="product-card" 
                         data-title="<?= htmlspecialchars($prod['nombre']) ?>" 
                         data-desc="<?= htmlspecialchars($prod['descripcion']) ?>" 
                         data-category="<?= htmlspecialchars($prod['categoria']) ?>">
                    
                    <div class="product-img-wrapper">
                        <img src="<?= htmlspecialchars($prod['imagen']) ?>" alt="<?= htmlspecialchars($prod['nombre']) ?>" class="product-img" loading="lazy">
                        <span class="badge-discount">-<?= (int)$prod['descuento_porcentaje'] ?>%</span>
                        <span class="badge-custom"><?= htmlspecialchars($prod['badge']) ?></span>
                    </div>

                    <div class="product-body">
                        <div class="product-cat"><?= htmlspecialchars($prod['categoria']) ?></div>
                        <h3 class="product-title"><?= htmlspecialchars($prod['nombre']) ?></h3>
                        <p class="product-desc"><?= htmlspecialchars($prod['descripcion']) ?></p>

                        <div class="price-container">
                            <span class="price-promo">$<?= number_format($prod['precio_promocional'], 2) ?></span>
                            <span class="price-old">$<?= number_format($prod['precio_original'], 2) ?></span>
                        </div>

                        <div class="product-actions">
                            <button class="btn-buy" onclick="buyPromo('<?= htmlspecialchars(addslashes($prod['nombre'])) ?>', '<?= number_format($prod['precio_promocional'], 2) ?>')">
                                Aprovechar Oferta 🛒
                            </button>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </section>
    </main>

    <footer class="footer">
        Taller DevOps - Orientado a Buscar la Calidad en el Desarrollo de Software &copy; <?= date('Y') ?>
    </footer>

    <script src="assets/js/app.js"></script>
</body>
</html>
