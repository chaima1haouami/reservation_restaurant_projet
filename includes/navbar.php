<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$BASE_URL = "/reservation_restaurant_projet";
?>

<nav class="navbar">

    <a href="<?= $BASE_URL ?>/index.php" class="nav-logo">
        Restaurant<span>Pro</span>
    </a>

    <ul class="nav-links" id="nav-links">

        <li><a href="<?= $BASE_URL ?>/index.php">Accueil</a></li>

        <?php if (isset($_SESSION['user_id'])): ?>

            <li><a href="<?= $BASE_URL ?>/menu.php">Menu</a></li>
            <li><a href="<?= $BASE_URL ?>/reservation.php">Réservation</a></li>
            <li><a href="<?= $BASE_URL ?>/profile.php">Profil</a></li>

            <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>
                <li><a href="<?= $BASE_URL ?>/admin/dashboard.php">Admin</a></li>
            <?php endif; ?>

            <li>
                <a href="<?= $BASE_URL ?>/auth/logout.php" class="logout">
                    Déconnexion
                </a>
            </li>

        <?php else: ?>

            <li><a href="<?= $BASE_URL ?>/auth/login.php">Connexion</a></li>
            <li><a href="<?= $BASE_URL ?>/auth/register.php">Inscription</a></li>

        <?php endif; ?>

    </ul>

    <div class="burger" id="burger">
        <span></span>
        <span></span>
        <span></span>
    </div>

</nav>