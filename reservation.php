<?php
include 'config/db.php';
session_start();

$message = "";

if (isset($_POST['reserver'])) {

    $nom = trim($_POST['nom']);
    $date = $_POST['date'];
    $heure = $_POST['heure'];
    $personnes = intval($_POST['personnes']);

    if (empty($nom) || empty($date) || empty($heure) || $personnes <= 0) {
        $message = "⚠️ Veuillez remplir tous les champs correctement";
    } else {

        /* IMPORTANT :
           Dans votre base de données, les colonnes sont :
           - nom
           - date_reservation
           - heure
           - personnes
        */

        $sql = "INSERT INTO reservations (nom, date_reservation, heure, personnes)
                VALUES (?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssi", $nom, $date, $heure, $personnes);

            if (mysqli_stmt_execute($stmt)) {
                $message = "✅ Réservation envoyée avec succès";
            } else {
                $message = "❌ Erreur lors de l'enregistrement";
            }

            mysqli_stmt_close($stmt);
        } else {
            $message = "❌ Erreur de préparation SQL";
        }
    }
}
?>

<?php include 'includes/header.php'; ?>

<h1>📅 Réservation</h1>

<p class="reservation-message">
    <?= htmlspecialchars($message) ?>
</p>

<form method="POST" class="reservation">

    <input type="text"
           name="nom"
           placeholder="Nom complet"
           required>

    <input type="date"
           name="date"
           required>

    <input type="time"
           name="heure"
           required>

    <input type="number"
           name="personnes"
           placeholder="Nombre de personnes"
           min="1"
           required>

    <button type="submit" name="reserver">
        Réserver
    </button>

</form>

<?php include 'includes/footer.php'; ?>