<?php
$ajax = 1;

require_once './MailEngine.php';
use Lib\MailEngine;

//Indépendant de l'index, donc rechargement du fichier config pour PDO requis ainsi que la session start
session_start();
include('./../config/config.php');
include('./functions.php');
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

$IdNouvelleResult = $BDD->query('SELECT IdNouvelle FROM nouvelle');
$TbIdNouvelle = array();
while ($Resultat3 = $IdNouvelleResult->fetch()) {
    $TbIdNouvelle[$Resultat3['IdNouvelle']] = $Resultat3;
}
//Pour un insert d'une nouvelle
//Vérification si l'user est admin, si l'information est à 1 (dans le main.js en cliquant sur le bouton), si la description n'est pas vide, si il y a un fichier puis envoie de la requête
if (isset($_POST['informations'])) {
    if (isset($_SESSION['User_Level']) && $_SESSION['User_Level'] > 1) {
        if (isset($_POST) && !empty($_POST)) {
            if (isset($_POST['informations']) && $_POST['informations'] == 1) {
                if (isset($_POST['description']) && !empty($_POST['description'])) {
                    if (isset($_POST["title"]) && !empty($_POST["title"])) {
                        $titre = strip_tags($_POST["title"]);
                        
                        $fichier = '';
                        if (isset($_POST['fichier']) && null !== $_POST['fichier']) {
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
                                        $titre,
                                        $_POST["description"],
                                        $fichier,
                                        $_POST["publier"]
                                    )
                        );
                        echo 'La nouvelle a bien été ajoutée';
                    } else {
                        echo 'Le titre est vide';
                    }
                } else {
                    echo 'Il n\'y a aucun contenu dans la description de la nouvelle';
                }
            }
        } else {
            echo 'La méthode post est vide ou introuvable';
        }
    } else {
        echo 'Vous n\'etes pas authorisé à appeller cette methode.';
    }
};
//Second envoie ajax via "information = 2" pour un update de la nouvelle
if (isset($_POST['informations'])) {
    if (isset($_SESSION['User_Level']) && $_SESSION['User_Level'] > 1) {
        if (isset($_POST)) {
            if (isset($_POST['informations']) && $_POST['informations'] == 2) {
                if (isset($_POST['description']) && !empty($_POST['description'])) {
                    if (isset($_POST["title"]) && !empty($_POST["title"])) {
                        $titre = strip_tags($_POST["title"]);
                        if (isset($_POST["id"]) && !empty($_POST["id"]) && array_key_exists($_POST["id"], $TbIdNouvelle)) {
                            if (isset($_POST["publier"])) {
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
                                        $titre,
                                        $_POST["description"],
                                        $fichier,
                                        $_POST["publier"],
                                        $_POST["id"]
                                    )
                                );
                                
                                echo 'La nouvelle a bien été éditée';
                            } else {
                                echo 'Problème dans la diffusion public/privé de la news';
                            }
                        } else {
                            echo 'L\'id de la nouvelle est invalide ou n\'existe pas';
                        }
                    } else {
                        echo 'Le titre est vide';
                    }
                } else {
                    echo 'Il n\'y a aucun contenu dans la description de la nouvelle';
                }
            }
        } else {
            echo 'La méthode post est vide ou introuvable';
        }
    } else {
        echo 'Vous n\'etes pas authorisé à appeller cette methode.';
    }
};

if (isset($_POST['informations'])) {
    if (isset($_SESSION['User_Level']) && $_SESSION['User_Level'] > 1) {
        if (!empty($_POST)) {
            if (isset($_POST['informations']) && $_POST['informations'] == 3) {
                if (isset($_POST['intituleactivite']) && !empty($_POST['intituleactivite'])) {
                    $intitule = strip_tags($_POST['intituleactivite']);
                    if (isset($_POST['ddebut']) && isset($_POST['dfin']) && isset($_POST['dlimite']) && !empty($_POST['ddebut']) && !empty($_POST['dfin']) && !empty($_POST['dlimite'])) {
                        if ($_POST['dfin'] > $_POST['ddebut'] && $_POST['dlimite'] < $_POST['dfin'] && $_POST['dlimite'] < $_POST['ddebut']) {
                            if (isset($_POST['description']) && !empty($_POST['description'])) {
                                $description = str_replace('<script>', ' ', $_POST['description']);
                                $description = str_replace('</script>', ' ', $description);
                                $description = str_replace('<style>', ' ', $description);
                                $description = str_replace('</style>', ' ', $description);
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
                
                                            echo 'L\'activité a bien été ajoutée et une catégorie de photo à été créée';
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
                            echo 'La date de début doit être avant la date limite et la date de fin (dans cet ordre)';
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
    }
};

if (isset($_POST['informations'])) {
    if (isset($_SESSION['User_Level']) && $_SESSION['User_Level'] > 1) {
        if (!empty($_POST)) {
            if (isset($_POST['informations']) && $_POST['informations'] == 4) {
                if (isset($_POST['intituleactivite']) && !empty($_POST['intituleactivite'])) {
                    $intitule = strip_tags($_POST['intituleactivite']);
                    if (isset($_POST['ddebut']) && isset($_POST['dfin']) && isset($_POST['dlimite']) && !empty($_POST['ddebut']) && !empty($_POST['dfin']) && !empty($_POST['dlimite'])) {
                        if (isset($_POST['description']) && !empty($_POST['description'])) {
                            $description = str_replace('<script>', ' ', $_POST['description']);
                            $description = str_replace('</script>', ' ', $description);
                            $description = str_replace('<style>', ' ', $description);
                            $description = str_replace('</style>', ' ', $description);
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
                                                  $intitule,
                                                  $_POST["ddebut"],
                                                  $_POST["dfin"],
                                                  $description,
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
    }
};

function changerpassword($data, $BDD)
{
    //
    
    $currentpassword = $data->{"password"};
    $newpassword = $data->{"newpassword"};
    $newpassword2 = $data->{"newpassword2"};
    $id = $data->{"id"};
    $uppercase = preg_match('@[A-Z]@', $newpassword);
    $lowercase = preg_match('@[a-z]@', $newpassword);
    $number    = preg_match('@[0-9]@', $newpassword);
     
    $query = 'SELECT Login, Password FROM adherent WHERE IdAdherent = ?';
    $query2 = 'UPDATE adherent SET Password = ? WHERE IdAdherent = ?';
    $reponse = $BDD->prepare($query);
    $reponse2 = $BDD->prepare($query2);
        
    $reponse->execute(array(
            $id
        ));
    while ($donnees = $reponse->fetch()) {
        $login = $donnees['Login'];
        $oldpassword = $donnees['Password'];
    }
    $currentpassword = My_Crypt($currentpassword, $login);
    if ($oldpassword == $currentpassword) {
        if ($newpassword == $newpassword2) {
            if (!$uppercase || !$lowercase || !$number || strlen($newpassword) < 8 || strlen($newpassword) > 20) {
                return array(
                        '1'=>'Le mot de passe doit contenir une majuscule, une miniscule, un chiffre et il doit être compris entre 8 et 20 caractères.',
                        '2'=>'<a href="./page-profil-'.$id.'-pass">Recommencer</a>',
                        '3'=>'Echec!'
                    );
            } else {
                $password = My_Crypt($newpassword, $login);
                $reponse2->execute(array(
                                $password,
                                $data->{"id"}
                    ));
                return array(
                        '1'=>'Le mot de passe a bien été modifié, vous allez être déconnecté automatiquement, merci de vous reconnecter avec le nouveau mot de passe.',
                        '2'=>'<a href="./index.php?deconnexion=1">Déconnexion</a>',
                        '3'=>'Bravo!',
                        '4'=>'1'
                    );
            }
        } else {
            return array(
                '1'=>'Le mot de passe entré ne correspond pas au mot de passe enregistré dans la base de données. Recommencez',
                '2'=>'<a href="javascript:history.back()">Rééssayer</a>',
                '3'=>'Bravo!',
                '4'=>'1'
            );
        }
    } else {
        return false;
    }
}

function GetMemberInfos($BDD, $IdMembre)
{
    // if ($IdMembre >= 0) {
    //     return null;
    // }

    $query = 'SELECT IdAdherent, Apropos FROM adherent where IdAdherent = :id ';
    $reponse = $BDD->prepare($query);
    $reponse->execute(array('id'=> $IdMembre));
    while ($donnees = $reponse->fetch(PDO::FETCH_ASSOC)) {
        $apropos = $donnees['Apropos'];
    }
    return array(
    "1" => $apropos,
    "2" => 'A propos de ce membre'
);
}


function renvoyermdp($data, $BDD)
{
    $email = $data->{"email"};
    $query = 'SELECT IdAdherent, Login FROM adherent WHERE Login = ? AND Email = ?';
    $reponse = $BDD->prepare($query);
        
    $reponse->execute(array(
            $data->{"login"},
            $data->{"email"}
        ));
    if ($reponse->rowCount() == 1) {
        while ($donnees = $reponse->fetch()) {
            $IdAdherent = $donnees['IdAdherent'];
            $login = $donnees['Login'];
        }
        $query3 = 'SELECT * FROM adherentrecovery WHERE IdAdherent = ?';
        $reponseexist = $BDD->prepare($query3);
        $reponseexist->execute(
            array(
                $IdAdherent
            )
        );
        if ($reponseexist->rowCount() == 1) {
            return array(
                    '1'=>'Vous avez déjà fait une demande de réinitialisation de mot de passe, verifiez vos emails. Si vous avez un problème, contactez l\'administrateur dans <a href="./page-contact">Contact</a>',
                    '2'=>'Ok',
                    '3'=>'Echec!'
                );
        }
        $query2 = 'INSERT INTO adherentrecovery (Password, IdAdherent, Ticket, Mail, Login) values (?, ?, ?, ?, ?)';
        $password = Genere_Password(20);
        $ticket = Genere_Password(40);
        $reponse2 = $BDD->prepare($query2);
        $reponse2->execute(array(
                $password,
                $IdAdherent,
                $ticket,
                $data->{"email"},
                $login
            ));
        $message = "Bonjour, votre mot de passe sur le site Moto Club Millau Passion peut être regénéré à l'adresse suivant : 
            http://cda27.s1.2isa.org/index.php?page=connexion&ticket=".$ticket." <br /><br />Merci de ne pas tenir compte de cet email si vous n'êtes pas l'auteur de la demande.";
        MailEngine::send('Regénération du mot de passe', 'vince.cda3@gmail.com', $email, 'No reply', $message);
        return array(
                '1'=>'Un email vous a été envoyé pour générer un nouveau mot de passe',
                '2'=>'Ok',
                '3'=>'Succès!'
            );
    } else {
        return array(
                '1'=>'Aucun compte ne correspond à cet identifiant et cette adresse email',
                '2'=>'Ok',
                '3'=>'Echec!'
            );
    }
}



if (isset($_POST["action"])) {
    switch ($_POST["action"]) {
        case "changerpassword":
            try {
                $result = changerpassword(json_decode($_POST["data"]), $BDD);
                $retour = array(
                    'data' => $result['1'],
                    'btn' => $result['2'],
                    'titre' => $result['3'],
                    'deco' => $result['4']
                );
                echo json_encode($retour);
            } catch (Exception $e) {
                $retour = array(
                    'success' => false,
                    'titre' => 'Echec!',
                    'btn' => 'Fermer',
                    'data' => array(
                        'error' => $e->getMessage())
                );
                echo json_encode($retour);
            }
             break;
        case "mdpoublie":
            try {
                $result = renvoyermdp(json_decode($_POST["data"]), $BDD);
                $retour = array(
                    'data' => $result['1'],
                    'btn' => $result['2'],
                    'titre' => $result['3'],
                );
                echo json_encode($retour);
            } catch (Exception $e) {
                $retour = array(
                    'success' => false,
                    'error' => $e->getMessage());
                echo json_encode($retour);
            }
            break;
        case "GetMember":
            try {
                $result = GetMemberInfos($BDD, $_POST["id"]);
                if ($result != null) {
                    $retour = array(
                        'data' => $result['1'],
                        'titre' => $result['2']
                    );
                    echo json_encode($retour);
                } else {
                    new \Exception('Not found');
                }
            } catch (Exception $e) {
                $retour = array(
                    'success' => false,
                    'error' => $e->getMessage()
                );
                echo json_encode($retour);
                http_response_code(400);
            }
            break;
    }
}
