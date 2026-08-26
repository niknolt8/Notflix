<?php

session_start();

require_once "config/database.php";


/* =========================
   FILM À LA UNE : THE RIP
========================= */

$sqlUne = "SELECT
                Contenu.*,
                Genre.NomGenre
           FROM Contenu
           INNER JOIN Genre
                ON Contenu.IdGenre = Genre.IdGenre
           WHERE Contenu.Titre = 'The Rip'
           LIMIT 1";

$stmtUne = $pdo->query($sqlUne);

$contenuUne = $stmtUne->fetch(PDO::FETCH_ASSOC);


/* =========================
   FILMS RÉCENTS
========================= */

$sqlFilms = "SELECT
                Contenu.*,
                Genre.NomGenre
             FROM Contenu
             INNER JOIN Genre
                ON Contenu.IdGenre = Genre.IdGenre
             WHERE Contenu.Type = 'film'
             ORDER BY Contenu.Annee DESC, Contenu.IdContenu DESC
             LIMIT 5";

$stmtFilms = $pdo->query($sqlFilms);

$films = $stmtFilms->fetchAll(PDO::FETCH_ASSOC);


/* =========================
   SÉRIES RÉCENTES
========================= */

$sqlSeries = "SELECT
                Contenu.*,
                Genre.NomGenre
              FROM Contenu
              INNER JOIN Genre
                ON Contenu.IdGenre = Genre.IdGenre
              WHERE Contenu.Type = 'serie'
              ORDER BY Contenu.Annee DESC, Contenu.IdContenu DESC
              LIMIT 5";

$stmtSeries = $pdo->query($sqlSeries);

$series = $stmtSeries->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notflix - Accueil</title>
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
            <a href="index.php">Accueil</a>
            <a href="films.php">Films</a>
            <a href="series.php">Séries</a>
            <a href="recherche.php">Recherche</a>

            <?php if (isset($_SESSION["IdUtilisateur"])): ?>
                <a href="ma-liste.php">Ma liste</a>
                <a href="deconnexion.php">Déconnexion</a>
            <?php else: ?>
                <a href="connexion.php">Connexion</a>
                <a href="inscription.php">Inscription</a>
            <?php endif; ?>
        </nav>

    </header>


    <!-- =========================
         FILM À LA UNE
    ========================== -->

    <?php if ($contenuUne): ?>

        <section class="hero">

            <div class="hero-content">

                <p class="hero-label">
                    FILM À LA UNE
                </p>

                <h1>
                    <?= htmlspecialchars($contenuUne["Titre"]) ?>
                </h1>

                <div class="hero-info">
                    <span><?= htmlspecialchars($contenuUne["Annee"]) ?></span>
                    <span><?= htmlspecialchars($contenuUne["NomGenre"]) ?></span>
                    <span><?= htmlspecialchars($contenuUne["Duree"]) ?> min</span>
                </div>

                <p class="hero-description">
                    <?= htmlspecialchars($contenuUne["Description"]) ?>
                </p>

                <div class="hero-buttons">

                    <a
                        href="detail.php?id=<?= $contenuUne["IdContenu"] ?>"
                        class="btn"
                    >
                        ▶ Voir le détail
                    </a>

                    <?php if (isset($_SESSION["IdUtilisateur"])): ?>
                        <a
                            href="ajouter-liste.php?id=<?= $contenuUne["IdContenu"] ?>"
                            class="btn-secondary"
                        >
                            + Ma liste
                        </a>
                    <?php endif; ?>

                </div>

            </div>

        </section>

    <?php endif; ?>


    <!-- =========================
         CONTENU PRINCIPAL
    ========================== -->

    <main class="container">

        <!-- FILMS RÉCENTS -->

        <section class="content-section">

            <div class="section-header">
                <h2>Films récents</h2>
                <a href="films.php">Voir tous les films →</a>
            </div>

            <div class="cards">

                <?php foreach ($films as $film): ?>

                    <article class="card">

                        <img
                            src="<?= htmlspecialchars($film["Affiche"]) ?>"
                            alt="<?= htmlspecialchars($film["Titre"]) ?>"
                        >

                        <div class="card-content">

                            <h3>
                                <?= htmlspecialchars($film["Titre"]) ?>
                            </h3>

                            <p>
                                <?= htmlspecialchars($film["Annee"]) ?>
                                •
                                <?= htmlspecialchars($film["NomGenre"]) ?>
                            </p>

                            <a
                                href="detail.php?id=<?= $film["IdContenu"] ?>"
                                class="btn-small"
                            >
                                Voir le détail
                            </a>

                        </div>

                    </article>

                <?php endforeach; ?>

            </div>

        </section>


        <!-- SÉRIES RÉCENTES -->

        <section class="content-section">

            <div class="section-header">
                <h2>Séries récentes</h2>
                <a href="series.php">Voir toutes les séries →</a>
            </div>

            <div class="cards">

                <?php foreach ($series as $serie): ?>

                    <article class="card">

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
                                •
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

        </section>

    </main>


    <!-- =========================
         FOOTER
    ========================== -->

    <footer>
        <p>© 2026 Notflix</p>
    </footer>

</body>
</html>