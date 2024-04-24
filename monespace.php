<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="https://cdn-icons-png.flaticon.com/512/2503/2503508.png">
    <link rel="stylesheet" href="css/monespace.css">
    <title>Filmotech - Mon compte</title>
</head>
<body>
    <?php
        //Connexion à la BDD
        $cnt = mysqli_connect ('localhost', 'root','');
        $mabase= mysqli_select_db($cnt, "notefilm");
    ?>
    <nav>
        <div class="navbar">
            <div class="name">
                <h1><a href="index.php?recherche=">Filmotech</a></h1>
            </div>
            <div class="compte">
                <?php
                    session_start();
                    //Verification que le user est bien connecté
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
                        header('Location: index.php?recherche=');
                    }
                ?>
            </div>
        </div>
    </nav>
    
    <section class="banniere">
        <div class="info">
            <h2>Espace membre</h2><br>
            <p>Ici, vous pouvez modifier les informations de votre compte et accéder aux films que vous avez noté.</p>
        </div>
    </section>

    <section class="infocompte">
        <div class="info">        
            <?php
                if($mabase){
                    $req = "SELECT * FROM internaute WHERE id_Internaute = $idUser";
                    $res = mysqli_query($cnt,$req);
                }
                while ($tab = mysqli_fetch_row($res)) {
                    $id = $tab[0];
                    $nom = $tab[1];
                    $prenom = $tab[2];
                    $email = $tab[3];
                    $mdp = $tab[4];
                }
            ?>

            <?php 
                echo("<h2>Profil de $prenom $nom (ID: $id)</h2>") 
            ?>

            <!-- Formulaire des modifications des informations -->
            <form action="php/modifier.php" method="post">
                <label for="nom">Nom : </label>
                <input type="text" name="nom" id="nom" value="<?php echo("$nom") ?>">
                <br>
                <label for="prenom">Prénom : </label>
                <input type="text" name="prenom" id="prenom" value="<?php echo("$prenom") ?>">
                <br>
                <label for="email">Email : </label>
                <input type="mail" name="email" id="email" value="<?php echo("$email") ?>">
                <br>
                <label for="mdp">Mot de passe : </label>
                <input type="text" name="mdp" id="mdp" value="<?php echo("$mdp") ?>">
                <br>
                <div class="boutonModif">
                    <button type="submit">Modifier</button>
                </div>
            </form>
            <div class="boutonSuppr">
                <button id="ouvrir-popup3">Supprimer le compte</button>
            </div>
        </div>
    </section>

    <!-- POP UP Suppression compte -->
    <div id="popup3">
        <div class="contenu-popup3">
            <h2>J'accepte de supprimer mon compte</h2>
            <div class="bouton">
                <button id="fermer-popup3">Non, je ferme</button>
                <button><a href="php/supprimer.php?idUser=<?php echo("$id") ?>">Oui, je le supprime</a></button>
            </div>
        </div>
    </div>

    <section class="sectionnote">
        <div class="note">
            <h2>Les notes de vos films</h2>
            <?php
            $cnt = mysqli_connect ('localhost', 'root','');
            $mabase= mysqli_select_db($cnt, "notefilm");
            if($mabase){
                $req = "SELECT film.image_FILM, noter.note_NOTER, film.id_FILM FROM noter INNER JOIN film ON noter.id_FILM_Noter = film.id_FILM WHERE noter.id_Internaute_Noter = $id;";
                $res = mysqli_query($cnt,$req);
            }
            while ($tab = mysqli_fetch_row($res)) {
                $image = $tab[0];
                $note = $tab[1];
                $idFIlm = $tab[2];
                echo("<div class=\"card\" style=\"background-image: url($image);\"><a class=\"redirection\" href='./infofilm?id=\"$idFIlm\"'></a><p style='text-align:center;'>$note/5</p></div>");
            }
            if(empty($idFIlm)){
                echo("<br><p>Vous n'avez noté aucun film.</p>");
            }
            ?>
        </div>
    </section>
    <script src="popup3.js"></script>
</body>
</html>