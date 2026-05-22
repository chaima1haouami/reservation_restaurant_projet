<?php
session_start();
include 'config/db.php';

/* =========================
   VÉRIFICATION CONNEXION
========================= */
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}

$user_id = (int) $_SESSION['user_id'];

/* =========================
   ANNULER UN PLAT (SUPPRIMER)
========================= */
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];

    mysqli_query($conn, "
        DELETE FROM commandes
        WHERE id = $id
        AND user_id = $user_id
        AND statut = 'panier'
    ");

    header("Location: commandes.php");
    exit;
}

/* =========================
   VALIDER LE PANIER
   → redirection vers paiement.php
========================= */
if (isset($_GET['pay_all'])) {
    header("Location: paiement.php");
    exit;
}

/* =========================
   RÉCUPÉRER LES ARTICLES DU PANIER
========================= */
$commandes = mysqli_query($conn, "
    SELECT
        c.id,
        c.quantite,
        c.total,
        p.nom,
        p.prix,
        p.categorie
    FROM commandes c
    INNER JOIN plats p ON c.plat_id = p.id
    WHERE c.user_id = $user_id
    AND c.statut = 'panier'
    ORDER BY c.id DESC
");

$total_global = 0;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Panier</title>

    <!-- CSS GLOBAL -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- CSS ADMIN POUR TABLEAUX -->
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<div class="admin-wrapper">

    <!-- HEADER -->
    <div class="page-header">
        <div class="page-header-left">
            <span class="page-tag">PANIER</span>
            <h1>🛒 Mon Panier</h1>
            <p>Consultez vos plats avant de confirmer votre paiement.</p>
        </div>
    </div>

    <?php if (mysqli_num_rows($commandes) == 0): ?>

        <div class="alert alert-error">
            Votre panier est vide 😕
        </div>

        <a href="menu.php" class="btn-primary">
            <span>Voir le menu</span>
        </a>

    <?php else: ?>

        <!-- TABLEAU -->
        <div class="table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Plat</th>
                        <th>Catégorie</th>
                        <th>Prix</th>
                        <th>Quantité</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                <?php while ($c = mysqli_fetch_assoc($commandes)): ?>
                    <?php $total_global += $c['total']; ?>

                    <tr>
                        <td><?= htmlspecialchars($c['nom']) ?></td>
                        <td><?= htmlspecialchars($c['categorie']) ?></td>
                        <td><?= number_format($c['prix'], 2) ?> DT</td>
                        <td><?= (int)$c['quantite'] ?></td>
                        <td><?= number_format($c['total'], 2) ?> DT</td>

                        <td>
                            <!-- ANNULER / SUPPRIMER -->
                            <a href="commandes.php?delete=<?= $c['id'] ?>"
                               class="btn-icon danger"
                               onclick="return confirm('Annuler ce plat ?')"
                               title="Annuler">
                                🗑
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- TOTAL + ACTIONS -->
        <div class="page-header" style="margin-top: 30px;">
            <h2 style="color: var(--or);">
                Total à payer : <?= number_format($total_global, 2) ?> DT
            </h2>

            <div class="action-btns">
                <!-- VALIDER -->
                <a href="commandes.php?pay_all=1"
                   class="btn-primary"
                   onclick="return confirm('Valider votre panier et passer au paiement ?')">
                    <span>💳 Valider et Payer</span>
                </a>
            </div>
        </div>

    <?php endif; ?>

</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>