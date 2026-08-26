<?php

session_start();

require_once "config/database.php";


/* =========================
   RÉCUPÉRER LES SÉRIES
   AVEC LEUR GENRE
========================= */

$sql = "SELECT
            Contenu.*,
            Genre.NomGenre
        FROM Contenu
        INNER JOIN Genre
            ON Contenu.IdGenre = Genre.IdGenre
        WHERE Contenu.Type = 'serie'
        ORDER BY Contenu.Annee DESC";

$stmt = $pdo->query($sql);

$series = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>

<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Séries - Notflix</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>


    <!-- =========================
         NAVIGATION
    ========================== -->

    <header class="navbar">

        <div class="logo">
            NOTFLIX
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
         CONTENU
    ========================== -->

    <main class="container">

        <h1>
            Nos séries
        </h1>


        <!-- =========================
             FILTRES
        ========================== -->

        <div class="filters">

            <button
                class="filter-btn active"
                data-genre="Tous"
            >
                Tous
            </button>

            <button
                class="filter-btn"
                data-genre="Action"
            >
                Action
            </button>

            <button
                class="filter-btn"
                data-genre="Comédie"
            >
                Comédie
            </button>

            <button
                class="filter-btn"
                data-genre="Drame"
            >
                Drame
            </button>

            <button
                class="filter-btn"
                data-genre="Horreur"
            >
                Horreur
            </button>

            <button
                class="filter-btn"
                data-genre="Science-fiction"
            >
                Science-fiction
            </button>

        </div>


        <!-- =========================
             SÉRIES
        ========================== -->

        <div class="cards">

            <?php foreach ($series as $serie): ?>

                <article
                    class="card serie-card"
                    data-genre="<?= htmlspecialchars($serie["NomGenre"]) ?>"
                >

                    <img
                        src="<?= htmlspecialchars($serie["Affiche"]) ?>"
                        alt="<?= htmlspecialchars($serie["Titre"]) ?>"
                    >


                    <div class="card-content">

                        <h3>
                            <?= htmlspecialchars($serie["Titre"]) ?>
                        </h3>


                        <p>
                            <?= htmlspecialchars($serie["Annee"]) ?>
                        </p>


                        <p>
                            <?= htmlspecialchars($serie["NomGenre"]) ?>
                        </p>


                        <a
                            href="detail.php?id=<?= $serie["IdContenu"] ?>"
                            class="btn-small"
                        >
                            Voir le détail
                        </a>

                    </div>

                </article>

            <?php endforeach; ?>

        </div>

    </main>


    <!-- =========================
         FOOTER
    ========================== -->

    <footer>

        <p>
            © 2026 Notflix
        </p>

    </footer>


    <!-- JavaScript des filtres -->

    <script src="js/script.js"></script>


</body>

</html>