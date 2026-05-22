<?php
session_start();
include '../config/db.php';


if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}


if (!isset($_GET['id'])) {
    header("Location: gestion_clients.php");
    exit;
}

$id = (int) $_GET['id'];


$result = mysqli_query($conn, "SELECT * FROM users WHERE id = $id");
$client = mysqli_fetch_assoc($result);

if (!$client) {
    die("Client introuvable");
}

/* =========================
   UPDATE CLIENT
========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom   = mysqli_real_escape_string($conn, $_POST['nom']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role  = mysqli_real_escape_string($conn, $_POST['role']);

    mysqli_query($conn, "
        UPDATE users 
        SET nom='$nom', email='$email', role='$role'
        WHERE id=$id
    ");

    header("Location: gestion_clients.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Client</title>

    <link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body>

<?php include '../includes/admin_navbar.php'; ?>

<div class="admin-wrapper">

    <div class="page-header">
        <div>
            <span class="page-tag">MODIFICATION</span>
            <h1>Modifier Client</h1>
        </div>
    </div>

    <form method="POST" class="admin-form">

        <div class="form-field">
            <label>Nom</label>
            <input type="text" name="nom"
                   value="<?= htmlspecialchars($client['nom']) ?>"
                   required>
        </div>

        <div class="form-field">
            <label>Email</label>
            <input type="email" name="email"
                   value="<?= htmlspecialchars($client['email']) ?>"
                   required>
        </div>

        <div class="form-field">
            <label>Rôle</label>
            <select name="role">
                <option value="user" <?= $client['role']=='user'?'selected':'' ?>>User</option>
                <option value="admin" <?= $client['role']=='admin'?'selected':'' ?>>Admin</option>
            </select>
        </div>

        <button type="submit" class="btn-primary">
             Sauvegarder
        </button>

    </form>

</div>

</body>
</html>