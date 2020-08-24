<?php
session_start();
include ('./../config/config.php');

if(isset($_SESSION['User_Level']) && $_SESSION['User_Level'] > 2){
    if(!empty($_POST)) {

        if (isset($_POST['informations']) && $_POST['informations'] == 1) {

            if(isset($_POST['description']) && !empty($_POST['description'])){

            $Query = 'INSERT INTO nouvelle(
                Titre,
                Texte,
                DPubli
                ) VALUES (
                "'.$_POST["title"].'",            
                "'.$_POST["description"].'",
                NOW()            
            )';

            $BDD->query($Query);

                echo 'Ajout d\'une nouvelle.';

            }

        }

    }

}else{

    echo 'Vous n\'etes pas authorisé à appeller cette methode.';

}