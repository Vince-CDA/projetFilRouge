<?php
//Indépendant de l'index, donc rechargement du fichier config pour PDO requis ainsi que la session start
session_start();
include('./../config/config.php');
$ListeLoginSQL = $BDD->query('SELECT * FROM adherent');
//Je créé un tableau de login
$TbIdAdherent = array();
while ($Resultat = $ListeLoginSQL->fetch()) {
    $TbIdAdherent[$Resultat['IdAdherent']] = $Resultat;
}

$ListeId = $BDD->query('SELECT IdType FROM type_activite');
$TbType = array();
while ($Resultat2 = $ListeId->fetch()) {
    $TbType[$Resultat2['IdType']] = $Resultat2;
}
//Pour un insert d'une nouvelle
//Vérification si l'user est admin, si l'information est à 1 (dans le main.js en cliquant sur le bouton), si la description n'est pas vide, si il y a un fichier puis envoie de la requête
if (isset($_SESSION['User_Level']) && $_SESSION['User_Level'] > 1) {
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
                ) VALUES ( ?, ?, ?, ?, NOW() )'
                ;
                $response = $BDD->prepare($Query);
                $result = $response->execute(
                                    array(
                                        $_POST["title"],
                                        $_POST["description"],
                                        $fichier,
                                        $_POST["publier"]
                                    )
                                );
                echo 'La nouvelle a bien été ajoutée';
            }
        }
    }
}
//Second envoie ajax via "information = 2" pour un update de la nouvelle
                if (isset($_SESSION['User_Level']) && $_SESSION['User_Level'] > 1) {
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


if (isset($_SESSION['User_Level']) && $_SESSION['User_Level'] > 1) {
    if (!empty($_POST)) {
        if (isset($_POST['informations']) && $_POST['informations'] == 3) {
            if (isset($_POST['intituleactivite']) && !empty($_POST['intituleactivite'])) {
                $intitule = strip_tags($_POST['intituleactivite']);
                if (isset($_POST['ddebut']) && isset($_POST['dfin']) && isset($_POST['dlimite']) && !empty($_POST['ddebut']) && !empty($_POST['dfin']) && !empty($_POST['dlimite'])) {
                    if (isset($_POST['description']) && !empty($_POST['description'])) {
                        $description = strip_tags($_POST['description']);
                        if (isset($_POST['tarifadherent']) && !empty($_POST['tarifadherent']) && isset($_POST['tarifinvite']) && !empty($_POST['tarifinvite'])) {
                            if (isset($_POST['idadherent']) && !empty($_POST['idadherent'] && array_key_exists($_POST['idadherent'], $TbIdAdherent))) {
                                if (isset($_POST['idtype']) && !empty($_POST['idtype']) && array_key_exists($_POST['idtype'], $TbType)) {
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
                                                  $intitule,
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
                                } else {
                                    echo 'Erreur dans l\'id du type d\'activité';
                                }
                            } else {
                                echo 'Erreur dans l\'id adhérent';
                            }
                        } else {
                            echo 'Erreur dans les tarifs';
                        }
                    } else {
                        echo 'Erreur dans la description de l\'activité';
                    }
                } else {
                    echo 'Erreur dans les dates';
                }
            } else {
                echo 'Erreur dans l\'intitulé de l\'activité';
            }
        } 
    } else {
        echo 'Pas de formulaire';
    }
} else {
    echo 'Vous n\'êtes pas administrateur';
};


if (isset($_SESSION['User_Level']) && $_SESSION['User_Level'] > 1) {
    if (!empty($_POST)) {
        if (isset($_POST['informations']) && $_POST['informations'] == 4) {
            if (isset($_POST['intituleactivite']) && !empty($_POST['intituleactivite'])) {
                $intitule = strip_tags($_POST['informations']);
                if (isset($_POST['ddebut']) && isset($_POST['dfin']) && isset($_POST['dlimite']) && !empty($_POST['ddebut']) && !empty($_POST['dfin']) && !empty($_POST['dlimite'])) {
                    if (isset($_POST['description']) && !empty($_POST['description'])) {
                        $description = strip_tags($_POST['description']);
                        if (isset($_POST['tarifadherent']) && !empty($_POST['tarifadherent']) && isset($_POST['tarifinvite']) && !empty($_POST['tarifinvite'])) {
                            if (isset($_POST['idadherent']) && !empty($_POST['idadherent'] && array_key_exists($_POST['idadherent'], $TbIdAdherent))) {
                                if (isset($_POST['idtype']) && !empty($_POST['idtype']) && array_key_exists($_POST['idtype'], $TbType)) {
                                    if (isset($_POST['fichier']) && !empty($_POST['fichier'])) {
                                        $fichier = $_POST['fichier'];
                                    } else {
                                        $fichier = ' ';
                                    }
                                    $Query = 'UPDATE activite SET
                                            IntituleActivite = ?,
                                            DDebut = ?,
                                            DFin = ?,
                                            Description = ?,
                                            TarifAdherent = ?,
                                            TarifInvite = ?,
                                            DLimite = ?,
                                            IdAdherent = ?,
                                            IdType = ?,
                                            Fichier = ?,
                                            Publier = ?
                                            WHERE IdActivite = ?';
              
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
                                                  $_POST["publier"],
                                                  $_POST['id']
                                                     )
                                                );
                                    echo 'L\'activité a bien été mise à jour';
                                } else {
                                    echo 'Erreur dans l\'id du type d\'activité';
                                }
                            } else {
                                echo 'Erreur dans l\'id adhérent';
                            }
                        } else {
                            echo 'Erreur dans les tarifs';
                        }
                    } else {
                        echo 'Erreur dans la description de l\'activité';
                    }
                } else {
                    echo 'Erreur dans les dates';
                }
            } else {
                echo 'Erreur dans l\'intitulé de l\'activité';
            }
        } 
    } else {
        echo 'Pas de formulaire';
    }
} else {
    echo 'Vous n\'êtes pas administrateur';
};