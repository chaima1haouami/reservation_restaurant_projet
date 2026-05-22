<?php
session_start();
include 'config/db.php';

/* sécurité */
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}
?>

<?php include 'includes/header.php'; ?>

<h1>👤 Mon Profil</h1>

<div class="container">

    <div class="card">

        <h3>Informations utilisateur</h3>

        <p><strong>Nom :</strong> <?= $_SESSION['nom'] ?? '' ?></p>
        <p><strong>Email :</strong> <?= $_SESSION['email'] ?? '' ?></p>
        <p><strong>Rôle :</strong> <?= $_SESSION['role'] ?? '' ?></p>

    </div>

</div>

<?php include 'includes/footer.php'; ?>