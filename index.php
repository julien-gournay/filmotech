<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="https://cdn-icons-png.flaticon.com/512/2503/2503508.png">
    <link rel="stylesheet" href="css/style.css">
    <title>Filmotech</title>
</head>
<body>
    <?php
        $cnt = mysqli_connect ('localhost', 'root',''); //Connexion à la BDD
        $mabase= mysqli_select_db($cnt, "notefilm"); //Selection de la BDD "notefilm"
    ?>
    <nav>
        <div class="navbar">
            <div class="name">
                <h1>Filmotech</h1>
            </div>
            <div class="compte">
                <?php
                    session_start();

                    //Verification d'un compte déja connecté
                    if(isset($_SESSION['idUser'])){
                        //Récupération des variables de session
                        $idUser = $_SESSION['idUser'];
                        $nomUser = $_SESSION['nomUser'];
                        $prenomUser = $_SESSION['prenomUser'];
                        
                        //Utilisation des variables de session
                        echo ("<p class=\"bienvenue\">Bienvenue<a href=\"monespace\"> $prenomUser $nomUser </a></p>");
                        echo("<button onclick=\"window.location.href = 'php/deconnexion.php';\">Se déconnecter</button>");
                    }
                    else{
                        echo("<button id=\"ouvrir-popup1\">Se connecter</button><button id=\"ouvrir-popup2\">Créer un compte</button>");
                    }
                ?>
            </div>
        </div>
    </nav>

    <!-- POP UP Connexion -->
    <div id="popup1">
        <div class="contenu-popup1">
            <h2>Se connecter</h2>
            <form class="connexion" action="php/connexion.php" method="POST" id="1">
                <label for="">Adresse email : <input type="text" required="required" name="mailC"></label>
                <br>
                <label for="">Mot de passe : <input type="password" required="required" name="mdpC"></label>
                <br>
                <br>
                <button type="submit">Se connecter</button>
            </form>
            <button id="fermer-popup1">Fermer</button>
        </div>
    </div>

    <!-- POP UP Inscription -->
    <div id="popup2">
        <div class="contenu-popup2">
            <form class="connexion" action="php/inscription.php" method="POST" id="2">
                <label for="">Nom : <input type="text" required="required" name="nom"></label>
                <br>
                <label for="">Prénom : <input type="text" required="required" name="prenom"></label>
                <br>
                <label for="">Adresse email : <input type="email" required="required" name="mail"></label>
                <br>
                <label for="">Mot de passe : <input type="password" required="required" name="mdp"></label>
                <br>
                <br>
                <input type="submit" value="S'inscrite">
                <input type="reset" value="Réinitialiser">
            </form>
            <button id="fermer-popup2">Fermer</button>
        </div>
    </div>
    
    <!-- Barre de recherche -->
    <section class="search">
        <div class="search-all">
            <div class="search-titre">
                <h2>Un grande base de données de film</h2>
                <?php
                    if($mabase){
                        $req2 = "SELECT COUNT(*) FROM film;";
                        $res2 = mysqli_query($cnt,$req2);
                    }
                    while ($tab = mysqli_fetch_row($res2)) {
                        $nb = $tab[0];
                        echo("<h3>Actuellement $nb dans la filmotech</h3>");
                    }
                ?>
            </div>
            <div>
                <form class="search-form" action="" method="GET">
                    <div>
                        <input type="text" name="recherche" placeholder="Rechercher un film...">
                    </div>
                    <div>
                        <button type="submit">Rechercher / Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section>
        <div id="resultats">
            <div class="grid-card">
                <?php
                $recherche = $_GET['recherche'];
                if(isset($_GET['recherche'])){  
                }

                if($mabase){
                    $req = "SELECT * FROM film WHERE film.titre_original_FILM LIKE '%$recherche%' OR film.titre_francais_FILM LIKE '%$recherche%'"; //Recherche selon le nom du film original ou en français
                    $res = mysqli_query($cnt,$req);
                }

                // Affichage des résultats
                while ($tab = mysqli_fetch_row($res)) {
                    $id = $tab[0];
                    $titre = $tab[1];
                    $annee = $tab[4];
                    $affiche = $tab[8];

                    if ($affiche =="") {
                        $affiche="null.jpg";
                    }
                    if($mabase){
                        $req3 = "SELECT AVG(note_Noter) FROM noter WHERE id_FILM_Noter=$id";
                        $res3 = mysqli_query($cnt,$req3);
    
                        while ($tab = mysqli_fetch_row($res3)) {
                            //Vérification de si une note est existante.
                            $moyenne = $tab[0];
                            if($moyenne === null){
                                $moyenneA = "Aucune note";
                            }
                            else{
                                $moyenne = round($moyenne, 1);
                                $moyenneA = "$moyenne/5";
                            }
                        }
                    }

                    echo("<div class=\"card\" style=\"background-image: url($affiche);\"><a class=\"redirection\" href='./infofilm?id=\"$id\"'><p>$titre • $annee<br><br><br><br>$moyenneA</p></a></div>");
                    // Sortir de la boucle
                }
                ?>
                <?php
                // Moyenne des notes 
                if($mabase){
                    $req = "SELECT AVG(note_Noter) FROM noter WHERE id_FILM_Noter=$id";
                    $res = mysqli_query($cnt,$req);

                    while ($tab = mysqli_fetch_row($res)) {
                        $moyenne = $tab[0];

                    }
                }
                ?>
            </div>
        </div>
    </section>

    <script src="popup.js"></script>
</body>
</html>