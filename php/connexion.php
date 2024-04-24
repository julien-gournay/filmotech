<?php
    // Démarrage de la session
    session_start();

    // Connexion à la base de données
    $bdd = new PDO('mysql:host=localhost;dbname=notefilm;charset=utf8', 'root', '');

    // Récupération des valeurs du formulaire
    $mail = $_POST['mailC'];
    $mdp = $_POST['mdpC'];

    // Hachage du mot de passe pour comparaison
    //$mdpHash = password_hash($mdpC, PASSWORD_DEFAULT);

    // Requête SQL pour vérifier l'utilisateur
    $sql = "SELECT * FROM internaute WHERE email_Internaute = :email AND mdp = :mdp";
    $stmt = $bdd->prepare($sql);
    $stmt->execute([':email' => $mail, ':mdp' => $mdp]);

    // Si l'utilisateur est trouvé
    if ($user = $stmt->fetch()) {
        $idUser = $user['id_Internaute'];
        $nomUser = $user['nom_Internaute'];
        $prenomUser = $user['prenom_Internaute'];

        // Stockage des variables dans la session
        $_SESSION['idUser'] = $idUser;
        $_SESSION['nomUser'] = $nomUser;
        $_SESSION['prenomUser'] = $prenomUser;
    // Redirection vers la page d'accueil
    header('Location: ../index.php?recherche=');
    echo "Identifiants corrects.<br>";

    // Affichage de l'ID, nom et prénom
    echo ("Bienvenue $nomUser $prenomUser");

    } else {
    // Erreur de connexion
    echo "Identifiants incorrects.";
    }
?>
