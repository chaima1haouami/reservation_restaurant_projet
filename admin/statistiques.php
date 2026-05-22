<?php
session_start();
include '../config/db.php';

/* 
   CHECK LOGIN
 */
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

/* 
   CHECK ADMIN
*/
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../profile.php");
    exit;
}

/* 
   BASE STATS
 */
$total_clients = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM users"))[0];

$total_plats = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM plats"))[0];

$total_reservations = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM reservations"))[0];

$res_recente = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT date_reservation FROM reservations ORDER BY date_reservation DESC LIMIT 1")
);

$res_personnes = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COALESCE(SUM(personnes),0) AS total FROM reservations")
);

/* =========================
   STATS AVANCÉES
========================= */

$today = date('Y-m-d');
$this_month = date('Y-m');

/* Réservations aujourd'hui */
$res_today = mysqli_fetch_row(mysqli_query($conn, "
    SELECT COUNT(*) 
    FROM reservations 
    WHERE DATE(date_reservation) = '$today'
"))[0];

/* Réservations ce mois */
$res_month = mysqli_fetch_row(mysqli_query($conn, "
    SELECT COUNT(*) 
    FROM reservations 
    WHERE DATE_FORMAT(date_reservation,'%Y-%m') = '$this_month'
"))[0];

/* Moyenne personnes par réservation */
$moyenne = mysqli_fetch_row(mysqli_query($conn, "
    SELECT COALESCE(AVG(personnes),0)
    FROM reservations
"))[0];

/* Jour le plus chargé */
$busy_day = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT DATE(date_reservation) AS jour, COUNT(*) AS total
    FROM reservations
    GROUP BY DATE(date_reservation)
    ORDER BY total DESC
    LIMIT 1
"));

/* Plat populaire */
$top_plat = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT nom
    FROM plats
    LIMIT 1
"));
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques Admin</title>

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body>

<?php include '../includes/admin_navbar.php'; ?>

<div class="container">

    <h1>Statistiques Admin</h1>

    <!-- kpiiiiiii -->
    <div class="cards">

        <div class="card">
            <h2><?= $total_clients ?></h2>
            <p>Total Clients</p>
        </div>

        <div class="card">
            <h2><?= $total_plats ?></h2>
            <p>Total Plats</p>
        </div>

        <div class="card">
            <h2><?= $total_reservations ?></h2>
            <p>Total Réservations</p>
        </div>

        <div class="card">
            <h2><?= $res_personnes['total'] ?? 0 ?></h2>
            <p>Total Personnes</p>
        </div>

        <div class="card">
            <h2><?= $res_recente['date_reservation'] ?? 'Aucune' ?></h2>
            <p>Dernière Réservation</p>
        </div>

    </div>

    <!-- =========================
         STATS AVANCÉES
 -->
    <h2 style="margin-top:30px;">📈 Analyse avancée</h2>

    <div class="cards">

        <div class="card">
            <h2><?= $res_today ?></h2>
            <p>Réservations Aujourd'hui</p>
        </div>

        <div class="card">
            <h2><?= $res_month ?></h2>
            <p>Réservations ce Mois</p>
        </div>

        <div class="card">
            <h2><?= round($moyenne, 1) ?></h2>
            <p>Moyenne Personnes</p>
        </div>

        <div class="card">
            <h2><?= $busy_day['total'] ?? 0 ?></h2>
            <p>Jour le plus chargé</p>
        </div>

        <div class="card">
            <h2><?= htmlspecialchars($top_plat['nom'] ?? 'N/A') ?></h2>
            <p>Plat populaire</p>
        </div>

    </div>

</div>

</body>
</html>