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
   RÉCUPÉRER LE TOTAL DU PANIER
========================= */
$res = mysqli_query($conn, "
    SELECT SUM(total) AS total
    FROM commandes
    WHERE user_id = $user_id
    AND statut = 'panier'
");

$data = mysqli_fetch_assoc($res);
$total = $data['total'] ?? 0;

/* =========================
   SI CONFIRMATION DU PAIEMENT
========================= */
if (isset($_POST['confirmer_paiement'])) {

    mysqli_query($conn, "
        UPDATE commandes
        SET statut = 'payée'
        WHERE user_id = $user_id
        AND statut = 'panier'
    ");

    header("Location: paiement.php?success=1");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paiement</title>

    <!-- CSS GLOBAL -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- CSS ADMIN POUR LE DESIGN -->
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<div class="admin-wrapper">

    <!-- HEADER -->
    <div class="page-header">
        <div class="page-header-left">
            <span class="page-tag">PAIEMENT</span>
            <h1>💳 Paiement</h1>
            <p>Finalisez votre commande en toute sécurité.</p>
        </div>
    </div>

    <?php if (isset($_GET['success'])): ?>

        <!-- MESSAGE DE SUCCÈS -->
        <div class="alert alert-success">
            ✔ Paiement effectué avec succès.
        </div>

        <!-- CARTE RÉCAPITULATIVE -->
        <div class="cards">
            <div class="card">
                <div class="card-icon">✅</div>
                <h2>Merci</h2>
                <p>Votre commande a été confirmée</p>
            </div>
        </div>

        <a href="menu.php" class="btn-primary">
            <span>Retour au menu</span>
        </a>

    <?php else: ?>

        <?php if ($total <= 0): ?>

            <!-- PANIER VIDE -->
            <div class="alert alert-error">
                Votre panier est vide 😕
            </div>

            <a href="menu.php" class="btn-primary">
                <span>Voir le menu</span>
            </a>

        <?php else: ?>

            <!-- RÉCAPITULATIF -->
            <div class="cards">
                <div class="card">
                    <div class="card-icon">💰</div>
                    <h2><?= number_format($total, 2) ?></h2>
                    <p>Total à payer (DT)</p>
                </div>
            </div>

            <!-- FORMULAIRE DE PAIEMENT -->
            <form method="post" class="admin-form">

                <div class="form-field">
                    <label>Nom du titulaire</label>
                    <input type="text"
                           name="nom"
                           placeholder="Nom complet"
                           required>
                </div>

                <div class="form-field">
                    <label>Numéro de carte</label>
                    <input type="text"
                           name="carte"
                           placeholder="1234 5678 9012 3456"
                           required>
                </div>

                <div class="form-field">
                    <label>Date d'expiration</label>
                    <input type="text"
                           name="expiration"
                           placeholder="MM/AA"
                           required>
                </div>

                <div class="form-field">
                    <label>Code CVV</label>
                    <input type="text"
                           name="cvv"
                           placeholder="123"
                           required>
                </div>

                <button type="submit"
                        name="confirmer_paiement"
                        class="btn-primary"
                        onclick="return confirm('Confirmer le paiement ?')">
                    <span>✔ Confirmer le paiement</span>
                </button>

            </form>

        <?php endif; ?>

    <?php endif; ?>

</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>