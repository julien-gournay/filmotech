<?php
session_start();

// Récupération des données du formulaire
$id = $_POST['id'];
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$mdp = $_POST['mdp'];

// Connexion à la base de données
$bdd = new PDO('mysql:host=localhost;dbname=notefilm;charset=utf8', 'root', '');

// Requête pour modifier les informations de l'utilisateur
$sql = "UPDATE internaute SET nom_Internaute = '$nom', prenom_Internaute = '$prenom', email_Internaute = '$email', mdp = '$mdp' WHERE id_Internaute = $id";
$stmt = $bdd->prepare($sql);
$stmt->execute();

// Redirection vers la page profil
header('Location: ../monespace');
?>
