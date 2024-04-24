<?php
session_start();

// Récupération de l'ID utilisateur
$id = $_GET['idUser'];

// Connexion à la base de données
$bdd = new PDO('mysql:host=localhost;dbname=notefilm;charset=utf8', 'root', '');

// Requête pour supprimer l'utilisateur
$sql = "DELETE FROM noter WHERE id_Internaute_Noter = $id";
$stmt = $bdd->prepare($sql);
$stmt->execute();

$sql2 = "DELETE FROM internaute WHERE id_Internaute = $id";
$stmt2 = $bdd->prepare($sql2);
$stmt2->execute();

// Déconnexion de l'utilisateur
session_destroy();

// Redirection vers la page d'accueil
header('Location: ../index.php?recherche=');
?>
