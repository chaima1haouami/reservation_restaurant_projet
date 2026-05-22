<?php
session_start();

/* vider session */
$_SESSION = [];
session_unset();
session_destroy();

/* redirection vers login */
header("Location: login.php");
exit;
?>