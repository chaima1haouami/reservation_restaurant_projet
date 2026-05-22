<?php
session_start();
require_once __DIR__ . '/../config/db.php';

/* ==========================================================
   CONFIGURATION
========================================================== */
$BASE_URL = "/reservation_restaurant_projet";

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom      = trim($_POST['nom'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($nom === '' || $email === '' || $password === '') {
        $error = "Tous les champs sont obligatoires";
    } else {

        $e = mysqli_real_escape_string($conn, $email);

        $check = mysqli_query($conn, "SELECT id FROM users WHERE email = '$e'");

        if (mysqli_num_rows($check) > 0) {
            $error = "Email déjà utilisé";
        } else {

            $n    = mysqli_real_escape_string($conn, $nom);
            $hash = password_hash($password, PASSWORD_DEFAULT);

            mysqli_query($conn, "
                INSERT INTO users (nom, email, password, role)
                VALUES ('$n', '$e', '$hash', 'user')
            ");

            header("Location: {$BASE_URL}/auth/login.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Restaurant Pro</title>

    <!-- CSS -->
    <link rel="stylesheet" href="<?= $BASE_URL ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?= $BASE_URL ?>/assets/css/login.css">
</head>
<body>

<div class="form-page">

    <div class="form-card">

        <div class="login-badge">Inscription</div>

        <h2>Créer <em>Compte</em></h2>

        <p class="form-subtitle">Rejoignez notre restaurant</p>

        <div class="divider-gold"></div>

        <?php if (!empty($error)): ?>
            <div class="alert-error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST">

            <div class="form-group">
                <label>Nom</label>
                <input type="text" name="nom" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="password" required>
            </div>

            <button class="btn-lux" type="submit">
                <span>S'inscrire</span>
            </button>

        </form>

        <p class="form-link">
            Déjà inscrit ?
            <a href="<?= $BASE_URL ?>/auth/login.php">Connexion</a>
        </p>

    </div>

</div>

</body>
</html>