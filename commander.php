<?php
session_start();
include 'config/db.php';

/* =========================
   LOGIN CHECK
========================= */
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}

/* =========================
   VALIDATION POST
========================= */
if (!isset($_POST['id_plat'])) {
    header("Location: menu.php");
    exit;
}

$user_id = (int) $_SESSION['user_id'];
$id_plat = (int) $_POST['id_plat'];

/* =========================
   VERIFIER PLAT
========================= */
$res = mysqli_query($conn, "SELECT prix FROM plats WHERE id = $id_plat");
$plat = mysqli_fetch_assoc($res);

if (!$plat) {
    header("Location: menu.php");
    exit;
}

$prix = (float) $plat['prix'];

/* =========================
   CHECK SI DEJA DANS PANIER
========================= */
$check = mysqli_query($conn, "
    SELECT * FROM commandes 
    WHERE user_id = $user_id 
    AND plat_id = $id_plat 
    AND statut = 'panier'
");

/* =========================
   UPDATE OU INSERT
========================= */
if (mysqli_num_rows($check) > 0) {

    // déjà dans panier → augmenter quantité
    mysqli_query($conn, "
        UPDATE commandes 
        SET quantite = quantite + 1,
            total = total + $prix
        WHERE user_id = $user_id 
        AND plat_id = $id_plat 
        AND statut = 'panier'
    ");

} else {

    // nouveau produit
    mysqli_query($conn, "
        INSERT INTO commandes (user_id, plat_id, quantite, total, statut)
        VALUES ($user_id, $id_plat, 1, $prix, 'panier')
    ");
}

/* =========================
   REDIRECTION
========================= */
header("Location: commandes.php?success=1");
exit;
?>