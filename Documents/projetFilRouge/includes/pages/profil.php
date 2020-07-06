<main>

    <?php

    if(isset($_GET['id']) && !empty($_GET['id'])){

        //la requete de la table page
        $reponse = $bdd->query('SELECT * FROM adherent WHERE IdAdherent = '.$_GET['id']);


        //boucle les données récupérées
        while ($donnees = $reponse->fetch()) {

            $identifiant = $donnees['Login'];
            $password = $donnees['Password'];
            $prenom = $donnees['Prenom'];
            $nom = $donnees['Nom'];
            $datenaiss = $donnees['DNaiss'];
            $adresse = $donnees['Adresse1'];
            $codep = $donnees['CdPost'];
            $ville = $donnees['Ville'];
            $email = $donnees['Email'];
            $tel = $donnees['Tel'];
            $cylindree = $donnees['cc'];

            //to be continued

        }

        $titre = $prenom.' '.$nom.'';
        $id = $_GET['id'];

    }



    $title_register = 'Mise à jour de votre profil';
    $btn_register = 'Mettre à jour';
    $action = 'update_profil';

    include('./includes/template/register.php');

    ?>

</main>