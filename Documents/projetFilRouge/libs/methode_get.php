<?php
/* Je récupère le résultat de la requête SQL  */

$reponse = $bdd->query('SELECT * FROM pages');

/* Je génère un tableau  */

$tbTitle = array();

/* Ma valeur $donnees sur les lignes de ma requête SQL $reponse */

while ($donnees = $reponse->fetch()) {
/* Mon $tbTitle avec comme clée chaque valeur de la colonne 'Key' de mes $donnees sera égale à mes lignes $donnees correspondante */
$tbTitle[$donnees['Key']] = $donnees;
}

/* Si ma valeur page contient une valeur existante dans le tableau de mes titres alors $mapage = laValeur */

if (isset($_GET['page']) && array_key_exists($_GET['page'],$tbTitle)) {
$mapage = $_GET['page'];
    //test sur les action de page
    if(isset($_GET['action']) && !empty($_GET['action'])) {

        //est-ce que l'action c'est delete sur la page membres ?
        if ($_GET['action'] == 'delete') {

            //est-ce qu'on a une valeur d'id ?
            if (isset($_GET['id']) && !empty($_GET['id'])) {

                //est-ce que c'est sur la page membre ?
                if ($mapage == 'membres') {

                    //lancement de la requete
                    $bdd->query('DELETE FROM adherent WHERE IdAdherent = ' . $_GET['id']);

                    //information modal html
                    $message_modal = 'Utilisateur ' . $_GET['id'] . ' supprimé.';

                } else if ($mapage == 'activites') {
                    //ici le code pour gérer les suppressions des activités


                }

            }
        }
    }
} else {
$mapage = 'accueil';
}

/* Mon titre de page présent dans header est donc égal au titre de la valeur correspondante au tableau suivant la page. (accueil par défaut) */

$titre = $tbTitle[$mapage]['Titre'];
