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
                $TbCC = array(
                    '250 cm3' => '250',
                    '125 cm3' => '125',
                    '> 250 cm3' => '>250',
                    'aucune' => 'aucune'
                );

                $date = $_POST['DNaiss'];
                $date_explosee = explode("-", $date);
                $jour = $date_explosee[2];
                $mois = $date_explosee[1];
                $annee = $date_explosee[0];
                $uppercase = preg_match('@[A-Z]@', $_POST['Password']);
                $lowercase = preg_match('@[a-z]@', $_POST['Password']);
                $number    = preg_match('@[0-9]@', $_POST['Password']);
                //Si un login existe déjà dans mon tableau de login alors je lui renvoie une modal
                if (array_key_exists($_POST["Login"], $TbLogin)) {
                    var_dump($ResultatListeLoginSQL);
                    $MonModalTitre = 'Echec !';
                    $MonModalTexte = 'Un membre utilise déjà cet identifiant, veuillez en choisir un autre';
                    $MonModalBouton = '<a href="page-inscription">Rééssayer</a>';
                } elseif (!isset($_POST['Email']) || empty($_POST['Email']) || !preg_match('#^([\w\.-]+)@([\w\.-]+)(\.[a-z]{2,4})$#', trim($_POST['Email']))) {
                    $MonModalTitre = 'Echec !';
                    $MonModalTexte = 'Votre adresse email est incorrect';
                    $MonModalBouton = '<a href="page-inscription">Rééssayer</a>';
                } elseif (!isset($_POST['Login']) || empty($_POST['Login']) || !ctype_alnum($_POST['Login']) && strlen($_POST['Login']) <= 30) {
                    $MonModalTitre = 'Echec !';
                    $MonModalTexte = 'Votre login ne doit pas contenir de caractères spéciaux et doit avoir une longueur maximale de 30 caractères';
                    $MonModalBouton = '<a href="page-inscription">Rééssayer</a>';
                } elseif (!isset($_POST['Prenom']) || empty($_POST['Prenom']) || empty($_POST['Nom']) || !preg_match('`^[[:alpha:] \'-]{2,30}$`u', $_POST['Prenom']) || !preg_match('`^[[:alpha:] \'-]{2,30}$`u', $_POST['Nom'])) {
                    $MonModalTitre = 'Echec !';
                    $MonModalTexte = 'Votre nom ou votre prénom ne doit pas avoir de caractères spéciaux et doit être de moins de 30 caractères';
                    $MonModalBouton = '<a href="page-inscription">Rééssayer</a>';
                } elseif (!isset($_POST['CdPost']) || empty($_POST['CdPost']) || !preg_match('#^[0-9]{5}$#', $_POST['CdPost'])) {
                    $MonModalTitre = 'Echec !';
                    $MonModalTexte = 'Votre code postale n\'est pas valide';
                    $MonModalBouton = '<a href="page-inscription">Rééssayer</a>';
                } elseif (!isset($_POST['Adresse1']) || empty($_POST['Adresse1']) || !preg_match('`^[[:alnum:][:space:] \'-]{10,50}$`u', $_POST['Adresse1'])) {
                    $MonModalTitre = 'Echec !';
                    $MonModalTexte = 'Votre adresse n\'est pas valide';
                    $MonModalBouton = '<a href="page-inscription">Rééssayer</a>';
                } elseif (!isset($_POST['Ville']) || empty($_POST['Ville']) || !preg_match('`^[[:alpha:][:space:] \'-]{2,20}$`u', $_POST['Ville'])) {
                    $MonModalTitre = 'Echec !';
                    $MonModalTexte = 'Votre nom de ville n\'est pas valide';
                    $MonModalBouton = '<a href="page-inscription">Rééssayer</a>';
                } elseif (!isset($_POST['Password']) || empty($_POST['Password']) || !$uppercase || !$lowercase || !$number || strlen($_POST['Password']) < 8 || strlen($_POST['Password']) > 20) {
                    $MonModalTitre = 'Echec !';
                    $MonModalTexte = 'Votre mot de passe doit avoir au moins un caractère majuscule, un minuscule, un chiffre, un caractère spécial et doit être compris entre 8 et 20 caractères.';
                    $MonModalBouton = '<a href="page-inscription">Rééssayer</a>';
                } elseif (!isset($_POST['DNaiss']) || empty($_POST['DNaiss']) || !checkdate($jour, $mois, $annee)) {
                    $MonModalTitre = 'Echec !';
                    $MonModalTexte = 'Votre date de naissance n\'est pas valide!';
                    $MonModalBouton = '<a href="page-inscription">Rééssayer</a>';
                } elseif (!isset($_POST['CC']) || empty($_POST['CC']) || !array_key_exists($_POST['CC'], $TbCC)) {
                    $MonModalTitre = 'Echec !';
                    $MonModalTexte = 'Vous n\'avez pas sélectionné de cylindrée';
                    $MonModalBouton = '<a href="page-inscription">Rééssayer</a>';
                } elseif (!isset($_POST['Tel']) || empty($_POST['Tel']) || !preg_match('`[0-9]{10,13}`', $_POST['Tel'])) {
                    $MonModalTitre = 'Echec !';
                    $MonModalTexte = 'Le numéro que vous avez entré n\'est pas valide (0033 pour +33 accepté)';
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
            ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)';
            
                    $reponse = $BDD->prepare($Query);
                    /* Execution de la requête dans la base de données */
                    $reponse->execute(
                        array(
                    $_POST["Login"],
                    $password,
                    $_POST["Nom"],
                    $_POST["Prenom"],
                    $_POST["DNaiss"],
                    $_POST["Adresse1"],
                    $_POST["CdPost"],
                    $_POST["Ville"],
                    $_POST["Email"],
                    $_POST["Tel"],
                    $_POST["CC"],
                    $photoName

                )
                    );
                    /* Changement du message de type modal */
                    $MonModalTitre = 'Succès !';
                    $MonModalTexte = 'Votre inscription a bien été prise en compte, vous serez recontacté par mail quand un organisateur aura confirmé votre inscription.';
                    $MonModalBouton = '<a href="./index.php">Retour à la page d\'accueil</a>';
                }
            } else {
                //Sinon echec mdoal
                $MonModalTitre = 'Echec';
                $MonModalTexte = 'Vous n\'avez pas valider la verification reCAPTCHA';
                $MonModalBouton = 'Ok!';
            }
        } elseif ($_POST['formulaire'] == 'inscriptionactivite') {
            //Si un login existe déjà dans mon tableau de login alors je lui renvoie une modal
            $ListeInscription = $BDD->query('SELECT * FROM inscription WHERE IdActivite ='.$_GET['id'].' AND IdAdherent = '.$_SESSION['Id']);
            //Je créé un tableau de login
            $TbInscription = array();
            while ($ResultatListeInscription = $ListeInscription->fetch()) {
                $TbInscription[$ResultatListeInscription['IdAdherent']] = $ResultatListeInscription;
            }
            if (array_key_exists($_SESSION['Id'], $TbInscription)) {
                $MonModalTitre = 'Erreur';
                $MonModalTexte = 'Vous êtes déjà inscrit à cette activité!';
                $MonModalBouton = '<a href="page-activitecontent-'.$_GET['id'].'">Retourner sur l\'activité</a>';
            } else {
                //Initialisation de la requête
                $Query = 'INSERT INTO inscription(
            DInscription,
            NbInvités,
            IdAdherent,
            IdActivite
            ) VALUES ( NOW(), ?, ?, ?)'
            ;
                //Préparation de la requête
                $reponse = $BDD->prepare($Query);

                /* Execution de la requête dans la base de données */
                $reponse->execute(
                    array(
                    $_POST["NombreInvite"],
                    $_SESSION['Id'],
                    $_GET['id']
                )
                );

                /* Changement du message de type modal */
                $MonModalTitre = 'Succès !';
                $MonModalTexte = 'Votre inscription a bien été prise en compte';
                $MonModalBouton = '<a href="page-activitecontent-'.$_GET['id'].'">Retourner sur l\'activité</a>';
            }
        } elseif ($_POST['formulaire'] == 'update_profil') {
            if ($_POST["g-recaptcha-response"]) {
                $response = $reCaptcha->verifyResponse(
                    $_SERVER["REMOTE_ADDR"],
                    $_POST["g-recaptcha-response"]
                );
            }
            if ($response != null && $response->success) {
                $TbLogin = array();
                $ListeLoginSQL = $BDD->query('SELECT Login FROM adherent');

                while ($ResultatListeLoginSQL = $ListeLoginSQL->fetch()) {
                    $TbLogin[$ResultatListeLoginSQL['Login']] = $ResultatListeLoginSQL;
                }
                $TbCC = array(
                    '250 cm3' => '250',
                    '125 cm3' => '125',
                    '> 250 cm3' => '>250',
                    'aucune' => 'aucune'
                );

                $date = $_POST['DNaiss'];
                $date_explosee = explode("-", $date);
                $jour = $date_explosee[2];
                $mois = $date_explosee[1];
                $annee = $date_explosee[0];
                $uppercase = preg_match('@[A-Z]@', $_POST['Password']);
                $lowercase = preg_match('@[a-z]@', $_POST['Password']);
                $number    = preg_match('@[0-9]@', $_POST['Password']);
                //Si un login existe déjà dans mon tableau de login alors je lui renvoie une modal
                // if (array_key_exists($_POST["Login"], $TbLogin)) {
                //   var_dump($ResultatListeLoginSQL);
                // $MonModalTitre = 'Echec !';
                //$MonModalTexte = 'Un membre utilise déjà cet identifiant, veuillez en choisir un autre';
                //$MonModalBouton = '<a href="page-inscription">Rééssayer</a>';
                if (!isset($_POST['Email']) || empty($_POST['Email']) || !preg_match('#^([\w\.-]+)@([\w\.-]+)(\.[a-z]{2,4})$#', trim($_POST['Email']))) {
                    $MonModalTitre = 'Echec !';
                    $MonModalTexte = 'Votre adresse email est incorrect';
                    $MonModalBouton = '<a href="page-inscription">Rééssayer</a>';
                } elseif (!isset($_POST['Login']) || empty($_POST['Login']) || !ctype_alnum($_POST['Login']) && strlen($_POST['Login']) <= 30) {
                    $MonModalTitre = 'Echec !';
                    $MonModalTexte = 'Votre login ne doit pas contenir de caractères spéciaux et doit avoir une longueur maximale de 30 caractères';
                    $MonModalBouton = '<a href="page-inscription">Rééssayer</a>';
                } elseif (!isset($_POST['Prenom']) || empty($_POST['Prenom']) || empty($_POST['Nom']) || !preg_match('`^[[:alpha:] \'-]{2,30}$`u', $_POST['Prenom']) || !preg_match('`^[[:alpha:] \'-]{2,30}$`u', $_POST['Nom'])) {
                    $MonModalTitre = 'Echec !';
                    $MonModalTexte = 'Votre nom ou votre prénom ne doit pas avoir de caractères spéciaux et doit être de moins de 30 caractères';
                    $MonModalBouton = '<a href="page-inscription">Rééssayer</a>';
                } elseif (!isset($_POST['CdPost']) || empty($_POST['CdPost']) || !preg_match('#^[0-9]{5}$#', $_POST['CdPost'])) {
                    $MonModalTitre = 'Echec !';
                    $MonModalTexte = 'Votre code postale n\'est pas valide';
                    $MonModalBouton = '<a href="page-inscription">Rééssayer</a>';
                } elseif (!isset($_POST['Adresse1']) || empty($_POST['Adresse1']) || !preg_match('`^[[:alnum:][:space:] \'-]{10,50}$`u', $_POST['Adresse1'])) {
                    $MonModalTitre = 'Echec !';
                    $MonModalTexte = 'Votre adresse n\'est pas valide';
                    $MonModalBouton = '<a href="page-inscription">Rééssayer</a>';
                } elseif (!isset($_POST['Ville']) || empty($_POST['Ville']) || !preg_match('`^[[:alpha:][:space:] \'-]{2,20}$`u', $_POST['Ville'])) {
                    $MonModalTitre = 'Echec !';
                    $MonModalTexte = 'Votre nom de ville n\'est pas valide';
                    $MonModalBouton = '<a href="page-inscription">Rééssayer</a>';
                } elseif (!isset($_POST['Password']) || empty($_POST['Password']) || !$uppercase || !$lowercase || !$number || strlen($_POST['Password']) < 8 || strlen($_POST['Password']) > 20) {
                    $MonModalTitre = 'Echec !';
                    $MonModalTexte = 'Votre mot de passe doit avoir au moins un caractère majuscule, un minuscule, un chiffre, un caractère spécial et doit être compris entre 8 et 20 caractères.';
                    $MonModalBouton = '<a href="page-inscription">Rééssayer</a>';
                } elseif (!isset($_POST['DNaiss']) || empty($_POST['DNaiss']) || !checkdate($jour, $mois, $annee)) {
                    $MonModalTitre = 'Echec !';
                    $MonModalTexte = 'Votre date de naissance n\'est pas valide!';
                    $MonModalBouton = '<a href="page-inscription">Rééssayer</a>';
                } elseif (!isset($_POST['CC']) || empty($_POST['CC']) || !array_key_exists($_POST['CC'], $TbCC)) {
                    $MonModalTitre = 'Echec !';
                    $MonModalTexte = 'Vous n\'avez pas sélectionné de cylindrée';
                    $MonModalBouton = '<a href="page-inscription">Rééssayer</a>';
                } elseif (!isset($_POST['Tel']) || empty($_POST['Tel']) || !preg_match('`[0-9]{10,13}`', $_POST['Tel'])) {
                    $MonModalTitre = 'Echec !';
                    $MonModalTexte = 'Le numéro que vous avez entré n\'est pas valide (0033 pour +33 accepté)';
                    $MonModalBouton = '<a href="page-inscription">Rééssayer</a>';
                } else {
                    //Même chose que plus haut pour register sauf que c'est pour update la ligne SQL
                    list($error, $MonModalTexte, $photoName) = upload_img($directory_img_upload);

                    $password = My_Crypt($_POST["Password"], $_POST["Login"]);
                
                    $Query = 'UPDATE adherent SET 
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
                }
            } else {
                //Sinon echec mdoal
                $MonModalTitre = 'Echec';
                $MonModalTexte = 'Vous n\'avez pas valider la verification reCAPTCHA';
                $MonModalBouton = 'Ok!';
            }
        } elseif ($_POST['formulaire'] == 'contact') {
            //J'indique que le sujet c'est l'objet + prénom + nom, j'indique que le message correspond à la valeur de message du formulaire et que l'expéditeur est le POST from
            $subject = $_POST['objet'] . ' de ' . $_POST['lastname'] . ' ' . $_POST['firstname'];
            $nom =  $_POST['lastname'] . ' ' . $_POST['firstname'];
            $message = $_POST['message'];
            $expediteur = $_POST['from'];
            try {
                //J'essai d'envoyer le mail puis j'indique que le message est envoyé via ma modal
                
                MailEngine::send($subject, $expediteur, $nom, $message);
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
            } else {
                //Sinon echec mdoal
                $MonModalTitre = 'Echec';
                $MonModalTexte = 'Vous n\'avez pas valider la verification reCAPTCHA';
                $MonModalBouton = 'Ok!';
            }
        }
    }
};
