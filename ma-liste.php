<?php

session_start();

require_once "config/database.php";


/* Vérifier que l'utilisateur est connecté */

if (!isset($_SESSION["IdUtilisateur"])) {

    header("Location: connexion.php");

    exit;
}


/* Récupérer l'identifiant de l'utilisateur */

$idUtilisateur = $_SESSION["IdUtilisateur"];


/* Récupérer les contenus de ma liste */

$sql = "SELECT
            Contenu.*,
            Genre.NomGenre,
            Ma_Liste.DateAjout

        FROM Ma_Liste

        INNER JOIN Contenu
            ON Ma_Liste.IdContenu = Contenu.IdContenu

        INNER JOIN Genre
            ON Contenu.IdGenre = Genre.IdGenre

        WHERE Ma_Liste.IdUtilisateur = ?

        ORDER BY Ma_Liste.DateAjout DESC";


$stmt = $pdo->prepare($sql);

$stmt->execute([$idUtilisateur]);

$maListe = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>

<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ma liste - Notflix</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>


    <!-- Navigation -->

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

            <a href="ma-liste.php">
                Ma liste
            </a>

            <a href="deconnexion.php">
                Déconnexion
            </a>

        </nav>

    </header>


    <!-- Ma liste -->

    <main class="container">

        <h1>Ma liste</h1>


        <?php if (empty($maListe)): ?>

            <p class="message">
                Votre liste est vide.
            </p>

            <a href="films.php" class="btn">
                Découvrir les films
            </a>


        <?php else: ?>


            <div class="cards">

                <?php foreach ($maListe as $contenu): ?>

                    <article class="card">

                        <img
                            src="<?= htmlspecialchars($contenu['Affiche']) ?>"
                            alt="<?= htmlspecialchars($contenu['Titre']) ?>"
                        >

                        <div class="card-content">

                            <h3>
                                <?= htmlspecialchars($contenu['Titre']) ?>
                            </h3>

                            <p>
                                <?= $contenu['Annee'] ?>
                            </p>

                            <p>
                                <?= htmlspecialchars($contenu['NomGenre']) ?>
                            </p>


                            <a
                                href="detail.php?id=<?= $contenu['IdContenu'] ?>"
                                class="btn-small"
                            >
                                Voir le détail
                            </a>
                            <a
                                href="supprimer-liste.php?id=<?= $contenu['IdContenu'] ?>"
                                class="btn-small"
                            >
                                Supprimer
                            </a>

                        </div>

                    </article>

                <?php endforeach; ?>

            </div>


        <?php endif; ?>

    </main>


    <footer>

        <p>
            © 2026 Notflix
        </p>

    </footer>


</body>

</html>