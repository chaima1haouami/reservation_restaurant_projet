<?php

session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

/* Suppression */
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM reservations WHERE id=$id");
    header("Location: gestion_reservations.php?msg=deleted");
    exit;
}

$message = '';
if (isset($_GET['msg']) && $_GET['msg'] === 'deleted') {
    $message = "Réservation supprimée.";
}

/* Filtrage par date */
$where = '';
$filter_date = $_GET['date'] ?? '';
if ($filter_date) {
    $fd = mysqli_real_escape_string($conn, $filter_date);
    $where = "WHERE date_reservation = '$fd'";
}

$res = mysqli_query($conn,
    "SELECT * FROM reservations $where ORDER BY date_reservation DESC, heure DESC"
);
$total = mysqli_num_rows($res);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservations — Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<?php include '../includes/admin_navbar.php'; ?>

<div class="admin-wrapper">

    <div class="page-header">
        <div class="page-header-left">
            <span class="page-tag">Administration</span>
            <h1>Gestion des <em>Réservations</em></h1>
            <p><?= $total ?> réservation<?= $total > 1 ? 's' : '' ?> trouvée<?= $total > 1 ? 's' : '' ?></p>
        </div>
    </div>

    <?php if ($message): ?>
        <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <!-- Filtre date -->
    <form method="GET" style="display:flex;gap:10px;align-items:center;margin-bottom:28px;flex-wrap:wrap;">
        <div class="form-field" style="margin:0;">
            <input type="date" name="date"
                   value="<?= htmlspecialchars($filter_date) ?>"
                   style="padding:10px 14px;background:var(--noir2);border:1px solid rgba(201,167,107,.2);color:var(--blanc);font-family:var(--font-body);font-size:13px;outline:none;border-radius:0;">
        </div>
        <button type="submit" class="btn-add"><span>Filtrer</span></button>
        <?php if ($filter_date): ?>
            <a href="gestion_reservations.php" class="btn-add btn-danger"><span>✕ Réinitialiser</span></a>
        <?php endif; ?>
    </form>

    <!-- Table -->
    <div class="table-section">
        <div class="table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Date</th>
                        <th>Heure</th>
                        <th>Personnes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($total === 0): ?>
                    <tr>
                        <td colspan="6" style="text-align:center;padding:40px;color:var(--gris);">
                            Aucune réservation trouvée
                        </td>
                    </tr>
                <?php else: ?>
                    <?php while ($r = mysqli_fetch_assoc($res)): ?>
                        <tr>
                            <td><?= $r['id'] ?></td>
                            <td><?= htmlspecialchars($r['nom'] ?? '—') ?></td>
                            <td><?= htmlspecialchars($r['date_reservation']) ?></td>
                            <td><?= htmlspecialchars($r['heure']) ?></td>
                            <td>
                                <span class="badge badge-gold">
                                    <?= (int)$r['personnes'] ?> pers.
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="?delete=<?= $r['id'] ?>"
                                       class="btn-icon danger"
                                       onclick="return confirm('Supprimer cette réservation ?');"
                                       title="Supprimer">🗑</a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
</body>
</html>