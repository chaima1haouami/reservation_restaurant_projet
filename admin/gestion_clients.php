<?php
session_start();
include '../config/db.php';

/* =========================
   SECURITE ADMIN
========================= */
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

/* =========================
   SUPPRESSION CLIENT
========================= */
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    mysqli_query($conn, "DELETE FROM users WHERE id = $id");
    header("Location: gestion_clients.php");
    exit;
}

/* =========================
   RECHERCHE
========================= */
$search = $_GET['search'] ?? '';

if (!empty($search)) {
    $clients = mysqli_query($conn, "
        SELECT * FROM users
        WHERE nom LIKE '%$search%'
        OR email LIKE '%$search%'
        ORDER BY id DESC
    ");
} else {
    $clients = mysqli_query($conn, "
        SELECT * FROM users ORDER BY id DESC
    ");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Clients</title>

    <link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body>

<?php include '../includes/admin_navbar.php'; ?>

<div class="admin-wrapper">

    <!-- HEADER -->
    <div class="page-header">

        <div class="page-header-left">
            <span class="page-tag">GESTION</span>
            <h1> Clients</h1>
        </div>

        <form method="GET" class="search-bar">
            <input type="text" name="search"
                   placeholder="Nom ou email..."
                   value="<?= htmlspecialchars($search) ?>">
            <button type="submit">🔍</button>
        </form>

    </div>

    <!-- TABLE -->
    <div class="table-container">

        <table class="admin-table">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

            <?php if (mysqli_num_rows($clients) > 0): ?>
                <?php while ($c = mysqli_fetch_assoc($clients)): ?>
                    <tr>

                        <td><?= $c['id'] ?></td>

                        <td><?= htmlspecialchars($c['nom'] ?? '') ?></td>

                        <td><?= htmlspecialchars($c['email'] ?? '') ?></td>

                        <td>
                            <?php if (($c['role'] ?? '') === 'admin'): ?>
                                <span class="badge badge-red">ADMIN</span>
                            <?php else: ?>
                                <span class="badge badge-gold">USER</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <div class="action-btns">

                                <a class="btn-icon"
                                   href="edit_client.php?id=<?= $c['id'] ?>">
                                    ✏️
                                </a>

                                <a class="btn-icon danger"
                                   href="gestion_clients.php?delete=<?= $c['id'] ?>"
                                   onclick="return confirm('Supprimer ce client ?')">
                                    🗑️
                                </a>

                            </div>
                        </td>

                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align:center; padding:20px;">
                        Aucun client trouvé
                    </td>
                </tr>
            <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>