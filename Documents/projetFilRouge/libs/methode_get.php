<?php
/* Je récupère le résultat de la requête SQL  */
//J'inclus une seule fois le MailEngine pour mon formulaire de contact
require_once './libs/MailEngine.php';
use Lib\MailEngine;

$Reponse = $BDD->query('SELECT * FROM pages');
$MesId = $BDD->query('SELECT * FROM adherent');
$MesActivites = $BDD->query('SELECT * FROM activite WHERE Publier = 1');
$MesActivites0 = $BDD->query('SELECT * FROM activite WHERE Publier = 0');
$MesNews = $BDD->query('SELECT * FROM nouvelle');
$MesNews0 = $BDD->query('SELECT * FROM nouvelle WHERE Diffusion = 0');
$MesNews2 = $BDD->query('SELECT * FROM nouvelle WHERE Diffusion = 2');
$MesMembres = $BDD->query('SELECT * FROM adherent');
$TbTicketMdp = $BDD->query('SELECT * FROM adherentrecovery');
$TbIdFichiers = $BDD->query('SELECT * FROM fichiers');
/* Je génère un tableau  */

$TbTitle = array();
$TbActivite = array();
$TbActivite0 = array();
$TbMesId = array();
$TbNews = array();
$TbNews0 = array();
$TbNews2 = array();
$TbMembres = array();
$tbticketmdp = array();
$tbfichiers = array();
/* Ma valeur $Donnees sur les lignes de ma requête SQL $reponse */

while ($Donnees = $Reponse->fetch()) {
    /* Mon $tbTitle avec comme clée chaque valeur de la colonne 'Key' de mes $Donnees sera égale à mes lignes $Donnees correspondante */
    $TbTitle[$Donnees['Key']] = $Donnees;
}
while ($Donnees2 = $MesId->fetch()) {
    /* Mon $tbTitle avec comme clée chaque valeur de la colonne 'Key' de mes $Donnees sera égale à mes lignes $Donnees correspondante */
    $TbMesId[$Donnees2['IdAdherent']] = $Donnees2;
}

while ($Donnees3 = $MesActivites->fetch()) {
    /* Mon $tbTitle avec comme clée chaque valeur de la colonne 'Key' de mes $Donnees sera égale à mes lignes $Donnees correspondante */
    $TbActivites[$Donnees3['IdActivite']] = $Donnees2;
}
while ($Donnees8 = $MesActivites0->fetch()) {
    /* Mon $tbTitle avec comme clée chaque valeur de la colonne 'Key' de mes $Donnees sera égale à mes lignes $Donnees correspondante */
    $TbActivites0[$Donnees8['IdActivite']] = $Donnees8;
}
while ($Donnees4 = $MesNews->fetch()) {
    /* Mon $tbTitle avec comme clée chaque valeur de la colonne 'Key' de mes $Donnees sera égale à mes lignes $Donnees correspondante */
    $TbNews[$Donnees4['IdNouvelle']] = $Donnees4;
}
while ($Donnees7 = $MesNews0->fetch()) {
    /* Mon $tbTitle avec comme clée chaque valeur de la colonne 'Key' de mes $Donnees sera égale à mes lignes $Donnees correspondante */
    $TbNews0[$Donnees7['IdNouvelle']] = $Donnees7;
} while ($Donnees6 = $MesNews2->fetch()) {
    /* Mon $tbTitle avec comme clée chaque valeur de la colonne 'Key' de mes $Donnees sera égale à mes lignes $Donnees correspondante */
    $TbNews2[$Donnees6['IdNouvelle']] = $Donnees6;
}
while ($Donnees5 = $MesMembres->fetch()) {
    /* Mon $tbTitle avec comme clée chaque valeur de la colonne 'Key' de mes $Donnees sera égale à mes lignes $Donnees correspondante */
    $TbMembres[$Donnees5['IdAdherent']] = $Donnees5;
}
while ($Donnees8 = $TbTicketMdp->fetch()) {
    /* Mon $tbTitle avec comme clée chaque valeur de la colonne 'Key' de mes $Donnees sera égale à mes lignes $Donnees correspondante */
    $tbticketmdp[$Donnees8['Ticket']] = $Donnees8;
}
while ($Donnees9 = $TbIdFichiers->fetch()) {
    /* Mon $tbTitle avec comme clée chaque valeur de la colonne 'Key' de mes $Donnees sera égale à mes lignes $Donnees correspondante */
    $tbfichiers[$Donnees9['IdFichier']] = $Donnees9;
}

/* Si ma valeur page contient une valeur existante dans le tableau de mes titres alors $MaPage = laValeur */

if (isset($_GET['page']) && array_key_exists($_GET['page'], $TbTitle)) {
    $MaPage = $_GET['page'];
    if ($_GET['page'] == 'connexion' && isset($_SESSION['Id']) && !empty($_SESSION['Id'])) {
        $MaPage = 'accueil';
    } else {
        if (isset($_GET['action']) && !empty($_GET['action'])) {
            if ($_GET['action'] == 'mdpoublie') {
                $MonModalTitre = 'Mot de passe oublié ?';
                $MonModalTexte = 'Entrez votre login</p><input type="text" name="login" placeholder="Votre identifiant"/></p>
            <p>Entrez votre adresse email</p>
            <p><input type="email" name="email" placeholder="Votre adresse email..."/></p>
            ';
                $typemodal = 'type="submit"';
                $idmodal = 'id="mdpoublier"';
                $MonModalBouton = 'Envoyer un nouveau mot de passe';
                $modalhead = '<div class="text-center"><form id="mdpoublie" action="#">';
                $modalfoot = '</form></div>';
            }
        }
        if (isset($_GET['ticket']) && !empty($_GET['ticket']) && array_key_exists($_GET['ticket'], $tbticketmdp)) {
            $query = 'SELECT IdAdherent, Mail, Login, Password FROM adherentrecovery WHERE Ticket = ?';
            $result = $BDD->prepare($query);
            $reponse = $result->execute(array(
                $_GET['ticket']
            ));
            $row = $result->rowCount();
            if ($row==1) {
                while ($donnees = $result->fetch()) {
                    $id = $donnees['IdAdherent'];
                    $query2 = 'UPDATE adherent SET Password = ?';
                    $mdp = My_Crypt($donnees['Password'], $donnees['Login']);
                    $result2 = $BDD->prepare($query2);
                    $reponse = $result2->execute(array(
                    $mdp
                ));
                    $requete = $BDD->prepare('DELETE FROM adherentrecovery WHERE IdAdherent = ?');
                    $requete->execute(array(
                        $id
                    ));
                    $MonModalTitre = 'Nouveau mot de passe généré';
                    $MonModalTexte = 'Votre nouveau mot de passe vous a été envoyé par mail. Merci de le changer par la suite.';
                    $MonModalBouton = 'Ok';
                    MailEngine::send('Votre nouveau mot de passe à été généré', 'vince.cda3@gmail.com', $donnees['Mail'], 'Moto Club Millau Passion', 'Bonjour, voici votre mot de passe pour Moto Club Millau Passion (http://cda27.s1.2isa.org) <br /> '.$donnees['Password'].'<br />Merci de penser à le changer dès que possible dans votre profil. A bientôt!');
                }
            } else {
                $MonModalTitre = 'Expiration du lien';
                $MonModalTexte = 'Votre ticket a expirer ou a déjà été utilisé, merci de regénérer un mot de passe.';
                $MonModalBouton = 'Ok';
            }
        }
    }
    //Est-ce qu'on cherche à voir un profil ? Il y a un id valable ?
    if ($_GET['page'] == 'profil' && isset($_GET['id']) && !empty($_GET['id'])) {
        if (!empty($_SESSION['User_Level']) && isset($_SESSION['User_Level'])) {
            if (isset($_GET['action']) && !empty($_GET['action'])) {
                if ($_GET['action'] == 'pass') {
                    $MonModalTitre = 'Changer de mot de passe';
                    $MonModalTexte = 'Tapez votre mot de passe :</p><input type="password" name="password" placeholder="Mot de passe courant..."/></p>
                <p>Tapez votre nouveau mot de passe</p>
                <p><input type="password" name="newpassword" placeholder="Nouveau mot de passe..."/></p>
                <p>Confirmez votre nouveau mot de passe</p>
                <p><input type="password" name="newpassword2" placeholder="Nouveau mot de passe..."/>
                ';
                    $typemodal = 'type="submit"';
                    $idmodal = 'id="modalbouton"';
                    $MonModalBouton = 'Changer le mot de passe';
                    $modalhead = '<form id="changerpassword" action="#"><input type="hidden" name="id" value="'.$_GET['id'].'"/>';
                    $modalfoot = '</form>';
                }
            }
            //Est-ce que l'utilisateur veut voir son propre profil ou a-t-il les droits d'aller en voir un autre ?
            if ($_SESSION['User_Level'] > 1 && array_key_exists($_GET['id'], $TbMesId) || $_GET['id'] == $_SESSION['Id']) {
                $Reponse = $BDD->query('SELECT * FROM adherent WHERE IdAdherent = ' . $_GET['id']);
                //boucle les données récupérées
                while ($Donnees = $Reponse->fetch()) {
                    $Identifiant = $Donnees['Login'];
                    $Password = $Donnees['Password'];
                    $Prenom = $Donnees['Prenom'];
                    $Nom = $Donnees['Nom'];
                    $DateNaiss = $Donnees['DNaiss'];
                    $Adresse = $Donnees['Adresse1'];
                    $CodeP = $Donnees['CdPost'];
                    $Ville = $Donnees['Ville'];
                    $Email = $Donnees['Email'];
                    $Tel = $Donnees['Tel'];
                    $CC = $Donnees['CC'];
                    $image = $Donnees['Avatar'];
                    $Titre = $Prenom . ' ' . $Nom . '';
                    $Id = $_GET['id'];
                    $Title_Register = 'Mise à jour de votre profil';
                    $Btn_Register = 'Mettre à jour';
                    $Action = 'updateprofil';
                    $Organisateur = $Donnees['Organisateur'];
                    $Admin = $Donnees['Admin'];
                    $Active = $Donnees['Active'];
                    $apropos = $Donnees['Apropos'];
                }
                if ($_SESSION['User_Level'] > 2) {
                    $col = 4;
                    $checked = $Admin == 1 ? 'checked' : '';
                    $AdminLabel =       '<div class="col-lg-4">
                                        <label class="py-0 mb-0" for="mobile">Admin</label>
                                        <input type="checkbox" name="Admin" value="1" '.$checked.'/>
                                        </div>
                                        ';
                } else {
                    $col = 6;
                }
            }
        } else {
            $MaPage = 'accueil';
        }
    } elseif ($_GET['page'] == 'admin') {
        if (isset($_SESSION['Id'])) {
            $MaPage = 'admin';
        } else {
            $MaPage = 'accueil';
        }
    } elseif ($_GET['page'] == 'newscontent') {
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            if (array_key_exists($_GET['id'], $TbNews)) {
                //Mes id et value de boutons changent par rapport à la page où je suis. Dans le cas d'une newscontent je peux soit editer soit supprimer la nouvelle
                $idboutonsuccess = 'editer';
                $idboutondanger = 'annnuler';
                $valueboutonsuccess = 'Editer la nouvelle';
                $valueboutondanger = 'Supprimer la nouvelle';
                //la requete de la table page
                $reponse = $BDD->query('SELECT * FROM nouvelle WHERE IdNouvelle = '.$_GET['id']);


                //boucle les données récupérées
                while ($donnees = $reponse->fetch()) {
                    $titlenews = $donnees['Titre'];
                    $contenunews = $donnees['Texte'];
                }
            } elseif (array_key_exists($_GET['id'], $TbNews0) && isset($_SESSION['User_Level']) && $_SESSION['User_Level'] > 1) {
         
                //Mes id et value de boutons changent par rapport à la page où je suis. Dans le cas d'une newscontent je peux soit editer soit supprimer la nouvelle
                $idboutonsuccess = 'editer';
                $idboutondanger = 'annnuler';
                $valueboutonsuccess = 'Editer la nouvelle';
                $valueboutondanger = 'Supprimer la nouvelle';
                //la requete de la table page
                $reponse = $BDD->query('SELECT * FROM nouvelle WHERE IdNouvelle = '.$_GET['id']);
   
   
                //boucle les données récupérées
                while ($donnees = $reponse->fetch()) {
                    $titlenews = $donnees['Titre'];
                    $contenunews = $donnees['Texte'];
                }
            } elseif (array_key_exists($_GET['id'], $TbNews2) && isset($_SESSION['User_Level']) && $_SESSION['User_Level'] > 0) {
                
                //Mes id et value de boutons changent par rapport à la page où je suis. Dans le cas d'une newscontent je peux soit editer soit supprimer la nouvelle
                $idboutonsuccess = 'editer';
                $idboutondanger = 'annnuler';
                $valueboutonsuccess = 'Editer la nouvelle';
                $valueboutondanger = 'Supprimer la nouvelle';
                //la requete de la table page
                $reponse = $BDD->query('SELECT * FROM nouvelle WHERE IdNouvelle = '.$_GET['id']);
   
   
                //boucle les données récupérées
                while ($donnees = $reponse->fetch()) {
                    $titlenews = $donnees['Titre'];
                    $contenunews = $donnees['Texte'];
                }
            } else {
                $MaPage = 'news';
            }
        } else {
            $MaPage = 'news';
        }
    } elseif ($_GET['page'] == 'activitecontent') {
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            if (array_key_exists($_GET['id'], $TbActivites)) {
    
                //Mes id et value de boutons changent par rapport à la page où je suis. Dans le cas d'une newscontent je peux soit editer soit supprimer la nouvelle
                $idboutonsuccess = 'inscriptionactivite';
                $valueboutonsuccess = 'S\'inscrire à l\'activité';
                $idboutondanger = 'supprimer';
                $valueboutondanger = 'Supprimer l\'activité';
                $idboutondesinscrire = 'desinscrire';
                $valueboutondesinscrire = 'Se désinscrire de l\'activité';
                $idboutonedit = 'inscriptionedit';
                $valueboutonedit = 'Editer l\'activité';
                if (isset($_SESSION['Id'])) {
                    $inscription = $BDD->query('SELECT * FROM inscription WHERE IdActivite = '.$_GET['id'].' AND IdAdherent = '.$_SESSION['Id']);
                    $rowinscrit = $inscription->rowCount();
                    if ($rowinscrit < 1) {
                        $inscirt = null;
                    } else {
                        $inscrit = 'nada';
                    }
                    if (isset($_GET['action']) && !empty($_GET['action'])) {
                        if ($_GET['action'] == 'desinscrire') {
                            $BDD->query('DELETE FROM inscription WHERE IdAdherent = ' .$_SESSION['Id']);
                            $MonModalBouton = '<a href="./page-activitecontent-'.$_GET['id'].'">Ok</a>';
                            $MonModalTexte = 'Vous êtes bien désinscrit de l\'activité';
                            $MonModalTitre = 'Désinscription';
                        }
                    }
                }
                //la requete de la table page
                $reponse = $BDD->query('SELECT * FROM activite WHERE IdActivite = '.$_GET['id']);
                $reponse3 = $BDD->query('SELECT * FROM inscription as i JOIN adherent as b
                WHERE i.IdAdherent = b.IdAdherent AND i.IdActivite ='.$_GET['id']);
                $nom = '';
                $row=$reponse3->rowCount();
                if ($row != 0) {
                    while ($donnees3 = $reponse3->fetch()) {
                        $nom .= '<li>'.$donnees3['Nom'].' '.$donnees3['Prenom'];
                        $donnees3['NbInvités'] > 0 ? $nom .= ' qui invite '.$donnees3['NbInvités'].' invités.</li>':'</li>';
                    }
                    $reponse4 = $BDD->query('SELECT COUNT(i.IdAdherent)+SUM(i.NbInvités) as total FROM inscription as i JOIN adherent as b
                WHERE i.IdAdherent = b.IdAdherent AND i.IdActivite ='.$_GET['id']);
                    while ($donnees3 = $reponse4->fetch()) {
                        $motard = $donnees3['total'] == 1 ? 'motard' : 'motards';
                        $total = '<h5>Nous serions donc un total de '.$donnees3['total'].' '.$motard.' pour l\'activité</h5>';
                    }
                } else {
                    $nom = '<h5>Il n\'y a pas encore d\'inscription à cette activité</h5>';
                    $total = '';
                }
                
    
                //boucle les données récupérées
                while ($donnees = $reponse->fetch()) {
                    $titreactivite = $donnees['IntituleActivite'];
                    $contenuactivite = $donnees['Description'];
                    $datedebut = $donnees['DDebut'];
                    $datefin = $donnees['DFin'];
                    $datelimite = $donnees['DLimite'];
                    $tarifa = $donnees['TarifAdherent'];
                    $tarifi = $donnees['TarifInvite'];
                    $typeid = $donnees['IdType'];
                }
                if (isset($_GET['inscrireactivite']) && !empty($_GET['inscrireactivite']) && $_GET['inscrireactivite'] == 1) {
                    $MonModalBouton = 'Fermer';
                    $MonModalTexte = 'Vous voulez vous inscrire à '.$titreactivite.', nous avons maintenant besoin de savoir si il y aura des invités avec vous.
                    <div class="col-md-6 policesize">
                    <form action="page-activitecontent-'.$_GET['id'].'" method="post" class="register-form" enctype="multipart/form-data">
                    <input type="hidden" name="formulaire" value="inscriptionactivite" />
                    <div class="form-group"><label class="ls text-uppercase color-3 fw-700 mb-0">Nombre d\'invités :</label><input class=" text-uppercase color-3 fw-700 
                    form-control background-white" type="number" name="NombreInvite" min="0" max="300" value="0" required="required"></div>
                    </div>
                    <div class="col-12  mt-2">
                    <button id="'.$idboutonsuccess.'" type="submit" class="btn btn-success float-right lead">'.$valueboutonsuccess.'</button>                                               
                    </div>
                    </form>
                    ';
                    $MonModalTitre = 'Inscription à l\'activité';
                }
                $reponse2 = $BDD->query('SELECT * FROM type_activite WHERE IdType = '.$typeid);
                while ($donnees2 = $reponse2->fetch()) {
                    $type = $donnees2['IntituleType'];
                }
            } elseif (isset($_SESSION['User_Level']) && !empty($_SESSION['User_Level']) && $_SESSION['User_Level'] > 1 && array_key_exists($_GET['id'], $TbActivites0)) {
    
                    //Mes id et value de boutons changent par rapport à la page où je suis. Dans le cas d'une newscontent je peux soit editer soit supprimer la nouvelle
                $idboutonsuccess = 'inscriptionactivite';
                $valueboutonsuccess = 'S\'inscrire à l\'activité';
                $idboutondanger = 'supprimer';
                $valueboutondanger = 'Supprimer l\'activité';
                $idboutondesinscrire = 'desinscrire';
                $valueboutondesinscrire = 'Se désinscrire de l\'activité';
                $idboutonedit = 'inscriptionedit';
                $valueboutonedit = 'Editer l\'activité';
                $inscription = $BDD->query('SELECT * FROM inscription WHERE IdActivite = '.$_GET['id'].' AND IdAdherent = '.$_SESSION['Id']);
                $rowinscrit = $inscription->rowCount();
                if ($rowinscrit < 1) {
                    $inscirt = null;
                } else {
                    $inscrit = 'nada';
                }
                if (isset($_GET['action']) && !empty($_GET['action'])) {
                    if ($_GET['action'] == 'desinscrire') {
                        $BDD->query('DELETE FROM inscription WHERE IdAdherent = ' .$_SESSION['Id']);
                        $MonModalBouton = '<a href="./page-activitecontent-'.$_GET['id'].'">Ok</a>';
                        $MonModalTexte = 'Vous êtes bien désinscrit de l\'activité';
                        $MonModalTitre = 'Désinscription';
                    }
                }
                //la requete de la table page
                $reponse = $BDD->query('SELECT * FROM activite WHERE IdActivite = '.$_GET['id']);
                $reponse3 = $BDD->query('SELECT * FROM inscription as i JOIN adherent as b
                    WHERE i.IdAdherent = b.IdAdherent AND i.IdActivite ='.$_GET['id']);
                $nom = '';
                $row=$reponse3->rowCount();
                if ($row != 0) {
                    while ($donnees3 = $reponse3->fetch()) {
                        $nom .= '<li>'.$donnees3['Nom'].' '.$donnees3['Prenom'];
                        $donnees3['NbInvités'] > 0 ? $nom .= ' qui invite '.$donnees3['NbInvités'].' invités.</li>':'</li>';
                    }
                    $reponse4 = $BDD->query('SELECT COUNT(i.IdAdherent)+SUM(i.NbInvités) as total FROM inscription as i JOIN adherent as b
                    WHERE i.IdAdherent = b.IdAdherent AND i.IdActivite ='.$_GET['id']);
                    while ($donnees3 = $reponse4->fetch()) {
                        $motard = $donnees3['total'] == 1 ? 'motard' : 'motards';
                        $total = '<h5>Nous serions donc un total de '.$donnees3['total'].' '.$motard.' pour l\'activité</h5>';
                    }
                } else {
                    $nom = '<h5>Il n\'y a pas encore d\'inscription à cette activité</h5>';
                    $total = '';
                }
                    
        
                //boucle les données récupérées
                while ($donnees = $reponse->fetch()) {
                    $titreactivite = $donnees['IntituleActivite'];
                    $contenuactivite = $donnees['Description'];
                    $datedebut = $donnees['DDebut'];
                    $datefin = $donnees['DFin'];
                    $datelimite = $donnees['DLimite'];
                    $tarifa = $donnees['TarifAdherent'];
                    $tarifi = $donnees['TarifInvite'];
                    $typeid = $donnees['IdType'];
                }
                if (isset($_GET['inscrireactivite']) && !empty($_GET['inscrireactivite']) && $_GET['inscrireactivite'] == 1) {
                    $MonModalBouton = 'Fermer';
                    $MonModalTexte = 'Vous voulez vous inscrire à '.$titreactivite.', nous avons maintenant besoin de savoir si il y aura des invités avec vous.
                        <div class="col-md-6 policesize">
                        <form action="page-activitecontent-'.$_GET['id'].'" method="post" class="register-form" enctype="multipart/form-data">
                        <input type="hidden" name="formulaire" value="inscriptionactivite" />
                        <div class="form-group"><label class="ls text-uppercase color-3 fw-700 mb-0">Nombre d\'invités :</label><input class=" text-uppercase color-3 fw-700 
                        form-control background-white" type="number" name="NombreInvite" min="0" max="300" value="0" required="required"></div>
                        </div>
                        <div class="col-12  mt-2">
                        <button id="'.$idboutonsuccess.'" type="submit" class="btn btn-success float-right lead">'.$valueboutonsuccess.'</button>                                               
                        </div>
                        </form>
                        ';
                    $MonModalTitre = 'Inscription à l\'activité';
                }
                $reponse2 = $BDD->query('SELECT * FROM type_activite WHERE IdType = '.$typeid);
                while ($donnees2 = $reponse2->fetch()) {
                    $type = $donnees2['IntituleType'];
                }
            } else {
                $MaPage = 'activites';
            }
        } else {
            $MaPage = 'activites';
        }
    } elseif ($_GET['page'] == 'editactivite') {
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            if (array_key_exists($_GET['id'], $TbActivites)) {
                $idboutonsuccess = 'updateactivite';
                $valueboutonsuccess = 'Mettre à jour l\'activité';
                $reponse = $BDD->query('SELECT * FROM activite WHERE IdActivite = '.$_GET['id']);
                while ($donnees=$reponse->fetch()) {
                    $IntituleActivite = $donnees['IntituleActivite'];
                    $DescriptionActivite = $donnees['Description'];
                    $DDebut = str_replace(' ', 'T', $donnees['DDebut']);
                    $DFin = str_replace(' ', 'T', $donnees['DFin']);
                    $DLimite = str_replace(' ', 'T', $donnees['DLimite']);
                    $TarifAdherent = $donnees['TarifAdherent'];
                    $TarifInvite = $donnees['TarifInvite'];
                }
            }
        }
    } elseif ($_GET['page'] == 'ajoutactivite') {
        if (isset($_SESSION['User_Level']) && !empty($_SESSION['User_Level'])) {
            //Est-ce que l'utilisateur veut voir son propre profil ou a-t-il les droits d'aller en voir un autre ?
            if ($_SESSION['User_Level'] > 1) {
        
                        //Mes id et value de boutons changent par rapport à la page où je suis. Dans le cas d'une newscontent je peux soit editer soit supprimer la nouvelle
                $idboutonsuccess = 'ajoutactivite';
                $valueboutonsuccess = 'Ajouter une activité';
                $MonModalTitre = 'Message';
                $MonModalBouton = 'Fermer';
                //la requete de la table page
            }
        } else {
            $MaPage = 'accueil';
        }
    } elseif ($_GET['page'] == 'activite') {
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            if (array_key_exists($_GET['id'], $TbActivites)) {
                if (isset($_GET['action']) && !empty($_GET['action'])) {
                    if ($_GET['action'] == 'supprimer') {
                        if (isset($_SESSION['User_Level']) && $_SESSION['User_Level'] > 1) {
                            $reponse = $BDD->query('DELETE FROM activite WHERE IdActivite = '.$_GET['id']);
                            $MonModalTexte = 'Activité supprimée';
                            $MonModalBouton = 'Fermer';
                            $MonModalTitre = 'L\'activité a bien été supprimée';
                            $MaPage = 'activites';
                        } else {
                            $MonModalTexte = 'Accès refusé';
                            $MonModalBouton = 'Fermer';
                            $MonModalTitre = 'Vous n\'avez pas le droit d\'accéder à cette fonctionnalité';
                            $MaPage = 'activites';
                        }
                    }
                }
            }
        }
    } elseif ($_GET['page'] == 'news') {
        if (isset($_SESSION['User_Level']) && !empty($_SESSION['User_Level'])) {
            //Est-ce que l'utilisateur veut voir son propre profil ou a-t-il les droits d'aller en voir un autre ?
            if ($_SESSION['User_Level'] > 1) {
                //Si la page est news, qu'il y a un id, et qu'il y a une action supprimer alors je supprime la news par une requête delete
                if (isset($_GET['id']) && !empty($_GET['id'])) {
                    if (array_key_exists($_GET['id'], $TbNews)) {
                        if (isset($_GET['action']) && !empty($_GET['action'])) {
                            if ($_GET['action'] == 'supprimer') {
                                $reponse = $BDD->query('DELETE FROM nouvelle WHERE IdNouvelle = '.$_GET['id']);
                                $MonModalTexte = 'La nouvelle a bien été supprimée';
                                $MonModalBouton = '<a href="page-news">Retour aux nouvelles</a>';
                                $MonModalTitre = 'Suppression avec succès !';
                            } else {
                                $MaPage = 'news';
                                $MonModalTexte = 'Cette action est inconnue';
                                $MonModalBouton = 'Fermer';
                                $MonModalTitre = 'Problème d\'action';
                            }
                        } else {
                            $MaPage = 'news';
                            $MonModalTexte = 'Aucune action entrée';
                            $MonModalBouton = 'Fermer';
                            $MonModalTitre = 'Problème d\'action';
                        }
                    } else {
                        $MaPage = 'news';
                        $MonModalTexte = 'ID innexistante dans la base de données';
                        $MonModalBouton = 'Fermer';
                        $MonModalTitre = 'ID introuvable';
                    }
                }
            }
        }
    } elseif ($_GET['page'] == 'ajoutnews') {
        if (isset($_SESSION['User_Level']) && !empty($_SESSION['User_Level'])) {
            //Est-ce que l'utilisateur veut voir son propre profil ou a-t-il les droits d'aller en voir un autre ?
            if ($_SESSION['User_Level'] > 1) {
                //Si c'est la page ajoutnews alors les boutons sont publier ou annuler, ils sont géré par le main.js
                $idboutonsuccess = 'publier';
                $idboutondanger = 'annnuler';
                $valueboutonsuccess = 'Publier la nouvelle';
                $valueboutondanger = 'Annuler';
                $MonModalBouton = '<a href="page-news">Retour sur la page des news</a>';
            }
        } else {
            $MaPage = 'news';
            $MonModalTexte = 'Vous n\'êtes pas un admin, vous ne pouvez donc pas faire d\'action de ce type';
            $MonModalBouton = 'Fermer';
            $MonModalTitre = 'Impossible';
        }
    } elseif ($_GET['page'] == 'editnews') {
        if (isset($_SESSION['User_Level']) && !empty($_SESSION['User_Level'])) {
            //Est-ce que l'utilisateur veut voir son propre profil ou a-t-il les droits d'aller en voir un autre ?
            if ($_SESSION['User_Level'] > 1) {
                //Si c'est editnews et qu'il y a une id alors je peux editer ou supprimer la nouvelle
                if (isset($_GET['id']) && !empty($_GET['id'])) {
                    $idboutonsuccess = 'editer';
                    $idboutondanger = 'supprimer';
                    $valueboutonsuccess = 'Editer la nouvelle';
                    $valueboutondanger = 'Supprimer le nouvelle';
                    $id = $_GET['id'];
                    $MonModalBouton = '<a href="page-news">Retour aux nouvelles</a>';
                    $MonModalTitre = 'Information';
                        
                    //la requete de la table page
                    $reponse = $BDD->query('SELECT * FROM nouvelle WHERE IdNouvelle = '.$_GET['id']);
                        
                        
                    //boucle les données récupérées
                    while ($donnees = $reponse->fetch()) {
                        $titlenews = $donnees['Titre'];
                        $contenunews = $donnees['Texte'];
                        $diffusion = $donnees['Diffusion'];
                    }
                }
            }
        } else {
            $MaPage = 'news';
            $MonModalTexte = 'Vous n\'êtes pas un admin, vous ne pouvez donc pas faire d\'action de ce type';
            $MonModalBouton = 'Fermer';
            $MonModalTitre = 'Impossible';
        }
    } elseif ($_GET['page'] == 'membres') {
        if (isset($_GET['action']) && !empty($_GET['action'])) {
            //est-ce que l'action c'est delete sur la page membres ?
            if ($_GET['action'] == 'delete' && isset($_SESSION['User_Level']) && $_SESSION['User_Level'] > 1) {
                //est-ce qu'on a une valeur d'id ?
                if (isset($_GET['id']) && !empty($_GET['id']) && array_key_exists($_GET['id'], $TbMembres)) {
                    //est-ce que c'est sur la page membre ?
                    if ($_GET['page'] == 'membres') {
                        //lancement de la requete
                        $BDD->query('DELETE FROM inscription WHERE IdAdherent = ' .$_GET['id']);
                        $BDD->query('DELETE FROM adherent WHERE IdAdherent = ' . $_GET['id']);
                        //information modal html
                        $MonModalTitre = 'Supprimé!';
                        $MonModalTexte = 'L\'utilisateur n°'.$_GET['id'].' a bien été supprimé.';
                        $MonModalBouton = '<a href="javascript:history.back()">Revenir à la page précédente</a>';
                        $MaPage = 'membres';
                    }
                } else {
                    $MonModalTitre = 'Erreur';
                    $MonModalTexte = 'ID inconnu pour la suppression';
                    $MonModalBouton = '<a href="javascript:history.back()">Revenir à la page précédente</a>';
                    $MaPage = 'membres';
                }
            } else {
                $MonModalTitre = 'Erreur';
                $MonModalTexte = 'Vous n\'êtes pas administrateur';
                $MonModalBouton = '<a href="javascript:history.back()">Revenir à la page précédente</a>';
                $MaPage = 'membres';
            }
        }
    } elseif ($_GET['page'] == 'liste') {
        if (isset($_SESSION['User_Level']) && $_SESSION['User_Level'] > 1) {
            $trie = 0;
            if (isset($_GET['action'])) {
                if ($_GET['action'] == 'desc') {
                    $trie = '0';
                } elseif ($_GET['action'] == 'asc') {
                    $trie = '1';
                }
            }
            if (isset($_GET['id']) && (!empty($_GET['id'])) && array_key_exists($_GET['id'], $TbMesId)) {
                if (isset($_GET['action']) && !empty($_GET['action'])) {
                    if ($_GET['action'] == 'active') {
                        $Query = 'UPDATE adherent SET 
                                Active = ?
                                WHERE IdAdherent = ?';
                        $reponse = $BDD->prepare($Query);
                        $result = $reponse->execute(array(
                            1,
                            $_GET['id']
                    ));
                    } elseif ($_GET['action'] == 'desactive') {
                        $Query = 'UPDATE adherent SET 
                                Active = ?
                                WHERE IdAdherent = ?';
                        $reponse = $BDD->prepare($Query);
                        $reponse->execute(array(
                            0,
                            $_GET['id']
                    ));
                    }
                }
            }
        }
    } elseif ($_GET['page'] == 'listefichiers' && array_key_exists($_GET['id'], $tbfichiers)) {
        if (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'delete') {
            $Query = 'DELETE FROM fichiers WHERE 
                                IdFichier = ?';
            $reponse = $BDD->prepare($Query);
            $reponse->execute(array(
                            $_GET['id']
                    ));
        }
    } elseif ($_GET['page'] == 'ajouttype') {
        if (isset($_SESSION['User_Level']) && $_SESSION['User_Level'] > 1) {
            $MonModalTexte = 'Ce formulaire sert à ajouter un nom de type d\'activité</p><div class="row col-12"> <form method="post" action="./">
        <input type="hidden" name="formulaire" value="ajouttype" />
        <input class="col-12" type="text" name="intitule" placeholder="Ecrivez ici le nom du type d\'activité que vous voulez ajouter"/>
        <button type="submit" class="btn btn-success btn-sm col-12 mt-1 mb-5 ">Ajouter ce type d\'activité</button>
        </form></p>';
            $MonModalBouton = 'Annuler';
            $MonModalTitre = 'Ajout d\'un type d\'activité';
        }
    }
} else {
    $MaPage = 'accueil';
}   //test sur les action de page



/* Mon titre de page présent dans header est donc égal au titre de la valeur correspondante au tableau suivant la page. (accueil par défaut) */

$Titre = $TbTitle[$MaPage]['Titre'];
$Description = $TbTitle[$MaPage]['Description'];
$Keywords = $TbTitle[$MaPage]['Keywords'];
$Sujet = $TbTitle[$MaPage]['Sujet'];
