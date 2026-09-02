<?php
session_start();
require_once "config/database.php";

/* Récupérer uniquement les films */

$sql = "SELECT
            Contenu.*,
            Genre.NomGenre

        FROM Contenu

        INNER JOIN Genre
            ON Contenu.IdGenre = Genre.IdGenre

        WHERE Contenu.Type = 'film'

        ORDER BY Contenu.Annee DESC";




$stmt = $pdo->query($sql);

$films = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Films - Notflix</title>

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


    <!-- Contenu -->

    <main class="container">

        <h1>Nos films</h1>

        <!-- Filtres -->

<div class="filters">

    <button class="filter-btn active" data-genre="Tous">
        Tous
    </button>

    <button class="filter-btn" data-genre="Action">
        Action
    </button>

    <button class="filter-btn" data-genre="Comédie">
        Comédie
    </button>

    <button class="filter-btn" data-genre="Drame">
        Drame
    </button>

    <button class="filter-btn" data-genre="Horreur">
        Horreur
    </button>

    <button class="filter-btn" data-genre="Science-fiction">
        Science-fiction
    </button>

</div>


<!-- Films -->

<div class="cards">

    <?php foreach ($films as $film): ?>

        <article
            class="card film-card"
            data-genre="<?= htmlspecialchars($film['NomGenre']) ?>"
        >

            <img
                src="<?= htmlspecialchars($film['Affiche']) ?>"
                alt="<?= htmlspecialchars($film['Titre']) ?>"
            >

            <div class="card-content">

                <h3>
                    <?= htmlspecialchars($film['Titre']) ?>
                </h3>

                <p>
                    <?= $film['Annee'] ?>
                </p>

                <p>
                    <?= htmlspecialchars($film['NomGenre']) ?>
                </p>

                <a
                    href="detail.php?id=<?= $film['IdContenu'] ?>"
                    class="btn-small"
                >
                    Voir le détail
                </a>

            </div>

        </article>

    <?php endforeach; ?>

</div>

    </main>


    <footer>

        <p>
            © 2026 Notflix
        </p>

    </footer>
<script src="js/script.js"></script>
</body>

</html>