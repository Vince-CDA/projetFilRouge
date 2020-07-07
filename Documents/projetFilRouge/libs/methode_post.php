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
            $monModalTitre = 'Succès !';
            $monModalTexte = 'Votre inscription a bien été prise en compte, vous serez recontacté par mail quand un organisateur aura confirmé votre inscription.';
            $monModalBouton = '<a href="./index.php">Retour à la page d\'accueil</a>';

        }else if($_POST['formulaire'] == 'update_profil'){

            $query = 'UPDATE adherent SET 
              Login = "'.$_POST["login"].'",
              Password = "'.$_POST["password"].'",
              Prenom = "'.$_POST["prenom"].'",
              Nom = "'.$_POST["nom"].'",
              DNaiss = "'.$_POST["dnaiss"].'",
              Adresse1 = "'.$_POST["adresse1"].'",
              CdPost = "'.$_POST["cdpost"].'",
              Ville = "'.$_POST["ville"].'",
              Email = "'.$_POST["email"].'",
              Tel = "'.$_POST["tel"].'",
              cc = "'.$_POST["cc"].'"
              WHERE IdAdherent = '.$_POST["IdAdherent"];


            $bdd->query($query);
            //information modal html
            $monModalTitre = 'Mise à jour faite avec succès!';
            $monModalTexte = 'Le profil a bien été mis à jour.';
            $monModalBouton = 'Fermer';
        }else if($_POST['formulaire'] == 'connexion'){

            if(isset($_POST['login']) AND isset($_POST['password'])){
                if (!empty($_POST['login']) AND !empty($_POST['password'])) {

                    $query = 'SELECT IdAdherent,
                                     Nom,
                                     Prenom,
                                     Organisateur 
                                     FROM adherent 
                                     WHERE Login ="'.$_POST['login'].'" AND Password ="'.$_POST['password'].'"';
                    $reponse = $bdd->query($query);

                    if ($reponse->rowCount() == 1) {
                        while ($donnee = $reponse->fetch()) {
                            $nom = $donnee['Nom'];
                            $prenom = $donnee['Prenom'];
                            $id = $donnee['IdAdherent'];
                            $admin = $donnee['Organisateur'];
                            $_SESSION['nom'] = $nom;
                            $_SESSION['prenom'] = $prenom;
                            $_SESSION['id'] = $id;
                            $_SESSION['admin'] = $admin;
                            $monModalTitre = 'Bravo';
                            $monModalTexte = 'Vous êtes maintenant connecté à MCMP.';
                            $monModalBouton = 'Ok !';
                        } }else{
                            $monModalTitre = 'Echec';
                            $monModalTexte = 'Votre identifiant ou votre mot de passe est invalide.';
                            $monModalBouton = 'Ok !';
                        }

                    }


                }
            }

        }





};
