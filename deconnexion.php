<?php
session_start();
/* Détruire toutes les variables de session */
$_SESSION = [];

/* Détruire la session */
session_destroy();

/* Retour à l'accueil */
header("Location: index.php");

exit;