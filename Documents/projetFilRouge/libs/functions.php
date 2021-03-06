<?php
// Fonction d'upload d'image
function upload_img($directory)
{
    $error = true;
    $photoName = '';
    $fileType = '';
    $binary = '';

    if (isset($_FILES['image'])) {

        //les différentes clef de $_FILES
        $fileName = $_FILES['image']['name']; //01.02.JPG
        $fileType = $_FILES['image']['type'];//type de fichier dans l'entete du fichier = manipulable
        $fileTmp = $_FILES['image']['tmp_name'];//nom temporaire du fichier sur le serveur APACHE avant traitement
        $fileError = $_FILES['image']['error'];
        $fileSize = $_FILES['image']['size'];
        //mes variable de config
        $limitSize = 2097152;//votre limitte d'acception de la taille du fichier

        $validExtention = array('png', 'jpeg', 'jpg', 'gif');

        //Trouver l'extention du fichier
        $nameArray = explode(".", $fileName); //array("01","JGP") -> 2 élements
        $lastIndex = count($nameArray) - 1;//total des éléments (2) mais je veux trouver le dernier index
        //array[0] = "01"
        //array[1] = "JPG"
        $extention = strtolower($nameArray[$lastIndex]);//deux elements dans le tb, mais -1 pour l'index du dernier element car index commence a zero

        //est-ce que l'extention est dans le tableau de mes extentions
        if (in_array($extention, $validExtention)) {

            //nom de mon fichier
            $photoName = time() . "." . $extention;

            //la limite est elle valide ?
            if ($limitSize > $fileSize) {


                //if($methode == 'blob'){

                $binary = file_get_contents($fileTmp);
                // et $fileType

                //}else{
                //fonction d'upload sur le serveur
                move_uploaded_file($fileTmp, $directory . $photoName);

                //}


                $error = false;
                $MonModalTexte = "Avatar uploadé";
            } else {
                $MonModalTexte = "Extension d'image non valide";
            }
        } else {
            $MonModalTexte = "Fichier image trop gros (" . ($limitSize / 1000000) . " Mo max)";
        }
    } else {
        $MonModalTexte = "Pas de fichier Upload";
    }

    return array($error, $MonModalTexte, $photoName, $binary, $fileType);
}

function upload_file($directory)
{
    $error = true;
    $fichiername = '';
    $fileType = '';
    $binary = '';

    if (isset($_FILES['fichier'])) {

        //les différentes clef de $_FILES
        $fileName = $_FILES['fichier']['name']; //01.02.JPG
        $fileType = $_FILES['fichier']['type'];//type de fichier dans l'entete du fichier = manipulable
        $fileTmp = $_FILES['fichier']['tmp_name'];//nom temporaire du fichier sur le serveur APACHE avant traitement
        $fileError = $_FILES['fichier']['error'];
        $fileSize = $_FILES['fichier']['size'];
        //mes variable de config
        $limitSize = 2097152;//votre limitte d'acception de la taille du fichier

        $validExtention = array('pdf', 'txt', 'csv', 'doc', 'docx');

        //Trouver l'extention du fichier
        $nameArray = explode(".", $fileName); //array("01","JGP") -> 2 élements
        $lastIndex = count($nameArray) - 1;//total des éléments (2) mais je veux trouver le dernier index
        //array[0] = "01"
        //array[1] = "JPG"
        $extention = strtolower($nameArray[$lastIndex]);//deux elements dans le tb, mais -1 pour l'index du dernier element car index commence a zero

        //est-ce que l'extention est dans le tableau de mes extentions
        if (in_array($extention, $validExtention)) {

            //nom de mon fichier
            $fichiername = time() . "." . $extention;

            //la limite est elle valide ?
            if ($limitSize > $fileSize) {


                //if($methode == 'blob'){

                $binary = file_get_contents($fileTmp);
                // et $fileType

                //}else{
                //fonction d'upload sur le serveur
                move_uploaded_file($fileTmp, $directory . $fichiername);

                //}


                $error = false;
                $MonModalTexte = "Document uploadé";
            } else {
                $MonModalTexte = "Extension de document invalide : pdf, txt, csv, doc, docx autorisés";
            }
        } else {
            $MonModalTexte = "Fichier *trop gros (" . ($limitSize / 1000000) . " Mo max)";
        }
    } else {
        $MonModalTexte = "Pas de fichier Upload";
    }

    return array($error, $MonModalTexte, $fichiername, $binary, $fileType);
}

//Fonction de cryptage de mot de passe avec un Salt donné puis un Mot de passe ainsi qu'un Login
function My_Crypt($password, $login)
{
    $salt = 'banane';
    return hash('sha256', $salt.$password.$login);
}

/*
FONCTION CRYPTAGE SI LES MOTS DE PASSES SONT EN CLAIR DANS LA BDD, \!/ NE PLUS EXECUTER \!/

function Cryptage_Password(){
    include('./config/config.php');

    $Query = 'SELECT                 IdAdherent,
                                     Password
                                     FROM adherent';
                    $Reponse = $BDD->query($Query);
                    while ($Donnees = $Reponse->fetch()) {
                    $password = My_Crypt($Donnees["Password"]);


                    $Query = 'UPDATE adherent SET
                    Password = "'.$password.'"
                    WHERE IdAdherent = '.$Donnees["IdAdherent"];
                    $BDD->query($Query);
                    }
}
*/
function controle_adresse($addr)
{
    $adresse = "^([0-9a-z'àâéèêôùûçÀÂÉÈÔÙÛÇ\s-]{1,50})$";
    if (mb_eregi($adresse, $addr)) {
        return true;
    }
    if (!mb_eregi($adresse, $addr)) {
        return false;
    }
}

function Genere_Password($size)
{
    // Initialisation des caractères utilisables
    $characters = array('@', '/', '\\', '$', '*', 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
    $password = '';
    for ($i=0;$i<$size;$i++) {
        $password .= ($i%2) ? strtoupper($characters[array_rand($characters)]) : $characters[array_rand($characters)];
    }
        
    return $password;
}
