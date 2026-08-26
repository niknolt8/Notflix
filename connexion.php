<?php

session_start();

require_once "config/database.php";

$message = "";


/* Vérifier si le formulaire a été envoyé */

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"]);
    $motDePasse = $_POST["mot_de_passe"];


    /* Vérifier les champs */

    if (empty($email) || empty($motDePasse)) {

        $message = "Tous les champs sont obligatoires.";

    } else {

        /* Rechercher l'utilisateur */

        $sql = "SELECT *
                FROM Utilisateur
                WHERE Email = ?";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([$email]);

        $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);


        /* Vérifier le mot de passe */

        if (
            $utilisateur &&
            password_verify(
                $motDePasse,
                $utilisateur["MotDePasse"]
            )
        ) {

            /* Créer la session */

            $_SESSION["IdUtilisateur"] =
                $utilisateur["IdUtilisateur"];

            $_SESSION["Nom"] =
                $utilisateur["Nom"];

            $_SESSION["Prenom"] =
                $utilisateur["Prenom"];

            $_SESSION["Email"] =
                $utilisateur["Email"];


            /* Redirection */

            header("Location: index.php");

            exit;

        } else {

            $message = "Email ou mot de passe incorrect.";

        }
    }
}

?>

<!DOCTYPE html>

<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Connexion - Notflix</title>

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

            <a href="inscription.php">
                Inscription
            </a>

        </nav>

    </header>


    <!-- Connexion -->

    <main class="form-container">

        <h1>Connexion</h1>


        <?php if ($message !== ""): ?>

            <p class="message">
                <?= htmlspecialchars($message) ?>
            </p>

        <?php endif; ?>


        <form method="POST" action="connexion.php">


            <label for="email">
                Email
            </label>

            <input
                type="email"
                id="email"
                name="email"
                required
            >


            <label for="mot_de_passe">
                Mot de passe
            </label>

            <input
                type="password"
                id="mot_de_passe"
                name="mot_de_passe"
                required
            >


            <button type="submit">
                Se connecter
            </button>

        </form>


        <p class="form-link">

            Pas encore de compte ?

            <a href="inscription.php">
                Créer un compte
            </a>

        </p>

    </main>


    <footer>

        <p>
            © 2026 Notflix
        </p>

    </footer>


</body>

</html>