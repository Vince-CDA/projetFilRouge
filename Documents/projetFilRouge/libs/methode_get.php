<?php
/* Je récupère le résultat de la requête SQL  */

$Reponse = $BDD->query('SELECT * FROM pages');
$MesId = $BDD->query('SELECT * FROM adherent');
/* Je génère un tableau  */

$TbTitle = array();
$TbMesId = array();
/* Ma valeur $Donnees sur les lignes de ma requête SQL $reponse */

while ($Donnees = $Reponse->fetch()) {
/* Mon $tbTitle avec comme clée chaque valeur de la colonne 'Key' de mes $Donnees sera égale à mes lignes $Donnees correspondante */
$TbTitle[$Donnees['Key']] = $Donnees;
}
while ($Donnees2 = $MesId->fetch()) {
    /* Mon $tbTitle avec comme clée chaque valeur de la colonne 'Key' de mes $Donnees sera égale à mes lignes $Donnees correspondante */
    $TbMesId[$Donnees2['IdAdherent']] = $Donnees2;
}

/* Si ma valeur page contient une valeur existante dans le tableau de mes titres alors $MaPage = laValeur */

if (isset($_GET['page']) && array_key_exists($_GET['page'],$TbTitle)) {
$MaPage = $_GET['page'];
    //Est-ce qu'on cherche à voir un profil ? Il y a un id valable ?
    if ($_GET['page'] == 'profil' && isset($_GET['id']) && !empty($_GET['id'])) {
        //Est-ce que l'utilisateur veut voir son propre profil ou a-t-il les droits d'aller en voir un autre ?
        if ($_SESSION['User_Level'] > 2 && array_key_exists($_GET['id'],$TbMesId) || $_GET['id'] == $_SESSION['Id']) {
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

                //to be continued
                $Titre = $Prenom . ' ' . $Nom . '';
                $Id = $_GET['id'];
                $Title_Register = 'Mise à jour de votre profil';
                $Btn_Register = 'Mettre à jour';
                $Action = 'update_profil';
            }
        }else {
            $MaPage = 'accueil';
    }
    }
    //test sur les action de page
    if(isset($_GET['action']) && !empty($_GET['action'])) {

        //est-ce que l'action c'est delete sur la page membres ?
        if ($_GET['action'] == 'delete' && $_SESSION['User_Level'] > 2) {

            //est-ce qu'on a une valeur d'id ?
            if (isset($_GET['id']) && !empty($_GET['id'])) {

                //est-ce que c'est sur la page membre ?
                if ($MaPage == 'membres') {


                    //lancement de la requete
                    $BDD->query('DELETE FROM adherent WHERE IdAdherent = ' . $_GET['id']);

                    //information modal html
                    $MonModalTitre = 'Supprimé!';
                    $MonModalTexte = 'L\'utilisateur n°'.$_GET['id'].' a bien été supprimé.';
                    $MonModalBouton = 'Ok !';
                } else if ($MaPage == 'activites') {
                    //ici le code pour gérer les suppressions des activités


                }
                }

        }
    }


} else {
    $MaPage = 'accueil';
}

/* Mon titre de page présent dans header est donc égal au titre de la valeur correspondante au tableau suivant la page. (accueil par défaut) */

$Titre = $TbTitle[$MaPage]['Titre'];
