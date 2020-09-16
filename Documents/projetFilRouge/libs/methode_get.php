<?php
/* Je récupère le résultat de la requête SQL  */

$Reponse = $BDD->query('SELECT * FROM pages');
$MesId = $BDD->query('SELECT * FROM adherent');
$MesActivites = $BDD->query('SELECT * FROM activite');
$MesNews = $BDD->query('SELECT * FROM nouvelle WHERE Diffusion = 1');
$MesNews0 = $BDD->query('SELECT * FROM nouvelle WHERE Diffusion = 0');
$MesMembres = $BDD->query('SELECT * FROM adherent');
/* Je génère un tableau  */

$TbTitle = array();
$TbActivite = array();
$TbMesId = array();
$TbNews = array();
$TbNews0 = array();
$TbMembres = array();
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
while ($Donnees4 = $MesNews->fetch()) {
    /* Mon $tbTitle avec comme clée chaque valeur de la colonne 'Key' de mes $Donnees sera égale à mes lignes $Donnees correspondante */
    $TbNews[$Donnees4['IdNouvelle']] = $Donnees4;
}
while ($Donnees6 = $MesNews0->fetch()) {
    /* Mon $tbTitle avec comme clée chaque valeur de la colonne 'Key' de mes $Donnees sera égale à mes lignes $Donnees correspondante */
    $TbNews0[$Donnees6['IdNouvelle']] = $Donnees6;
}
while ($Donnees5 = $MesMembres->fetch()) {
    /* Mon $tbTitle avec comme clée chaque valeur de la colonne 'Key' de mes $Donnees sera égale à mes lignes $Donnees correspondante */
    $TbMembres[$Donnees5['IdAdherent']] = $Donnees5;
}

/* Si ma valeur page contient une valeur existante dans le tableau de mes titres alors $MaPage = laValeur */

if (isset($_GET['page']) && array_key_exists($_GET['page'], $TbTitle)) {
    $MaPage = $_GET['page'];
    if ($_GET['page'] == 'connexion' && isset($_SESSION['Id']) && !empty($_SESSION['Id'])) {
        $MaPage = 'accueil';
    }
    //Est-ce qu'on cherche à voir un profil ? Il y a un id valable ?
    if ($_GET['page'] == 'profil' && isset($_GET['id']) && !empty($_GET['id'])) {
        if (!empty($_SESSION['User_Level']) && isset($_SESSION['User_Level'])) {
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
                    $Action = 'update_profil';
                }
            }
        } else {
            $MaPage = 'accueil';
        }
    } else if ($_GET['page'] == 'admin') {
        if (isset($_SESSION['Id'])) {
            $MaPage = 'admin';
        } else {
            $MaPage = 'accueil';
        }
    } 
     else if ($_GET['page'] == 'newscontent') {
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
                    $contenunews = urldecode($donnees['Texte']);
                }
            }else if (array_key_exists($_GET['id'], $TbNews0) && isset($_SESSION['User_Level']) && $_SESSION['User_Level'] > 1) {
         
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
                    $contenunews = urldecode($donnees['Texte']);
                }
            }   
             else {
                $MaPage = 'news';
            }
         }   else {
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
                $idboutonedit = 'inscriptionedit';
                $valueboutonedit = 'Editer l\'activité';
               
                //la requete de la table page
                $reponse = $BDD->query('SELECT * FROM activite WHERE IdActivite = '.$_GET['id']);
    
    
                //boucle les données récupérées
                while ($donnees = $reponse->fetch()) {
                    $titreactivite = $donnees['IntituleActivite'];
                    $contenuactivite = urldecode($donnees['Description']);
                    $datedebut = $donnees['DDebut'];
                    $datefin = $donnees['DFin'];
                    $datelimite = $donnees['DLimite'];
                    $tarifa = $donnees['TarifAdherent'];
                    $tarifi = $donnees['TarifInvite'];
                    $typeid = $donnees['IdType'];
                }
                if (isset($_GET['inscrireactivite']) && !empty($_GET['inscrireactivite']) && $_GET['inscrireactivite'] == 1){
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
    } elseif ($_GET['page'] == 'ajoutactivite') {
        if (isset($_SESSION['User_Level']) && !empty($_SESSION['User_Level'])) {
            //Est-ce que l'utilisateur veut voir son propre profil ou a-t-il les droits d'aller en voir un autre ?
            if ($_SESSION['User_Level'] > 1) {
        
                        //Mes id et value de boutons changent par rapport à la page où je suis. Dans le cas d'une newscontent je peux soit editer soit supprimer la nouvelle
                $idboutonsuccess = 'ajoutactivite';
                $valueboutonsuccess = 'Ajouter une activité';
                $MonModalTitre = 'Message';
                $MonModalBouton = '<a href="page-activites">Fermer</a>';
                //la requete de la table page
            }
        } else {
            $MaPage = 'accueil';
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
            } else {
                $MaPage = 'news';
                $MonModalTexte = 'Vous n\'êtes pas un admin, vous ne pouvez donc pas faire d\'action de ce type';
                $MonModalBouton = 'Fermer';
                $MonModalTitre = 'Impossible';
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
                        $contenunews = urldecode($donnees['Texte']);
                    }
                }
            }
        }else {
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
                        $BDD->query('DELETE FROM adherent WHERE IdAdherent = ' . $_GET['id']);
                        //information modal html
                        $MonModalTitre = 'Supprimé!';
                        $MonModalTexte = 'L\'utilisateur n°'.$_GET['id'].' a bien été supprimé.';
                        $MonModalBouton = 'Ok !';
                        $MaPage = 'membres';
                    }
                }else {
                    $MonModalTitre = 'Erreur';
                    $MonModalTexte = 'ID inconnu pour la suppression';
                    $MonModalBouton = 'Ok !';
                    $MaPage = 'membres';
        }
            } else {
                        $MonModalTitre = 'Erreur';
                        $MonModalTexte = 'Vous n\'êtes pas administrateur';
                        $MonModalBouton = 'Ok !';
                        $MaPage = 'membres';
            }
        }
    }
} else {
    $MaPage = 'accueil';
}   //test sur les action de page



/* Mon titre de page présent dans header est donc égal au titre de la valeur correspondante au tableau suivant la page. (accueil par défaut) */

$Titre = $TbTitle[$MaPage]['Titre'];
