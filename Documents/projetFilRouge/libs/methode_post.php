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
                if (isset($_POST['apropos']) && !empty($_POST['apropos'])) {
                    $apropos = strip_tags($_POST['apropos']);
                } else {
                    $apropos = '';
                }
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
                    $MonModalBouton = '<a href="javascript:history.back()">Rééssayer</a>';
                } elseif (!isset($_POST['Email']) || empty($_POST['Email']) || !preg_match('#^([\w\.-]+)@([\w\.-]+)(\.[a-z]{2,4})$#', trim($_POST['Email']))) {
                    $MonModalTitre = 'Echec !';
                    $MonModalTexte = 'Votre adresse email est incorrect';
                    $MonModalBouton = '<a href="javascript:history.back()">Rééssayer</a>';
                } elseif (!isset($_POST['Login']) || empty($_POST['Login']) || !ctype_alnum($_POST['Login']) && strlen($_POST['Login']) <= 30) {
                    $MonModalTitre = 'Echec !';
                    $MonModalTexte = 'Votre login ne doit pas contenir de caractères spéciaux et doit avoir une longueur maximale de 30 caractères';
                    $MonModalBouton = '<a href="javascript:history.back()">Rééssayer</a>';
                } elseif (!isset($_POST['Prenom']) || empty($_POST['Prenom']) || empty($_POST['Nom']) || !preg_match('`^[[:alpha:] \'-]{2,30}$`u', $_POST['Prenom']) || !preg_match('`^[[:alpha:] \'-]{2,30}$`u', $_POST['Nom'])) {
                    $MonModalTitre = 'Echec !';
                    $MonModalTexte = 'Votre nom ou votre prénom ne doit pas avoir de caractères spéciaux et doit être de moins de 30 caractères';
                    $MonModalBouton = '<a href="javascript:history.back()">Rééssayer</a>';
                } elseif (!isset($_POST['CdPost']) || empty($_POST['CdPost']) || !preg_match('#^[0-9]{5}$#', $_POST['CdPost'])) {
                    $MonModalTitre = 'Echec !';
                    $MonModalTexte = 'Votre code postale n\'est pas valide';
                    $MonModalBouton = '<a href="javascript:history.back()">Rééssayer</a>';
                } elseif (!isset($_POST['Adresse1']) || empty($_POST['Adresse1']) || !preg_match('`^[[:alnum:][:space:] \'-]{10,50}$`u', $_POST['Adresse1'])) {
                    $MonModalTitre = 'Echec !';
                    $MonModalTexte = 'Votre adresse n\'est pas valide';
                    $MonModalBouton = '<a href="javascript:history.back()">Rééssayer</a>';
                } elseif (!isset($_POST['Ville']) || empty($_POST['Ville']) || !preg_match('`^[[:alpha:][:space:] \'-]{2,20}$`u', $_POST['Ville'])) {
                    $MonModalTitre = 'Echec !';
                    $MonModalTexte = 'Votre nom de ville n\'est pas valide';
                    $MonModalBouton = '<a href="javascript:history.back()">Rééssayer</a>';
                } elseif (!isset($_POST['Password']) || empty($_POST['Password']) || !$uppercase || !$lowercase || !$number || strlen($_POST['Password']) < 8 || strlen($_POST['Password']) > 20) {
                    $MonModalTitre = 'Echec !';
                    $MonModalTexte = 'Votre mot de passe doit avoir au moins un caractère majuscule, un minuscule, un chiffre, un caractère spécial et doit être compris entre 8 et 20 caractères.';
                    $MonModalBouton = '<a href="javascript:history.back()">Rééssayer</a>';
                } elseif (!isset($_POST['DNaiss']) || empty($_POST['DNaiss']) || !checkdate($jour, $mois, $annee)) {
                    $MonModalTitre = 'Echec !';
                    $MonModalTexte = 'Votre date de naissance n\'est pas valide!';
                    $MonModalBouton = '<a href="javascript:history.back()">Rééssayer</a>';
                } elseif (!isset($_POST['CC']) || empty($_POST['CC']) || !array_key_exists($_POST['CC'], $TbCC)) {
                    $MonModalTitre = 'Echec !';
                    $MonModalTexte = 'Vous n\'avez pas sélectionné de cylindrée';
                    $MonModalBouton = '<a href="javascript:history.back()">Rééssayer</a>';
                } elseif (!isset($_POST['Tel']) || empty($_POST['Tel']) || !preg_match('#^0[0-9]([ .-]?[0-9]{2}){4}$#', $_POST['Tel'])) {
                    $MonModalTitre = 'Echec !';
                    $MonModalTexte = 'Le numéro que vous avez entré n\'est pas valide';
                    $MonModalBouton = '<a href="javascript:history.back()">Rééssayer</a>';
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
            Avatar,
            Apropos
            ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?)';
            
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
                    $photoName,
                    $apropos

                )
                    );
                    /* Changement du message de type modal */
                    $MonModalTitre = 'Succès !';
                    $MonModalTexte = 'Votre inscription a bien été prise en compte, vous serez recontacté par mail quand un organisateur aura confirmé votre inscription.';
                    $MonModalBouton = '<a href="./index.php">Retour à la page d\'accueil</a>';
                    MailEngine::send('Le membre '.$_POST["Prenom"].' '.$_POST["Nom"].' vient de s\'inscrire sur MCMP', $_POST["Email"], $_POST['Login'], 'Vous avez un nouvel inscrit sur votre site MCMP, direction http://cda27.s1.2isa.org/page-liste pour activer le nouveau membre et n\'oubliez pas de répondre à cet email quand ce membre sera activé!');
                }
            } else {
                //Sinon echec mdoal
                $MonModalTitre = 'Echec';
                $MonModalTexte = 'Vous n\'avez pas valider la verification reCAPTCHA';
                $MonModalBouton = '<a href="javascript:history.back()">Rééssayer</a>';
            }
        } elseif ($_POST['formulaire'] == 'inscriptionactivite' && isset($_SESSION['User_Level']) && $_SESSION['User_Level'] > 0) {
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
        } elseif ($_POST['formulaire'] == 'updateprofil' && isset($_SESSION['User_Level'])) {
            if ($_SESSION['User_Level'] > 0 && $_GET['id'] == $_SESSION['Id'] || $_SESSION['User_Level'] > 1) {
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
                    //Si un login existe déjà dans mon tableau de login alors je lui renvoie une modal
                    // if (array_key_exists($_POST["Login"], $TbLogin)) {
                    //   var_dump($ResultatListeLoginSQL);
                    // $MonModalTitre = 'Echec !';
                    //$MonModalTexte = 'Un membre utilise déjà cet identifiant, veuillez en choisir un autre';
                    //$MonModalBouton = '<a href="page-inscription">Rééssayer</a>';
                    if (!isset($_POST['Email']) || empty($_POST['Email']) || !preg_match('#^([\w\.-]+)@([\w\.-]+)(\.[a-z]{2,4})$#', trim($_POST['Email']))) {
                        $MonModalTitre = 'Echec !';
                        $MonModalTexte = 'Votre adresse email est incorrect';
                        $MonModalBouton = '<a href="javascript:history.back()">Rééssayer</a>';
                    } elseif (!isset($_POST['Prenom']) || empty($_POST['Prenom']) || empty($_POST['Nom']) || !preg_match('`^[[:alpha:] \'-]{2,30}$`u', $_POST['Prenom']) || !preg_match('`^[[:alpha:] \'-]{2,30}$`u', $_POST['Nom'])) {
                        $MonModalTitre = 'Echec !';
                        $MonModalTexte = 'Votre nom ou votre prénom ne doit pas avoir de caractères spéciaux et doit être de moins de 30 caractères';
                        $MonModalBouton = '<a href="javascript:history.back()">Rééssayer</a>';
                    } elseif (!isset($_POST['CdPost']) || empty($_POST['CdPost']) || !preg_match('#^[0-9]{5}$#', $_POST['CdPost'])) {
                        $MonModalTitre = 'Echec !';
                        $MonModalTexte = 'Votre code postale n\'est pas valide';
                        $MonModalBouton = '<a href="javascript:history.back()">Rééssayer</a>';
                    } elseif (!isset($_POST['Adresse1']) || empty($_POST['Adresse1']) || !preg_match('`^[[:alnum:][:space:] \'-]{10,50}$`u', $_POST['Adresse1'])) {
                        $MonModalTitre = 'Echec !';
                        $MonModalTexte = 'Votre adresse n\'est pas valide';
                        $MonModalBouton = '<a href="javascript:history.back()">Rééssayer</a>';
                    } elseif (!isset($_POST['Ville']) || empty($_POST['Ville']) || !preg_match('`^[[:alpha:][:space:] \'-]{2,20}$`u', $_POST['Ville'])) {
                        $MonModalTitre = 'Echec !';
                        $MonModalTexte = 'Votre nom de ville n\'est pas valide';
                        $MonModalBouton = '<a href="javascript:history.back()">Rééssayer</a>';
                    } elseif (!isset($_POST['DNaiss']) || empty($_POST['DNaiss']) || !checkdate($jour, $mois, $annee)) {
                        $MonModalTitre = 'Echec !';
                        $MonModalTexte = 'Votre date de naissance n\'est pas valide!';
                        $MonModalBouton = '<a href="javascript:history.back()">Rééssayer</a>';
                    } elseif (!isset($_POST['CC']) || empty($_POST['CC']) || !array_key_exists($_POST['CC'], $TbCC)) {
                        $MonModalTitre = 'Echec !';
                        $MonModalTexte = 'Vous n\'avez pas sélectionné de cylindrée';
                        $MonModalBouton = '<a href="javascript:history.back()">Rééssayer</a>';
                    } elseif (!isset($_POST['Tel']) || empty($_POST['Tel']) || !preg_match('`[0-9]{10,13}`', $_POST['Tel'])) {
                        $MonModalTitre = 'Echec !';
                        $MonModalTexte = 'Le numéro que vous avez entré n\'est pas valide (0033 pour +33 accepté)';
                        $MonModalBouton = '<a href="javascript:history.back()">Rééssayer</a>';
                    } else {
                        if ($_SESSION['User_Level'] > 1 && isset($_POST['Organisateur']) && $_POST['Organisateur'] == 1) {
                            $Organisateur = 1;
                        } else {
                            $Organisateur = 0;
                        }
                        if ($_SESSION['User_Level'] > 1 && isset($_POST['Active']) && $_POST['Active'] == 1) {
                            $Active = 1;
                        } else {
                            $Active = 0;
                        }
                        if ($_SESSION['User_Level'] > 1 && isset($_POST['Admin']) && $_POST['Admin'] == 1) {
                            $Admin = 1;
                        } else {
                            $Admin = 0;
                        }
                        if (isset($_POST['apropos']) && !empty($_POST['apropos'])) {
                            $apropos = strip_tags($_POST['apropos']);
                        } else {
                            $apropos = '';
                        }
                        //Même chose que plus haut pour register sauf que c'est pour update la ligne SQL
                        list($error, $MonModalTexte, $photoName) = upload_img($directory_img_upload);
                    
                
                        $Query = 'UPDATE adherent SET 
              Prenom = ?,
              Nom = ?,
              DNaiss = ?,
              Adresse1 = ?,
              CdPost = ?,
              Ville = ?,
              Email = ?,
              Tel = ?,
              CC = ?,
              Avatar = ?,
              Organisateur = ?,
              Active = ?,
              Admin = ?,
              Apropos = ?
              WHERE IdAdherent = ?';
                        $image = '';
                        $Query2 = 'SELECT * FROM adherent WHERE IdAdherent = ?';
                        $reponse = $BDD->prepare($Query);
                        $reponse2 = $BDD->prepare($Query2);
                        $reponse2->execute(array(
                        $_GET['id']
                    ));
                        while ($Donnees = $reponse2->fetch()) {
                            $image = $Donnees['Avatar'];
                            $login = $Donnees['Login'];
                        }
                        if ($photoName == '') {
                            $photoName = $image;
                        }
                        $result = $reponse->execute(
                            array(
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
                                                $Organisateur,
                                                $Active,
                                                $Admin,
                                                $apropos,
                                                $_POST["IdAdherent"]
                                                )
                        );
                        //J'update mes sessions
                        if ($_SESSION['Id'] == $_GET['id']) {
                            $_SESSION['Nom'] = $_POST["Nom"];
                            $_SESSION['Prenom'] = $_POST["Prenom"];
                            $_SESSION['User_Level'] = 1 + $Organisateur + $Admin;
                        }
                        //information modal html
                        $MonModalTitre = 'Mise à jour faite avec succès!';
                        $MonModalTexte = 'Le profil a bien été mis à jour.';
                        $MonModalBouton = 'Fermer';
                    }
                } else {
                    //Sinon echec mdoal
                    $MonModalTitre = 'Echec';
                    $MonModalTexte = 'Vous n\'avez pas valider la verification reCAPTCHA';
                    $MonModalBouton = '<a href="javascript:history.back()">Rééssayer</a>';
                }
            } else {
                $MonModalTitre = 'Echec !';
                $MonModalTexte = 'Vous n\'êtes pas autorisé à faire cela';
                $MonModalBouton = '<a href="javascript:history.back()">Revenir en arrière</a>';
            }
        } elseif ($_POST['formulaire'] == 'uploadfichier' && isset($_SESSION['User_Level']) && $_SESSION['User_Level'] > 0) {
            list($error, $MonModalTexte, $fichiername) = upload_file($directory_img_fichier);
            $query = 'INSERT INTO fichiers (Intitule, Fichier) values (?, ?)';
            $result=$BDD->prepare($query);
            $return = $result->execute(array(
                    $_POST['intitule'],
                    $fichiername
            ));
        } elseif ($_POST['formulaire'] == 'contact') {
            if ($_POST["g-recaptcha-response"]) {
                $response = $reCaptcha->verifyResponse(
                    $_SERVER["REMOTE_ADDR"],
                    $_POST["g-recaptcha-response"]
                );
            }
            if ($response != null && $response->success) {
                if (!isset($_POST['from']) || empty($_POST['from']) || !preg_match('#^([\w\.-]+)@([\w\.-]+)(\.[a-z]{2,4})$#', trim($_POST['from']))) {
                    $MonModalTitre = 'Echec !';
                    $MonModalTexte = 'Votre adresse email est incorrect';
                    $MonModalBouton = '<a href="javascript:history.back()">Rééssayer</a>';
                } elseif (!isset($_POST['lastname']) || empty($_POST['lastname']) || !isset($_POST['firstname']) && empty($_POST['firstname'])) {
                    $MonModalTitre = 'Echec !';
                    $MonModalTexte = 'Les champs nom et prénom doivent être complétés';
                    $MonModalBouton = '<a href="javascript:history.back()">Rééssayer</a>';
                } elseif (!preg_match('`^[[:alpha:] \'-]{2,30}$`u', $_POST['firstname']) || !preg_match('`^[[:alpha:] \'-]{2,30}$`u', $_POST['lastname'])) {
                    $MonModalTitre = 'Echec !';
                    $MonModalTexte = 'Les champs nom et prénom ne doivent pas contenir de caractères spéciaux';
                    $MonModalBouton = '<a href="javascript:history.back()">Rééssayer</a>';
                } elseif (!isset($_POST['objet']) || empty($_POST['objet'])) {
                    $MonModalTitre = 'Echec !';
                    $MonModalTexte = 'Votre objet de message n\'est pas complété';
                    $MonModalBouton = '<a href="javascript:history.back()">Rééssayer</a>';
                } elseif (!preg_match('`^[[:alnum:][:space:] !?\'-]{5,200}$`u', $_POST['objet'])) {
                    $MonModalTitre = 'Echec !';
                    $MonModalTexte = 'L\'objet du mail est invalide, vérifiez qu\'il ne possède pas des caractères spéciaux (5 caractères mini/200 caractères maxi)';
                    $MonModalBouton = '<a href="javascript:history.back()">Rééssayer</a>';
                } elseif (!isset($_POST['message']) || empty($_POST['message'])) {
                    $MonModalTitre = 'Echec !';
                    $MonModalTexte = 'Votre message est vide';
                    $MonModalBouton = '<a href="javascript:history.back()">Rééssayer</a>';
                } elseif (strlen($_POST['message'] > 10000)) {
                    $MonModalTitre = 'Echec !';
                    $MonModalTexte = 'Votre message est trop long, il excède les 10000 caractères';
                    $MonModalBouton = '<a href="javascript:history.back()">Rééssayer</a>';
                } else {
                    $messagestrip = strip_tags($_POST['message']);
                    //J'indique que le sujet c'est l'objet + prénom + nom, j'indique que le message correspond à la valeur de message du formulaire et que l'expéditeur est le POST from
                    $subject = $_POST['objet'] . ' de ' . $_POST['lastname'] . ' ' . $_POST['firstname'];
                    $nom =  $_POST['lastname'] . ' ' . $_POST['firstname'];
                    $message = $messagestrip;
                    $expediteur = $_POST['from'];
                    try {
                        //J'essai d'envoyer le mail puis j'indique que le message est envoyé via ma modal
                
                        MailEngine::send($subject, $expediteur, 'v.mundoegea@gmail.com', $nom, $message);
                        //MailEngine::SendConfirmation($subject, $message);
                        $MonModalTexte = 'Message envoyé.';
                        $MonModalTexte = 'Le message a bien été envoyé.';
                        $MonModalBouton = 'Ok!';
                    } catch (Exception $e) {
                        //Si ce n'est pas envoyé alors je log le message d'erreur
                        error_log($e->getMessage());
                    }
                }
            } else {
                $MonModalTitre = 'Echec !';
                $MonModalTexte = 'Vous n\'avez pas complété la vérification reCAPTCHA';
                $MonModalBouton = '<a href="javascript:history.back()">Rééssayer</a>';
            }
        } elseif ($_POST['formulaire'] == 'motdepasse') {
            $Query2 = 'SELECT Password FROM adherent WHERE IdAdherent = ?';
            $reponse2 = $BDD->prepare($Query2);
            $reponse2->execute(
                array(
                                        $_GET['id']
                        )
            );
            while ($Donnees = $reponse2->fetch()) {
                $testpassword == $Donnees['Password'] ? $msg = true : $msg = false;
            }
            $Query = 'UPDATE adherent SET 
                    Password = ?
                    WHERE IdAdherent = ?';
            $reponse2 = $BDD->prepare($Query2);
            $reponse2->execute();
            while ($Donnees = $reponse2->fetch()) {
                $image = $Donnees['Avatar'];
                $login = $Donnees['Login'];
            }
            if ($photoName == '') {
                $photoName = $image;
            }
            $reponse = $BDD->prepare($Query);
            $result = $reponse->execute(
                array(
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
                                                $Organisateur,
                                                $Active,
                                                $Admin,
                                                $_POST["IdAdherent"]
                                                )
            );
        } elseif ($_POST['formulaire'] == 'connexion') {
            //Si le login et le password crypté correspondent à une ligne d'adherent dans ma base de données SQL, alors, je me connecte en créant plusieurs SESSION qui seront valident jusqu'à la déconnexion
            // if submitted check response
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
                    Admin,
                    Active
                    FROM adherent 
                    WHERE Login = ? AND Password = ?';

                        $reponse = $BDD->prepare($Query);
                        $result = $reponse->execute(array($_POST['Login'], $password));
                    
                        if ($reponse->rowCount() == 1) {
                            while ($Donnees = $reponse->fetch()) {
                                $Active = $Donnees['Active'];
                                if ($Active != 1) {
                                    $MonModalTitre = 'Compte désactivé';
                                    $MonModalTexte = 'Votre compte n\'est pas encore activé, vous devez patienter pour qu\'un organisateur valide votre compte.</p>
                                    <p>En attendant vous pouvez aller voir les <a href="./page-nouvelles">nouvelles publiées pour tous</a></p>
                                    <p>Vous pouvez consulter notre page parlant de notre <a href="./page-historique">histoire</a></p>
                                    <p>Vous pouvez aussi consulter nos <a href="./page-partenaire">partenariats</a></p>
                                    <p>La <a href="./page-galerie">galerie</a> est consultable, avec catégories de photo créés par nos membres et notre staff</p>
                                    <p>N\'hésitez pas à nous <a href="page-contact">contacter</a> si vous avez une idée, un problème ou tout autre chose à nous soumettre!</p>
                                    <p>Vous pouvez aussi consulter notre <a href="https://www.facebook.com/motomillau12100/" target="_blank">Facebook</a>';
                                    $MonModalBouton = '<a href="./page-accueil">Revenir à l\'accueil</a>';
                                } else {
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
                        } else {
                            //Sinon echec mdoal
                            $MonModalTitre = 'Echec';
                            $MonModalTexte = 'Votre identifiant ou votre mot de passe est invalide.';
                            $MonModalBouton = '<a href="javascript:history.back()">Rééssayer</a>';
                        }
                    } else {
                        //Sinon echec mdoal
                        $MonModalTitre = 'Echec';
                        $MonModalTexte = 'Le champ de l\'identifiant ou du mot de passe est vide.';
                        $MonModalBouton = '<a href="javascript:history.back()">Rééssayer</a>';
                    }
                } else {
                    //Sinon echec mdoal
                    $MonModalTitre = 'Echec';
                    $MonModalTexte = 'Votre identifiant ou votre mot de passe est vide.';
                    $MonModalBouton = '<a href="javascript:history.back()">Rééssayer</a>';
                }
            } else {
                //Sinon echec mdoal
                $MonModalTitre = 'Echec';
                $MonModalTexte = 'Vous n\'avez pas valider la verification reCAPTCHA';
                $MonModalBouton = '<a href="javascript:history.back()">Rééssayer</a>';
            }
        } elseif ($_POST['formulaire'] == 'ajouttype') {
            if (isset($_POST['intitule']) && !empty($_POST['intitule'])) {
                $intitule = strip_tags($_POST['intitule']);
                $longueur = strlen($intitule);
                if ($longueur < 30) {
                    $Query2 = 'SELECT IntituleType FROM type_activite WHERE IntituleType = ?';
                    $reponse2 = $BDD->prepare($Query2);
                    $reponse2->execute(array(
                                        $intitule
                    ));
                    if ($reponse2->rowCount() == 1) {
                        $MonModalTitre = 'Echec';
                        $MonModalTexte = 'Le nom du type de l\'activité existe déjà dans la base de données';
                        $MonModalBouton = '<a href="javascript:history.back()">Rééssayer</a>';
                    } else {
                        $Query = 'INSERT INTO type_activite (IntituleType) values ( ? )';
                        $reponse = $BDD->prepare($Query);
                        $reponse->execute(array(
                                $intitule
                                ));
                                
                        $intitule = str_replace(' ', '', $intitule);
                        $intitule = substr($intitule, 0, 250);
                        $intitule = preg_replace('/[^A-Za-z0-9\s.\s-]/', '', $intitule);
                        $intitule = preg_replace('/\d+/u', '', $intitule);
                        mkdir('../gallery/'.$intitule.'', 0777);
                        $MonModalTitre = 'Succès';
                        $MonModalTexte = 'Le type d\'activité a bien été ajouté ansi qu\'une catégorie dans galerie';
                        $MonModalBouton = '<a href="./page-ajoutactivite">Aller ajouter une activité</a>';
                    }
                } else {
                    $MonModalTitre = 'Echec';
                    $MonModalTexte = 'Le nom du type de l\'activité est trop long';
                    $MonModalBouton = '<a href="javascript:history.back()">Rééssayer</a>';
                }
            } else {
                $MonModalTitre = 'Echec';
                $MonModalTexte = 'Il n\'y a rien d\'écrit dans le champ de l\'intitulé de l\'activité';
                $MonModalBouton = '<a href="javascript:history.back()">Rééssayer</a>';
            }
        }
    }
};
