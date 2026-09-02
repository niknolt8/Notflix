<?php

session_start();

require_once "config/database.php";


/* Vérifier la connexion */

if (!isset($_SESSION["IdUtilisateur"])) {

    header("Location: connexion.php");

    exit;
}


/* Vérifier l'identifiant */

if (!isset($_GET["id"])) {

    header("Location: ma-liste.php");

    exit;
}


$idUtilisateur = $_SESSION["IdUtilisateur"];

$idContenu = $_GET["id"];


/* Supprimer de la liste */

$sql = "DELETE FROM Ma_Liste
        WHERE IdUtilisateur = ?
        AND IdContenu = ?";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $idUtilisateur,
    $idContenu
]);


/* Retourner à Ma liste */

header("Location: ma-liste.php");

exit;