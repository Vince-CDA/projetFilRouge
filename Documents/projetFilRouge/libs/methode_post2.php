<?php
require_once './libs/MailEngine.php';
use Lib\MailEngine;
//test de la super global $_POST si elle n'est pas vide '!empty()'
if(!empty($_POST)){

    if (isset($_POST['formulaire'])){

        if($_POST['formulaire'] == 'register'){
            //Je fais une variable contenant le résultat de ma requête SQL suivante :
            $ListeLoginSQL = $BDD->query ('SELECT Login FROM adherent');
            //Je créé un tableau de login
            $TbLogin = array();
            while ($ResultatListeLoginSQL = $ListeLoginSQL->fetch()) {
                $TbLogin[$ResultatListeLoginSQL['Login']] = $ResultatListeLoginSQL;
            }
            //Savoir si le login n'est pas un duplicata...
            if (array_key_exists($_POST["Login"], $TbLogin)){
                var_dump($ResultatListeLoginSQL);
                $MonModalTitre = 'Echec !';
                $MonModalTexte = 'Un membre utilise déjà cet identifiant, veuillez en choisir un autre';
                $MonModalBouton = '<a href="./index.php?page=inscription">Rééssayer</a>';
            }
            else {
            $Query = 'INSERT INTO adherent(
            Login,
            Password,
            Nom,
            Prenom,
            DNaiss,
            Adresse1,
            CdPost,
            Ville,
            Email,
            Tel,
            CC,
            DAdhesion
            ) VALUES (
            "'.$_POST["Login"].'",
            "'.$_POST["Password"].'",
            "'.$_POST["Nom"].'",
            "'.$_POST["Prenom"].'",
            "'.$_POST["DNaiss"].'",
            "'.$_POST["Adresse1"].'",
            "'.$_POST["CdPost"].'",
            "'.$_POST["Ville"].'",
            "'.$_POST["Email"].'",
            "'.$_POST["Tel"].'",
            "'.$_POST["CC"].'",
            NOW()
            )';

            /* Pour voir la requête correspondante */
            //echo "Query : ".$query;

            /* Execution de la requête dans la base de données */
            $BDD->query($Query);

            /* Changement du message de type modal */
            $MonModalTitre = 'Succès !';
            $MonModalTexte = 'Votre inscription a bien été prise en compte, vous serez recontacté par mail quand un organisateur aura confirmé votre inscription.';
            $MonModalBouton = '<a href="./index.php">Retour à la page d\'accueil</a>';

            }}
            else if ($_POST['formulaire'] == 'contact'){

                $subject = $_POST['objet'] . ' de ' . $_POST['lastname'] . ' ' . $_POST['firstname'];
                $message = $_POST['message'];
                $expediteur = $_POST['from'];
                try {
                    MailEngine::send($subject, $expediteur, $message);
                    //MailEngine::SendConfirmation($subject, $message);

                }catch(Exception $e) {
                    error_log($e->getMessage());
                }

            }
        }else if($_POST['formulaire'] == 'update_profil'){

            $Query = 'UPDATE adherent SET 
              Login = "'.$_POST["Login"].'",
              Password = "'.$_POST["Password"].'",
              Prenom = "'.$_POST["Prenom"].'",
              Nom = "'.$_POST["Nom"].'",
              DNaiss = "'.$_POST["DNaiss"].'",
              Adresse1 = "'.$_POST["Adresse1"].'",
              CdPost = "'.$_POST["CdPost"].'",
              Ville = "'.$_POST["Ville"].'",
              Email = "'.$_POST["Email"].'",
              Tel = "'.$_POST["Tel"].'",
              CC = "'.$_POST["CC"].'"
              WHERE IdAdherent = '.$_POST["IdAdherent"];


            $BDD->query($Query);
            //information modal html
            $MonModalTitre = 'Mise à jour faite avec succès!';
            $MonModalTexte = 'Le profil a bien été mis à jour.';
            $MonModalBouton = 'Fermer';
        }else if($_POST['formulaire'] == 'connexion'){

            if(isset($_POST['Login']) AND isset($_POST['Password'])){
                if (!empty($_POST['Login']) AND !empty($_POST['Password'])) {

                    $Query = 'SELECT IdAdherent,
                                     Nom,
                                     Prenom,
                                     Organisateur,
                                     Admin 
                                     FROM adherent 
                                     WHERE Login ="'.$_POST['Login'].'" AND Password ="'.$_POST['Password'].'"';
                    $Reponse = $BDD->query($Query);

                    if ($Reponse->rowCount() == 1) {
                        while ($Donnees = $Reponse->fetch()) {
                            $Nom = $Donnees['Nom'];
                            $Prenom = $Donnees['Prenom'];
                            $Id = $Donnees['IdAdherent'];
                            $Organisateur = $Donnees['Organisateur'];
                            $Admin = $Donnees['Admin'];
                            $_SESSION['User_Level'] = 1 + $Organisateur + $Admin;
                            $_SESSION['Nom'] = $Nom;
                            $_SESSION['Prenom'] = $Prenom;
                            $_SESSION['Id'] = $Id;
                            $MonModalTitre = 'Bravo';
                            $MonModalTexte = 'Vous êtes maintenant connecté à MCMP.';
                            $MonModalBouton = 'Ok !';
                        } }else{
                            $MonModalTitre = 'Echec';
                            $MonModalTexte = 'Votre identifiant ou votre mot de passe est invalide.';
                            $MonModalBouton = 'Ok !';
                        }

                    }


                }
            }

        };
