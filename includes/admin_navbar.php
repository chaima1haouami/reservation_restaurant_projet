<?php
/* ============================================================
   includes/admin_navbar.php
   Inclus dans : dashboard.php · gestion_*.php · statistiques.php
   CSS : style.css + admin.css (chargés dans chaque page parente)
   ============================================================ */
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: /reservation_restaurant_projet/auth/login.php");
    exit;
}

$current = basename($_SERVER['PHP_SELF']);

$nav_items = [
    'dashboard.php'              => ['icon' => '📊', 'label' => 'Dashboard'],
    'statistiques.php'           => ['icon' => '📈', 'label' => 'Statistiques'],
    'gestion_plats.php'          => ['icon' => '🍽️', 'label' => 'Plats'],
    'gestion_reservations.php'   => ['icon' => '📅', 'label' => 'Réservations'],
    'gestion_clients.php'        => ['icon' => '👤', 'label' => 'Clients'],
];
?>

<nav class="admin-nav" id="admin-nav">

    <!-- Logo -->
    <a href="/reservation_restaurant_projet/admin/dashboard.php" class="logo">
        Restaurant<span>Pro</span>
        <small>Admin</small>
    </a>

    <!-- Liens -->
    <ul id="admin-nav-links">
        <?php foreach ($nav_items as $file => $item): ?>
            <li>
                <a href="/reservation_restaurant_projet/admin/<?= $file ?>"
                   class="<?= $current === $file ? 'active' : '' ?>">
                    <?= $item['icon'] ?> <?= $item['label'] ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- Déconnexion + burger -->
    <div style="display:flex;align-items:center;gap:16px;">
        <a href="/reservation_restaurant_projet/auth/logout.php" class="logout">
            Déconnexion
        </a>

        <div class="admin-burger" id="admin-burger">
            <span></span><span></span><span></span>
        </div>
    </div>

</nav>

<script>
(function(){
    const burger = document.getElementById('admin-burger');
    const links  = document.getElementById('admin-nav-links');
    burger.addEventListener('click', () => links.classList.toggle('open'));
})();
</script>