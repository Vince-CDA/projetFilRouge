<?php
//Indépendant de l'index, donc rechargement du fichier config pour PDO requis ainsi que la session start
session_start();
include('./../config/config.php');
//Pour un insert d'une nouvelle
//Vérification si l'user est admin, si l'information est à 1 (dans le main.js en cliquant sur le bouton), si la description n'est pas vide, si il y a un fichier puis envoie de la requête
if (isset($_SESSION['User_Level']) && $_SESSION['User_Level'] > 2) {
    if (!empty($_POST)) {
        if (isset($_POST['informations']) && $_POST['informations'] == 1) {
            if (isset($_POST['description']) && !empty($_POST['description'])) {
                if (isset($_POST['fichier'])) {
                    $fichier = $_POST['fichier'];
                } else {
                    $fichier = ' ';
                }
                $Query = 'INSERT INTO nouvelle(
                Titre,
                Texte,
                Fichier,
                Diffusion,
                DPubli
                ) VALUES (
                "'.$_POST["title"].'",            
                "'.$_POST["description"].'",
                "'.$fichier.'",
                "'.$_POST["publier"].'",
                NOW()            
            )';
                $BDD->query($Query);
                echo 'La nouvelle a bien été ajoutée';
            }
        }
    }
}
//Second envoie ajax via "information = 2" pour un update de la nouvelle
                if (isset($_SESSION['User_Level']) && $_SESSION['User_Level'] > 2) {
                    if (!empty($_POST)) {
                        if (isset($_POST['informations']) && $_POST['informations'] == 2) {
                            if (isset($_POST['description']) && !empty($_POST['description'])) {
                                $fichier = '';
                                if (isset($_POST['fichier']) && null !== $_POST['fichier']) {
                                    $fichier = $_POST['fichier'];
                                } else {
                                    $fichier = ' ';
                                }
                                $query = 'UPDATE nouvelle SET 
                                Titre = ?,
                                Texte = ?,
                                Fichier = ?,
                                Diffusion = ?,
                                DPubli = NOW()
                                WHERE IdNouvelle = ?';

                                $response = $BDD->prepare($query);
                                $result = $response->execute(
                                    array(
                                        $_POST["title"], 
                                        $_POST["description"],
                                        $fichier,
                                        $_POST["publier"],
                                        $_POST["id"]
                                    )
                                );
                                
                                echo 'La nouvelle a bien été éditée';
                            }
                        }
                    }
                } else {
                    echo 'Vous n\'etes pas authorisé à appeller cette methode.';
                };


if (isset($_SESSION['User_Level']) && $_SESSION['User_Level'] > 2) {
    if (!empty($_POST)) {
        if (isset($_POST['informations']) && $_POST['informations'] == 3) {
            if (isset($_POST['description']) && !empty($_POST['description'])) {
                if (isset($_POST['fichier']) && !empty($_POST['fichier'])) {
                    $fichier = $_POST['fichier'];
                } else {
                    $fichier = ' ';
                }
                $Query = 'INSERT INTO activite (
                IntituleActivite,
                DDebut,
                DFin,
                Description,
                TarifAdherent,
                TarifInvite,
                DLimite,
                IdAdherent,
                IdType,
                Fichier,
                Publier) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
              
                $reponse = $BDD->prepare($Query);
                $reponse->execute(
                    array(
                                                  $_POST['intituleactivite'],
                                                  $_POST["ddebut"],
                                                  $_POST["dfin"],
                                                  $_POST["description"],
                                                  $_POST["tarifadherent"],
                                                  $_POST["tarifinvite"],
                                                  $_POST["dlimite"],
                                                  $_POST["idadherent"],
                                                  $_POST["idtype"],
                                                  $fichier,
                                                  $_POST["publier"]
              )
                );
                echo 'L\'activité a bien été ajoutée';

            }
        }
    }
};
