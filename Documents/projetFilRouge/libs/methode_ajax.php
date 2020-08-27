<?php
session_start();
include ('./../config/config.php');

if(isset($_SESSION['User_Level']) && $_SESSION['User_Level'] > 2){
    if(!empty($_POST)) {

        if (isset($_POST['informations']) && $_POST['informations'] == 1) {

            if(isset($_POST['description']) && !empty($_POST['description'])){

                if(isset($_POST['fichier'])) {
                    $fichier = $_POST['fichier'];
                }else {
                    $fichier = ' ';
                }
            $Query = 'INSERT INTO nouvelle(
                Titre,
                Texte,
                Fichier,
                DPubli
                ) VALUES (
                "'.$_POST["title"].'",            
                "'.$_POST["description"].'",
                "'.$_POST["fichier"].'",
                NOW()            
            )';
            $BDD->query($Query);
            echo 'La nouvelle a bien été ajoutée';
            
                }
            }
        }
    }

                if(isset($_SESSION['User_Level']) && $_SESSION['User_Level'] > 2){
                    if(!empty($_POST)) {
                        if(isset($_POST['informations']) && $_POST['informations'] == 2) {
                            if(isset($_POST['description']) && !empty($_POST['description'])){
                                if(isset($_POST['fichier'])) {
                                    $fichier = $_POST['fichier'];
                                        }else {
                                            $fichier = ' ';
                                        }
                                        $Query = 'UPDATE nouvelle 
                                        SET Titre = "'.$_POST["title"].'",
                                            Texte = "'.$_POST["description"].'",
                                            Fichier = "'.$_POST["fichier"].'",
                                            DPubli = NOW()
                                            WHERE IdNouvelle = '.$_POST["id"];
                                
                                        $BDD->query($Query);
                                        echo 'La nouvelle a bien été éditée';
                
                                        }
            }
        }
}else{

    echo 'Vous n\'etes pas authorisé à appeller cette methode.';

};



