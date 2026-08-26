<?php

require_once "config/database.php";

$message = "";


/* Vérifier si le formulaire a été envoyé */

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nom = trim($_POST["nom"]);
    $prenom = trim($_POST["prenom"]);
    $email = trim($_POST["email"]);
    $motDePasse = $_POST["mot_de_passe"];


    /* Vérifier les champs */

    if (
        empty($nom) ||
        empty($prenom) ||
        empty($email) ||
        empty($motDePasse)
    ) {

        $message = "Tous les champs sont obligatoires.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = "L'adresse email n'est pas valide.";

    } elseif (strlen($motDePasse) < 6) {

        $message = "Le mot de passe doit contenir au moins 6 caractères.";

    } else {

        /* Vérifier si l'email existe déjà */

        $sql = "SELECT IdUtilisateur
                FROM Utilisateur
                WHERE Email = ?";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([$email]);

        $utilisateurExiste = $stmt->fetch();


        if ($utilisateurExiste) {

            $message = "Cette adresse email est déjà utilisée.";

        } else {

            /* Sécuriser le mot de passe */

            $motDePasseHash = password_hash(
                $motDePasse,
                PASSWORD_DEFAULT
            );


            /* Ajouter l'utilisateur */

            $sql = "INSERT INTO Utilisateur
                    (Nom, Prenom, Email, MotDePasse)
                    VALUES (?, ?, ?, ?)";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                $nom,
                $prenom,
                $email,
                $motDePasseHash
            ]);


            $message = "Compte créé avec succès !";
        }
    }
}

?>

<!DOCTYPE html>

<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Inscription - Netflix Maison</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>


    <!-- Navigation -->

    <header class="navbar">

        <div class="logo">
            NOTFLIX
        </div>

        <nav>

            <a href="index.php">Accueil</a>

            <a href="films.php">Films</a>

            <a href="series.php">Séries</a>

            <a href="connexion.php">Connexion</a>

        </nav>

    </header>


    <!-- Formulaire -->

    <main class="form-container">

        <h1>Créer un compte</h1>


        <?php if ($message !== ""): ?>

            <p class="message">
                <?= htmlspecialchars($message) ?>
            </p>

        <?php endif; ?>


        <form method="POST" action="inscription.php">


            <label for="nom">
                Nom
            </label>

            <input
                type="text"
                id="nom"
                name="nom"
                required
            >


            <label for="prenom">
                Prénom
            </label>

            <input
                type="text"
                id="prenom"
                name="prenom"
                required
            >


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
                minlength="6"
                required
            >


            <button type="submit">
                Créer mon compte
            </button>

        </form>


        <p class="form-link">

            Déjà inscrit ?

            <a href="connexion.php">
                Se connecter
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