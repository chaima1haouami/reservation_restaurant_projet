<?php
session_start();
require_once __DIR__ . '/../config/db.php';

$error = "";

/* SI DÉJÀ CONNECTÉ */
if (isset($_SESSION['user_id'])) {
    if (($_SESSION['role'] ?? 'user') === 'admin') {
        header("Location: ../admin/dashboard.php");
    } else {
        header("Location: ../profile.php");
    }
    exit;
}

/* LOGIN */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($email === '' || $password === '') {
        $error = "Tous les champs sont obligatoires";
    } else {

        $e = mysqli_real_escape_string($conn, $email);
        $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$e'");

        if ($row = mysqli_fetch_assoc($result)) {

            if (password_verify($password, $row['password'])) {

                $_SESSION['user_id'] = $row['id'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['nom'] = $row['nom'];
                $_SESSION['email'] = $row['email'];

                if ($row['role'] === 'admin') {
                    header("Location: ../admin/dashboard.php");
                } else {
                    header("Location: ../profile.php");
                }
                exit;

            } else {
                $error = "Mot de passe incorrect";
            }

        } else {
            $error = "Email introuvable";
        }
    }
}

$BASE_URL = "/reservation_restaurant_projet";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link rel="stylesheet" href="<?= $BASE_URL ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?= $BASE_URL ?>/assets/css/login.css">

    <title>Connexion</title>
</head>

<body>

<div class="form-page">

  <div class="form-card">

    <div class="login-badge">Espace Client</div>

    <h2>Bon <em>Retour</em></h2>

    <p class="form-subtitle">Connectez-vous à votre compte</p>

    <div class="divider-gold"></div>

    <?php if (!empty($error)): ?>
      <div class="alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">

      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" required>
      </div>

      <div class="form-group">
        <label>Mot de passe</label>
        <input type="password" name="password" required>
      </div>

      <button class="btn-lux" type="submit">
        <span>Se connecter</span>
      </button>

    </form>

    <p class="form-link">
      Pas encore de compte ?
      <a href="<?= $BASE_URL ?>/auth/register.php">Créer un compte</a>
    </p>

  </div>

</div>

</body>
</html>