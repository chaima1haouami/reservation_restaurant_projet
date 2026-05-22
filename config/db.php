<?php

$BASE_URL = "/reservation_restaurant_projet";

/* AIDE VS CODE À COMPRENDRE $conn */
 /** @var mysqli $conn */

/* CONNEXION */
$conn = mysqli_connect("localhost", "root", "", "restaurant_db");

/* GESTION ERREUR PROPRE */
if (!$conn) {
    die("Erreur connexion base de données");
}

?>