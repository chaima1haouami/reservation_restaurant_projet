<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

/* FILTRE PAR DATE*/
$from = $_GET['from'] ?? '';
$to   = $_GET['to'] ?? '';

$where = "WHERE 1=1";

if (!empty($from)) {
    $from_safe = mysqli_real_escape_string($conn, $from);
    $where .= " AND date_reservation >= '$from_safe'";
}

if (!empty($to)) {
    $to_safe = mysqli_real_escape_string($conn, $to);
    $where .= " AND date_reservation <= '$to_safe'";
}

/* 
KPI
*/
$clients = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM users"))[0];

$plats = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM plats"))[0];

$reservations = mysqli_fetch_row(
    mysqli_query($conn, "SELECT COUNT(*) FROM reservations $where")
)[0];

$personnes = mysqli_fetch_row(
    mysqli_query($conn, "SELECT COALESCE(SUM(personnes),0) FROM reservations $where")
)[0];

/* 
   DERNIÈRE RÉSERVATION
 */
$last_query = mysqli_query($conn, "
    SELECT date_reservation
    FROM reservations
    $where
    ORDER BY date_reservation DESC
    LIMIT 1
");

$last = mysqli_fetch_assoc($last_query);

/*
   GRAPHIQUE (CORRIGÉ - FIX ONLY_FULL_GROUP_BY)
*/
$chart_query = mysqli_query($conn, "
    SELECT 
        DATE_FORMAT(date_reservation, '%Y-%m') AS m,
        COUNT(*) AS n
    FROM reservations
    $where
    GROUP BY DATE_FORMAT(date_reservation, '%Y-%m')
    ORDER BY DATE_FORMAT(date_reservation, '%Y-%m')
");

$chart_data = [];
$max_value = 1;

while ($row = mysqli_fetch_assoc($chart_query)) {
    $chart_data[] = $row;
    if ($row['n'] > $max_value) {
        $max_value = $row['n'];
    }
}

/* 
   TOP PLATS (version simple correcte)
*/
$top_query = mysqli_query($conn, "
    SELECT nom
    FROM plats
    LIMIT 5
");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>

<?php include '../includes/admin_navbar.php'; ?>

<div class="admin-wrapper">

    <!-- HEADER -->
    <div class="page-header">
        <div class="page-header-left">
            <span class="page-tag">ADMIN PANEL</span>
            <h1 class="dashboard-title">Dashboard</h1>
            <p class="dashboard-subtitle">
                Vue d'ensemble des performances du restaurant
            </p>
        </div>
    </div>

    <!-- FILTRE -->
    <form method="GET" class="filter-box">
        <input type="date" name="from" value="<?= htmlspecialchars($from) ?>">
        <input type="date" name="to" value="<?= htmlspecialchars($to) ?>">

        <button type="submit">Filtrer</button>
        <a href="dashboard.php" class="reset-btn">Réinitialiser</a>
    </form>

    <!-- KPI -->
    <div class="cards">

        <div class="card">
            <div class="card-icon">👤</div>
            <h2><?= $clients ?></h2>
            <p>Clients</p>
        </div>

        <div class="card">
            <div class="card-icon">🍽️</div>
            <h2><?= $plats ?></h2>
            <p>Plats</p>
        </div>

        <div class="card">
            <div class="card-icon">📅</div>
            <h2><?= $reservations ?></h2>
            <p>Réservations</p>
        </div>

        <div class="card">
            <div class="card-icon">👥</div>
            <h2><?= $personnes ?></h2>
            <p>Personnes</p>
        </div>

    </div>

    <!-- INFOS -->
    <div class="info-grid">

        <div class="info-box">
            <p>Dernière réservation</p>
            <h3>
                <?= !empty($last['date_reservation'])
                    ? htmlspecialchars($last['date_reservation'])
                    : 'Aucune'
                ?>
            </h3>
        </div>

        <div class="info-box">
            <p>Moyenne personnes</p>
            <h3>
                <?= $reservations > 0 ? round($personnes / $reservations, 1) : 0 ?>
            </h3>
        </div>

    </div>

    <!-- GRAPHIQUE -->
    <h2 class="dashboard-section-title">📈 Réservations par mois</h2>

    <?php if (!empty($chart_data)): ?>
        <div class="chart">

            <?php foreach ($chart_data as $item): ?>
                <?php $height = ($item['n'] / $max_value) * 160; ?>

                <div class="chart-item">
                    <div class="chart-value"><?= $item['n'] ?></div>
                    <div class="chart-bar" style="height: <?= $height ?>px;"></div>
                    <div class="chart-label"><?= htmlspecialchars($item['m']) ?></div>
                </div>

            <?php endforeach; ?>

        </div>
    <?php else: ?>
        <div class="dashboard-empty">
            Aucune donnée disponible pour la période sélectionnée.
        </div>
    <?php endif; ?>

    <!-- TOP PLATS -->
    <h2 class="dashboard-section-title">🍽️ Top Plats</h2>

    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Plat</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; while ($p = mysqli_fetch_assoc($top_query)): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= htmlspecialchars($p['nom']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>