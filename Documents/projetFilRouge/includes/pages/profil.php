<main>

    <?php
        include('./includes/template/register.php');
/*
 *     if(isset($_GET['id']) && !empty($_GET['id'])) {
        if ($_GET['id'] == $_SESSION['Id'] || $_SESSION['User_Level'] > 2) {


            //la requete de la table page
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


            include('./includes/template/register.php');
        }
        include('./includes/pages/membres.php');
    }
 */










