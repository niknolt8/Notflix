<?php

session_start();

require_once "config/database.php";


/* Variable pour stocker la recherche */

$recherche = "";


/* Tableau des résultats */

$resultats = [];


/* Vérifier si une recherche a été effectuée */

if (isset($_GET["recherche"])) {

    $recherche = trim($_GET["recherche"]);


    /* Vérifier que la recherche n'est pas vide */

    if ($recherche !== "") {

        $sql = "SELECT
                    Contenu.*,
                    Genre.NomGenre

                FROM Contenu

                INNER JOIN Genre
                    ON Contenu.IdGenre = Genre.IdGenre

                WHERE Contenu.Titre LIKE ?

                ORDER BY Contenu.Annee DESC";


        $stmt = $pdo->prepare($sql);


        /* Ajouter % pour rechercher une partie du titre */

        $motRecherche = "%" . $recherche . "%";


        $stmt->execute([$motRecherche]);


        $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>

<!DOCTYPE html>

<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Recherche - Notflix</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>


    <!-- Navigation -->

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


    <!-- Recherche -->

    <main class="container">

        <h1>Rechercher un film ou une série</h1>


        <form
            method="GET"
            action="recherche.php"
            class="search-form"
        >

            <input
                type="search"
                name="recherche"
                placeholder="Exemple : Frankenstein"
                value="<?= htmlspecialchars($recherche) ?>"
            >

            <button type="submit">
                🔎 Rechercher
            </button>

        </form>


        <?php if ($recherche !== ""): ?>

            <h2>
                Résultats pour :
                "<?= htmlspecialchars($recherche) ?>"
            </h2>


            <?php if (empty($resultats)): ?>

                <p class="message">
                    Aucun résultat trouvé.
                </p>


            <?php else: ?>


                <div class="cards">

                    <?php foreach ($resultats as $contenu): ?>

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


                                <p>
                                    <?= htmlspecialchars($contenu['Type']) ?>
                                </p>


                                <a
                                    href="detail.php?id=<?= $contenu['IdContenu'] ?>"
                                    class="btn-small"
                                >
                                    Voir le détail
                                </a>

                            </div>

                        </article>

                    <?php endforeach; ?>

                </div>


            <?php endif; ?>

        <?php endif; ?>

    </main>


    <footer>

        <p>
            © 2026 Notflix
        </p>

    </footer>


</body>

</html>