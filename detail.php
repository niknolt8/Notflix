<?php

session_start();

require_once "config/database.php";


/* =========================
   VÉRIFIER L'ID
========================= */

if (!isset($_GET["id"])) {

    header("Location: index.php");

    exit;
}


$idContenu = $_GET["id"];


/* =========================
   RÉCUPÉRER LE CONTENU
========================= */

$sql = "SELECT
            Contenu.*,
            Genre.NomGenre

        FROM Contenu

        INNER JOIN Genre
            ON Contenu.IdGenre = Genre.IdGenre

        WHERE Contenu.IdContenu = ?";


$stmt = $pdo->prepare($sql);

$stmt->execute([$idContenu]);

$contenu = $stmt->fetch(PDO::FETCH_ASSOC);


/* =========================
   VÉRIFIER LE CONTENU
========================= */

if (!$contenu) {

    header("Location: index.php");

    exit;
}


/* =========================
   VÉRIFIER MA LISTE
========================= */

$dansMaListe = false;


if (isset($_SESSION["IdUtilisateur"])) {

    $sql = "SELECT *
            FROM Ma_Liste
            WHERE IdUtilisateur = ?
            AND IdContenu = ?";


    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $_SESSION["IdUtilisateur"],
        $idContenu
    ]);


    if ($stmt->fetch()) {

        $dansMaListe = true;
    }
}

?>


<!DOCTYPE html>

<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?= htmlspecialchars($contenu["Titre"]) ?> - Notflix
    </title>

    <link rel="stylesheet" href="style.css">

</head>

<body>


    <!-- =========================
         NAVIGATION
    ========================== -->

    <header class="navbar">

        <div class="logo">
            <a href="index.php">
            <img src="images/logo.png" alt="Notflix Production">
            </a>
        </div>


        <nav>

            <a href="index.php">
                Accueil
            </a>

            <a href="films.php">
                Films
            </a>

            <a href="series.php">
                Séries
            </a>

            <a href="recherche.php">
                Recherche
            </a>


            <?php if (isset($_SESSION["IdUtilisateur"])): ?>

                <a href="ma-liste.php">
                    Ma liste
                </a>

                <a href="deconnexion.php">
                    Déconnexion
                </a>

            <?php else: ?>

                <a href="connexion.php">
                    Connexion
                </a>

                <a href="inscription.php">
                    Inscription
                </a>

            <?php endif; ?>

        </nav>

    </header>


    <!-- =========================
         DÉTAIL
    ========================== -->

    <main class="detail-container">

        <section class="detail">


            <!-- Affiche -->

            <div class="detail-image">

                <img
                    src="<?= htmlspecialchars($contenu["Affiche"]) ?>"
                    alt="<?= htmlspecialchars($contenu["Titre"]) ?>"
                >

            </div>


            <!-- Informations -->

            <div class="detail-content">

                <p class="detail-type">

                    <?= htmlspecialchars($contenu["Type"]) ?>

                </p>


                <h1>

                    <?= htmlspecialchars($contenu["Titre"]) ?>

                </h1>


                <div class="detail-info">

    <div class="info-item">

        <span class="info-label">
            ANNÉE
        </span>

        <span class="info-value">
            <?= $contenu["Annee"] ?>
        </span>

    </div>


    <div class="info-item">

        <span class="info-label">
            GENRE
        </span>

        <span class="info-value">
            <?= htmlspecialchars($contenu["NomGenre"]) ?>
        </span>

    </div>


    <div class="info-item">

        <span class="info-label">
            DURÉE
        </span>

        <span class="info-value">
            <?= $contenu["Duree"] ?> min
        </span>

    </div>

</div>


                <p class="detail-description">

                    <?= htmlspecialchars($contenu["Description"]) ?>

                </p>


                <!-- Boutons -->

                <div class="detail-buttons">


                    <?php if (isset($_SESSION["IdUtilisateur"])): ?>


                        <?php if ($dansMaListe): ?>

                            <a
                                href="supprimer-liste.php?id=<?= $contenu["IdContenu"] ?>"
                                class="btn-secondary"
                            >
                                ✓ Déjà dans ma liste - supprimer
                            </a>


                        <?php else: ?>

                            <a
                                href="ajouter-liste.php?id=<?= $contenu["IdContenu"] ?>"
                                class="btn"
                            >
                                + Ajouter à ma liste
                            </a>

                        <?php endif; ?>


                    <?php else: ?>

                        <a
                            href="connexion.php"
                            class="btn"
                        >
                            Se connecter pour ajouter
                        </a>

                    <?php endif; ?>


                    <a
                        href="index.php"
                        class="btn-secondary"
                    >
                        ← Retour
                    </a>

                </div>

            </div>

        </section>

    </main>


    <!-- =========================
         FOOTER
    ========================== -->

    <footer>

        <p>
            © 2026 Notflix
        </p>

    </footer>


</body>

</html>