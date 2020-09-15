<?php
//J'inclus une seule fois le MailEngine pour mon formulaire de contact
require_once './libs/MailEngine.php';
use Lib\MailEngine;

//test de la super global $_POST si elle n'est pas vide '!empty()'
if (!empty($_POST)) {
    if (isset($_POST['formulaire'])) {
        if ($_POST['formulaire'] == 'register') {
            if ($_POST["g-recaptcha-response"]) {
                $response = $reCaptcha->verifyResponse(
                    $_SERVER["REMOTE_ADDR"],
                    $_POST["g-recaptcha-response"]
                );
            }
            if ($response != null && $response->success) {
            /* Pour voir le POST après validation du formulaire */
            //var_dump($_POST);
            //Je fais une variable contenant le résultat de ma requête SQL suivante :
            $ListeLoginSQL = $BDD->query('SELECT Login FROM adherent');
            //Je créé un tableau de login
            $TbLogin = array();
            while ($ResultatListeLoginSQL = $ListeLoginSQL->fetch()) {
                $TbLogin[$ResultatListeLoginSQL['Login']] = $ResultatListeLoginSQL;
            }
            //Si un login existe déjà dans mon tableau de login alors je lui renvoie une modal
            if (array_key_exists($_POST["Login"], $TbLogin)) {
                var_dump($ResultatListeLoginSQL);
                $MonModalTitre = 'Echec !';
                $MonModalTexte = 'Un membre utilise déjà cet identifiant, veuillez en choisir un autre';
                $MonModalBouton = '<a href="page-inscription">Rééssayer</a>';
            } else {
                //Sinon tout est correct alors je crypte le mot de passe puis insert une ligne sql
                $password = My_Crypt($_POST["Password"], $_POST["Login"]);
                //Ma ligne pour upload la photo
                list($error, $MonModalTexte, $photoName) = upload_img($directory_img_upload);
                //Ma requête
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
            DAdhesion,
            Avatar
            ) VALUES (
            "'.$_POST["Login"].'",
            "'.$password.'",
            "'.$_POST["Nom"].'",
            "'.$_POST["Prenom"].'",
            "'.$_POST["DNaiss"].'",
            "'.$_POST["Adresse1"].'",
            "'.$_POST["CdPost"].'",
            "'.$_POST["Ville"].'",
            "'.$_POST["Email"].'",
            "'.$_POST["Tel"].'",
            "'.$_POST["CC"].'",
            NOW(),
            "' . $photoName . '"
            )';

                /* Pour voir la requête correspondante */
                //echo "Query : ".$query;

                /* Execution de la requête dans la base de données */
                $BDD->query($Query);

                /* Changement du message de type modal */
                $MonModalTitre = 'Succès !';
                $MonModalTexte = 'Votre inscription a bien été prise en compte, vous serez recontacté par mail quand un organisateur aura confirmé votre inscription.';
                $MonModalBouton = '<a href="./index.php">Retour à la page d\'accueil</a>';
            }
        }else {
            //Sinon echec mdoal
            $MonModalTitre = 'Echec';
            $MonModalTexte = 'Vous n\'avez pas valider la verification reCAPTCHA';
            $MonModalBouton = 'Ok!';
    }
        }else if ($_POST['formulaire'] == 'inscriptionactivite') {
            //Si un login existe déjà dans mon tableau de login alors je lui renvoie une modal
            $ListeInscription = $BDD->query('SELECT * FROM inscription WHERE IdInscription ='.$_GET['id']);
            //Je créé un tableau de login
            $TbInscription = array();
            while ($ResultatListeInscription = $ListeInscription->fetch()) {
                $TbInscription[$ResultatListeInscription['IdAdherent']] = $ResultatListeLoginSQL;
            }
            if (array_key_exists($_SESSION['Id'], $TbInscription)) {
                $MonModalTitre = 'Erreur';
                $MonModalTexte = 'Vous êtes déjà inscrit à cette activité!';
                $MonModalBouton = '<a href="page-activite-'.$_GET['id'].'">Retourner sur l\'activité</a>';
            } else {
                $Query = 'INSERT INTO inscription(
            DInscription,
            NbInvités,
            IdAdherent,
            IdActivite
            ) VALUES (
            NOW(),
            "'.$_POST["NombreInvite"].'",
            "'.$_SESSION['Id'].'",
            "'.$_GET['id'].'"
            )';

                /* Pour voir la requête correspondante */
                //echo "Query : ".$query;

                /* Execution de la requête dans la base de données */
                $BDD->query($Query);

                /* Changement du message de type modal */
                $MonModalTitre = 'Succès !';
                $MonModalTexte = 'Votre inscription a bien été prise en compte';
                $MonModalBouton = '<a href="page-activitecontent-'.$_GET['id'].'">Retourner sur l\'activité</a>';
            }
        }
         else if ($_POST['formulaire'] == 'update_profil') {
            if ($_POST["g-recaptcha-response"]) {
                $response = $reCaptcha->verifyResponse(
                    $_SERVER["REMOTE_ADDR"],
                    $_POST["g-recaptcha-response"]
                );
            }
            if ($response != null && $response->success) {
            //Même chose que plus haut pour register sauf que c'est pour update la ligne SQL
            list($error, $MonModalTexte, $photoName) = upload_img($directory_img_upload);

            $password = My_Crypt($_POST["Password"], $_POST["Login"]);
                
            $Query = 'UPDATE adherent SET 
              Login = ?,
              Password = ?,
              Prenom = ?,
              Nom = ?,
              DNaiss = ?,
              Adresse1 = ?,
              CdPost = ?,
              Ville = ?,
              Email = ?,
              Tel = ?,
              CC = ?,
              Avatar = ?
              WHERE IdAdherent = ?';
            $image = '';
            $Query2 = 'SELECT * FROM adherent WHERE IdAdherent =' . $_GET['id'];
            $reponse = $BDD->prepare($Query);
            $reponse2 = $BDD->prepare($Query2);
            $reponse2->execute();
            while ($Donnees = $reponse2->fetch()) {
                $image = $Donnees['Avatar'];
            }
            if ($photoName == '') {
                $photoName = $image;
            }
            $result = $reponse->execute(
                array(
                                                $_POST['Login'],
                                                $password,
                                                $_POST["Prenom"],
                                                $_POST["Nom"],
                                                $_POST["DNaiss"],
                                                $_POST["Adresse1"],
                                                $_POST["CdPost"],
                                                $_POST["Ville"],
                                                $_POST["Email"],
                                                $_POST["Tel"],
                                                $_POST["CC"],
                                                $photoName,
                                                $_POST["IdAdherent"]
                                                )
            );
            //J'update mes sessions
            $_SESSION['Nom'] = $_POST["Nom"];
            $_SESSION['Prenom'] = $_POST["Prenom"];
            //information modal html
            $MonModalTitre = 'Mise à jour faite avec succès!';
            $MonModalTexte = 'Le profil a bien été mis à jour.';
            $MonModalBouton = 'Fermer';
        }else {
            //Sinon echec mdoal
            $MonModalTitre = 'Echec';
            $MonModalTexte = 'Vous n\'avez pas valider la verification reCAPTCHA';
            $MonModalBouton = 'Ok!';
    }
    } elseif ($_POST['formulaire'] == 'contact') {
            //J'indique que le sujet c'est l'objet + prénom + nom, j'indique que le message correspond à la valeur de message du formulaire et que l'expéditeur est le POST from
            $subject = $_POST['objet'] . ' de ' . $_POST['lastname'] . ' ' . $_POST['firstname'];
            $message = $_POST['message'];
            $expediteur = $_POST['from'];
            try {
                //J'essai d'envoyer le mail puis j'indique que le message est envoyé via ma modal
                
                MailEngine::send($subject, $expediteur, $message);
                //MailEngine::SendConfirmation($subject, $message);
                $MonModalTexte = 'Message envoyé.';
                $MonModalTexte = 'Le message a bien été envoyé.';
                $MonModalBouton = 'Ok!';
            } catch (Exception $e) {
                //Si ce n'est pas envoyé alors je log le message d'erreur
                error_log($e->getMessage());
            }
        } elseif ($_POST['formulaire'] == 'connexion') {
            //Si le login et le password crypté correspondent à une ligne d'adherent dans ma base de données SQL, alors, je me connecte en créant plusieurs SESSION qui seront valident jusqu'à la déconnexion
            // if submitted check response
            $reponse = '';
                if ($_POST["g-recaptcha-response"]) {
                    $response = $reCaptcha->verifyResponse(
                        $_SERVER["REMOTE_ADDR"],
                        $_POST["g-recaptcha-response"]
                    );
                }
                if ($response != null && $response->success) {
            if (isset($_POST['Login']) and isset($_POST['Password'])) {
                if (!empty($_POST['Login']) and !empty($_POST['Password'])) {
                    $password = My_Crypt($_POST["Password"], $_POST["Login"]);
                    
                    

                    $Query = 'SELECT IdAdherent,
                    Nom,
                    Prenom,
                    Organisateur,
                    Admin 
                    FROM adherent 
                    WHERE Login = ? AND Password = ?';

                    $reponse = $BDD->prepare($Query);
                    $result = $reponse->execute(array($_POST['Login'], $password));
                    
                    if ($reponse->rowCount() == 1) {
                        while ($Donnees = $reponse->fetch()) {
                            $Nom = $Donnees['Nom'];
                            $Prenom = $Donnees['Prenom'];
                            $Id = $Donnees['IdAdherent'];
                            $Organisateur = $Donnees['Organisateur'];
                            $Admin = $Donnees['Admin'];
                            //Le user level sera égal à 1 + organisateur + admin, si il est admin, il est obligatoirement organisateur. Donc Admin = 3, Organisateur = 2, Adhérent = 1, Non connecté = null
                            //Initialisation d'un cookie de ticket (unique)
                            $cookie_name = "ticket";
                            // On génère quelque chose d'aléatoire
                            $ticket = session_id().microtime().rand(0, 9999999999);
                            // on hash pour avoir quelque chose de propre qui aura toujours la même forme
                            $ticket = hash('sha512', $ticket);
                            // On enregistre des deux cotés
                            setcookie($cookie_name, $ticket, time() + (60 * 20)); // Expire au bout de 20 min
                            //On stock le ticket dans une Session (on verifiera en permanence que le ticket session et cookie est identique)
                            $_SESSION['ticket'] = $ticket;
                            $_SESSION['User_Level'] = 1 + $Organisateur + $Admin;
                            $_SESSION['Nom'] = $Nom;
                            $_SESSION['Prenom'] = $Prenom;
                            $_SESSION['Id'] = $Id;
                            //J'affiche ma modal succes
                            $MonModalTitre = 'Bravo';
                            $MonModalTexte = 'Vous êtes maintenant connecté à MCMP.';
                            $MonModalBouton = 'Ok!';
                        }
                    }
                }
                    } else {
                        //Sinon echec mdoal
                        $MonModalTitre = 'Echec';
                        $MonModalTexte = 'Votre identifiant ou votre mot de passe est invalide.';
                        $MonModalBouton = 'Ok!';
                    }
                }else {
                    //Sinon echec mdoal
                    $MonModalTitre = 'Echec';
                    $MonModalTexte = 'Vous n\'avez pas valider la verification reCAPTCHA';
                    $MonModalBouton = 'Ok!';
            }
        }
    }
};
