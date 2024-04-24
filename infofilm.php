<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/infofilm.css">
    <title>Information film</title>
</head>
<body>
    <?php
        // On récupère l'id du film
        session_start();

        if(isset($_SESSION['idUser'])){
            //Récupération des variables de session
            $idUser = $_SESSION['idUser'];
            $nomUser = $_SESSION['nomUser'];
            $prenomUser = $_SESSION['prenomUser'];
        }

        //Connexion à la BDD
        $cnt = mysqli_connect ('localhost', 'root','');
        $mabase= mysqli_select_db($cnt, "notefilm");
        if(isset($_GET["id"])){
            $id = $_GET["id"];
        }
        // Si on reçoit la note pour la première fois
        if(isset($_POST["note"])){
            $note = $_POST["note"];
            $idUser = $_SESSION['idUser'];
            if($mabase){
                $req = "INSERT INTO noter VALUES($id,$idUser,$note);";
                $res = mysqli_query($cnt,$req);
            }
        }
        // Si on reçoit une modification de note
        if(isset($_POST["modifNote"])){
            $note = $_POST["modifNote"];
            $idUser = $_SESSION['idUser'];
            if($mabase){
                $req = "UPDATE noter SET note_noter = $note WHERE id_Internaute_Noter = $idUser";
                $res = mysqli_query($cnt,$req);
            }
        }
        // On vérifie si l'utilisateur a déjà noter le film
        if($mabase){
            if(isset($idUser)){
                $req = "SELECT note_Noter FROM noter WHERE id_FILM_Noter=$id AND id_Internaute_Noter=$idUser;";
                $res = mysqli_query($cnt,$req);
            }
            else{
                $req = "SELECT note_Noter FROM noter WHERE id_FILM_Noter=$id";
                $res = mysqli_query($cnt,$req);
            }
        }
        while ($tab = mysqli_fetch_row($res)) {
            if($tab[0] !== null){
                $note = $tab[0];
            }
        }
    ?>
    <nav>
        <div class="navbar">
            <div class="name">
                <h1>Filmotech</h1>
            </div>
            <div class="compte">
                <?php
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
                <input type="submit" value="S'inscrire">
                <input type="reset" value="Réinitialiser">
            </form>
            <button id="fermer-popup2">Fermer</button>
        </div>
    </div>

    <!-- POP UP Modification de la note -->
    <div id="popupnote">
        <div class="contenu-note">
            <form action="" method='POST' style='text-align:center;'>
                <label for='note'>Note: </label>
                <input type='number' name='modifNote' id='note' min='0' max='5' step='0.5' required='required'>
                <input type='submit' value='Je confirme ma note'>
            </form>
        <button id="fermernote">Fermer</button>
        </div>
    </div>


    <section class="sectiondetail">
        <div class="detail">
            <div class="infoimg">
                <?php
                if($mabase){
                    $req = "SELECT * FROM film WHERE film.id_FILM=$id";
                    $res = mysqli_query($cnt,$req);
                }

                // Affichage des résultats
                while ($tab = mysqli_fetch_row($res)) {
                    $id = $tab[0];
                    $titreO = $tab[1];
                    $titreF = $tab[2];
                    $real = $tab[3];
                    $annee = $tab[4];
                    $pays = $tab[5];
                    $duree = $tab[6];
                    $acteurs = $tab[7];
                    $affiche = $tab[8];

                    if ($affiche =="") {
                        $affiche="null.jpg";
                    }

                    echo("<img class=\"affiche\" src=\"$affiche\">");
                }
                ?>
            </div>
            <div class="infotext">
                <?php
                    echo("<h2>$titreO</h2>");
                    echo("<p>$annee • $duree</p><br>");
                    echo("<p><u>Réalisateur :</u> $real</p><br>");
                    echo("<p><u>Acteurs :</u> $acteurs</p>");
                ?>
            </div>
        </div>
    </section>
    <section class="sectionnote">
        <div class="note">
            <div id="moyennenote">
                <?php
                // Moyenne des notes 
                if($mabase){
                    $req = "SELECT AVG(note_Noter),COUNT(note_Noter) FROM noter WHERE id_FILM_Noter=$id";
                    $res = mysqli_query($cnt,$req);

                    while ($tab = mysqli_fetch_row($res)) {
                        $moyenne = $tab[0];
                        $nbNote = $tab[1];
                        if($moyenne === null){
                            echo("<p>Moyenne des notes : Il n'y a pas encore de notes pour ce film");
                        }
                        else{
                            $moyenne = round($moyenne, 1);
                            echo("<p>Moyenne des notes : $moyenne/5 ($nbNote internautes)</p>");
                        }
                    }
                }
                ?>
            </div>
            
            <div id="noter">
                <p>Noter ce film<p>
                <?php
                
                if(isset($idUser)){
                    // Cas où l'utilisateur a déjà noté le film
                    if(isset($note)){
                        echo("<br><p>Vous avez noté le film $note/5</p><br><button id=\"ouvrirNote\">Modifier votre note</button>");
                    // Cas où l'utilisateur n'a pas encore noté le film
                    }
                    else{
                        echo("<br><form action='infofilm.php?id=\"$id\"' method='POST' style='text-align:center;'><label for='note'>Note sur 5: </label><input type='number' name='note' id='note' min='0' max='5' step='0.5' required='required'><br><br><button type='submit'>Je confirme ma note</button></form>");
                    }
                // Cas où l'utilisateur n'est pas connecté 
                }
                else{
                    echo("<br><p>! Veuillez vous connecter ou créer un compte pour noter ce film !</p>");
                }
                ?>
            </div>
        </div>
    
    </section>
    
    <script src="popup.js"></script>
    <script src="formulaire.js"></script>
</body>
</html>