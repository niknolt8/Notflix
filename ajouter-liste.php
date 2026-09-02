<?php

session_start();

require_once "config/database.php";


/* Vérifier que l'utilisateur est connecté */

if (!isset($_SESSION["IdUtilisateur"])) {

    header("Location: connexion.php");

    exit;
}


/* Vérifier que l'identifiant du contenu existe */

if (!isset($_GET["id"])) {

    header("Location: index.php");

    exit;
}


$idUtilisateur = $_SESSION["IdUtilisateur"];

$idContenu = $_GET["id"];


/* Vérifier que le contenu existe */

$sql = "SELECT IdContenu
        FROM Contenu
        WHERE IdContenu = ?";

$stmt = $pdo->prepare($sql);

$stmt->execute([$idContenu]);

$contenu = $stmt->fetch();


if (!$contenu) {

    die("Contenu introuvable.");
}


/* Vérifier si le contenu est déjà dans la liste */

$sql = "SELECT *
        FROM Ma_Liste
        WHERE IdUtilisateur = ?
        AND IdContenu = ?";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $idUtilisateur,
    $idContenu
]);

$dejaPresent = $stmt->fetch();


if (!$dejaPresent) {

    /* Ajouter à la liste */

    $sql = "INSERT INTO Ma_Liste
            (IdUtilisateur, IdContenu)
            VALUES (?, ?)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $idUtilisateur,
        $idContenu
    ]);
}


/* Retourner sur la page détail */

header("Location: detail.php?id=" . $idContenu);

exit;