<?php
    // Connexion à la base de données
    $pdo = new PDO('mysql:host=localhost;dbname=notefilm;charset=utf8', 'root', '');


    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $mail = $_POST['mail'];
    $mdp = $_POST['mdp'];

    // Préparation de la requête SQL
    $sql = "INSERT INTO internaute (nom_Internaute, prenom_Internaute, email_Internaute, mdp) VALUES ('$nom', '$prenom', '$mail', '$mdp')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Message de confirmation
    echo "Votre inscription a été validée !";

    // Redirection
    header('Location: ../index.php?recherche=');
?>