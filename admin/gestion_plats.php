<?php

session_start();
require_once __DIR__ . '/../config/db.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$message = '';
$alert_type = 'alert-success';

/* --- Suppression --- */
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM plats WHERE id=$id");
    header("Location: gestion_plats.php?msg=deleted");
    exit;
}

/* --- Ajout --- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter'])) {
    $nom  = trim(mysqli_real_escape_string($conn, $_POST['nom'] ?? ''));
    $prix = (float)($_POST['prix'] ?? 0);
    $cat  = mysqli_real_escape_string($conn, $_POST['categorie'] ?? '');
    $desc = mysqli_real_escape_string($conn, $_POST['description'] ?? '');

    if ($nom === '' || $prix <= 0) {
        $message    = "Nom et prix obligatoires.";
        $alert_type = 'alert-error';
    } else {
        mysqli_query($conn,
            "INSERT INTO plats (nom, prix, categorie, description)
             VALUES ('$nom', $prix, '$cat', '$desc')"
        );
        $message = "Plat ajouté avec succès.";
    }
}

if (isset($_GET['msg']) && $_GET['msg'] === 'deleted') {
    $message = "Plat supprimé.";
}

/* --- Lecture --- */
$result = mysqli_query($conn, "SELECT * FROM plats ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Plats — Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<?php include '../includes/admin_navbar.php'; ?>

<div class="admin-wrapper">

    <!-- En-tête -->
    <div class="page-header">
        <div class="page-header-left">
            <span class="page-tag">Administration</span>
            <h1>Gestion des <em>Plats</em></h1>
            <p><?= mysqli_num_rows($result) ?> plats au menu</p>
        </div>
    </div>

    <?php if ($message): ?>
        <div class="alert <?= $alert_type ?>"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <!-- Formulaire ajout -->
    <div class="table-section">
        <div class="table-section-header">
            <h2>Ajouter un plat</h2>
        </div>

        <form method="POST" class="admin-form">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;">
                <div class="form-field">
                    <label>Nom du plat</label>
                    <input type="text" name="nom" placeholder="Ex : Couscous Royal" required>
                </div>
                <div class="form-field">
                    <label>Prix (DT)</label>
                    <input type="number" name="prix" placeholder="Ex : 28" min="0" step="0.5" required>
                </div>
                <div class="form-field">
                    <label>Catégorie</label>
                    <input type="text" name="categorie" placeholder="Ex : Tunisien, Italien…">
                </div>
                <div class="form-field">
                    <label>Description</label>
                    <input type="text" name="description" placeholder="Courte description…">
                </div>
            </div>
            <button type="submit" name="ajouter" class="btn-add">
                <span>+ Enregistrer le plat</span>
            </button>
        </form>
    </div>

    <!-- Table -->
    <div class="table-section">
        <div class="table-section-header">
            <h2>Liste des plats</h2>
        </div>

        <div class="table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Catégorie</th>
                        <th>Prix</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                /* Re-query car le pointeur est à la fin après le count */
                $result = mysqli_query($conn, "SELECT * FROM plats ORDER BY id DESC");
                while ($p = mysqli_fetch_assoc($result)):
                ?>
                    <tr>
                        <td><?= $p['id'] ?></td>
                        <td><?= htmlspecialchars($p['nom']) ?></td>
                        <td>
                            <?php if (!empty($p['categorie'])): ?>
                                <span class="badge badge-grey"><?= htmlspecialchars($p['categorie']) ?></span>
                            <?php else: ?>—<?php endif; ?>
                        </td>
                        <td><strong style="color:var(--or)"><?= number_format($p['prix'],2) ?> DT</strong></td>
                        <td style="color:var(--gris);max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            <?= htmlspecialchars($p['description'] ?? '—') ?>
                        </td>
                        <td>
                            <div class="action-btns">
                                <a href="?delete=<?= $p['id'] ?>"
                                   class="btn-icon danger"
                                   onclick="return confirm('Supprimer ce plat ?');"
                                   title="Supprimer">🗑</a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
</body>
</html>