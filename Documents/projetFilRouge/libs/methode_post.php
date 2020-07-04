<?php
//test de la super global $_POST si elle n'est pas vide '!empty()'
if(!empty($_POST)){

    if (isset($_POST['formulaire'])){

        if($_POST['formulaire'] == 'register'){

            /* Pour voir le POST après validation du formulaire */
            //var_dump($_POST);

            $query = 'INSERT INTO adherent(
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
            cc,
            DAdhesion
            ) VALUES (
            "'.$_POST["login"].'",
            "'.$_POST["password"].'",
            "'.$_POST["nom"].'",
            "'.$_POST["prenom"].'",
            "'.$_POST["dnaiss"].'",
            "'.$_POST["adresse1"].'",
            "'.$_POST["cdpost"].'",
            "'.$_POST["ville"].'",
            "'.$_POST["email"].'",
            "'.$_POST["tel"].'",
            "'.$_POST["cc"].'",
            NOW()
            )';

            /* Pour voir la requête correspondante */
            //echo "Query : ".$query;

            /* Execution de la requête dans la base de données */
            $bdd->query($query);

            /* Changement du message de type modal */
            $message_modal = 'Inscription prise en compte, nous vous recontacterons.';

        }/*else if($_POST['formulaire'] == 'update_profil'){

            $query = 'UPDATE adherent SET 
              Login = "'.$_POST["login"].'",
              Prenom = "'.$_POST["prenom"].'",
              cylindree = "'.$_POST["cylindree"].'"
              WHERE IdAdherent = '.$_POST["IdAdherent"];


            $bdd->query($query);
            //information modal html
            $message_modal = 'Votre profil est mis à jour.'.$query;

        }
*/


    }

};
