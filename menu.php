<?php
session_start();
include 'config/db.php';

/* LOGIN REQUIRED */
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}

include 'includes/header.php';

/* =========================
   CATEGORIES
========================= */
$categories = ['Tous', 'Tunisien', 'Français', 'Italien', 'Fruits de mer', 'Pasta', 'Dessert'];

$selected = $_GET['cat'] ?? 'Tous';

/* sécurité */
$selected_clean = mysqli_real_escape_string($conn, trim($selected));

/* =========================
   QUERY PLATS (CORRIGÉ)
========================= */

if ($selected === 'Tous') {
    $query = mysqli_query($conn, "SELECT * FROM plats ORDER BY id DESC");
} else {
    $query = mysqli_query($conn, "
        SELECT * FROM plats 
        WHERE LOWER(TRIM(categorie)) = LOWER(TRIM('$selected_clean'))
        ORDER BY id DESC
    ");
}
?>

<link rel="stylesheet" href="assets/css/menu.css">

<!-- HERO -->
<section class="menu-hero">
    <div class="hero-badge">Notre Menu</div>
    <h1>Menu <em>Gastronomique</em></h1>
    <p>Une expérience culinaire raffinée inspirée des meilleures cuisines du monde</p>
</section>

<!-- FILTRES -->
<div class="menu-filters">
    <?php foreach ($categories as $cat): ?>
        <a href="menu.php?cat=<?= urlencode($cat) ?>"
           class="filter-btn <?= ($selected === $cat) ? 'active' : '' ?>">
            <?= htmlspecialchars($cat) ?>
        </a>
    <?php endforeach; ?>
</div>

<!-- TITRE -->
<span class="section-tag">Sélection du Chef</span>
<h2 class="menu-title">Nos <em>Créations</em></h2>
<div class="divider-gold"></div>

<!-- MENU GRID -->
<div class="menu-grid">

<?php if (!$query || mysqli_num_rows($query) == 0): ?>

    <div class="menu-empty">
        Aucun plat disponible dans cette catégorie 😕
    </div>

<?php else: ?>

    <?php while ($row = mysqli_fetch_assoc($query)): ?>

        <div class="menu-card">

            <div class="menu-card-top">
                <h3><?= htmlspecialchars($row['nom']) ?></h3>
                <span class="price"><?= htmlspecialchars($row['prix']) ?> DT</span>
            </div>

            <p class="cat"><?= htmlspecialchars($row['categorie']) ?></p>

            <?php if (!empty($row['description'])): ?>
                <p class="desc"><?= htmlspecialchars($row['description']) ?></p>
            <?php endif; ?>

            <div class="card-divider"></div>

            <!-- COMMANDER -->
            <form method="post" action="commander.php">
                <input type="hidden" name="id_plat" value="<?= (int)$row['id'] ?>">
                <button type="submit" class="btn-order">
                    <span>Commander</span>
                </button>
            </form>

        </div>

    <?php endwhile; ?>

<?php endif; ?>

</div>

<?php include 'includes/footer.php'; ?>