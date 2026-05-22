<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* 
CONFIGURATION
*/
$BASE_URL = "/reservation_restaurant_projet";

/* URL propre */
$current_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$current_page = basename($current_path);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Pro</title>

    <!-- GLOBAL CSS -->
    <link rel="stylesheet" href="<?= $BASE_URL ?>/assets/css/style.css?v=1.0">

    <!-- MENU / RESERVATION -->
    <?php
    $page_css = [
        'menu.php'        => 'menu.css',
        'reservation.php' => 'reservation.css',
    ];

    if (isset($page_css[$current_page])) {
        echo '<link rel="stylesheet" href="' .
            $BASE_URL .
            '/assets/css/' .
            $page_css[$current_page] .
            '?v=1.0">';
    }

    /*  LOGIN / REGISTER   */
    if ($current_page === 'login.php' || $current_page === 'register.php') {
        echo '<link rel="stylesheet" href="' .
            $BASE_URL .
            '/assets/css/login.css?v=1.0">';
    }

    /*  ADMIN */
    $admin_pages = [
        'dashboard.php',
        'gestion_plats.php',
        'gestion_clients.php',
        'gestion_reservations.php',
        'statistiques.php'
    ];

    if (in_array($current_page, $admin_pages)) {
        echo '<link rel="stylesheet" href="' .
            $BASE_URL .
            '/assets/css/admin.css?v=1.0">';
    }
    ?>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar">

    <a href="<?= $BASE_URL ?>/index.php" class="nav-logo">
        Restaurant<span>Pro</span>
    </a>

    <ul class="nav-links" id="nav-links">
        <li><a href="<?= $BASE_URL ?>/index.php">Accueil</a></li>
        <li><a href="<?= $BASE_URL ?>/menu.php">Menu</a></li>
        <li><a href="<?= $BASE_URL ?>/reservation.php">Réservation</a></li>
        <li><a href="<?= $BASE_URL ?>/profile.php">Profil</a></li>

        <?php if (!empty($_SESSION['user_id'])): ?>
            <li>
                <a href="<?= $BASE_URL ?>/auth/logout.php" class="nav-pill">
                    Déconnexion
                </a>
            </li>
        <?php else: ?>
            <li>
                <a href="<?= $BASE_URL ?>/auth/login.php" class="nav-pill">
                    Connexion
                </a>
            </li>
        <?php endif; ?>
    </ul>

    <div class="burger" id="burger">
        <span></span>
        <span></span>
        <span></span>
    </div>

</nav>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const burger = document.getElementById("burger");
    const navLinks = document.getElementById("nav-links");

    if (burger && navLinks) {
        burger.addEventListener("click", function () {
            burger.classList.toggle("open");
            navLinks.classList.toggle("open");
        });
    }
});
</script>