<?php
    $cnt = mysqli_connect ('localhost', 'root','');
    $mabase= mysqli_select_db($cnt, "notefilm");

    if($mabase){
        $req = "SELECT * FROM film";
        $res = mysqli_query($cnt,$req);
    }
    // Itérer sur les résultats
    while ($tab = mysqli_fetch_row($res)) {
        $id = $tab[0];
        $titre = $tab[1];
        $affiche = $tab[8];

        echo("<div class=\"card\" style=\"background-image: url($affiche);\"><p>$titre</p></div>");
        // Sortir de la boucle
    }
?>