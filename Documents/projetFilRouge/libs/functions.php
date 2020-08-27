<?php

function upload_img($directory){

    $error = true;
    $photoName = '';
    $fileType = '';
    $binary = '';

    if(isset($_FILES['image'])) {

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

    }else{
        $MonModalTexte = "Pas de fichier Upload";

    }

    return array($error, $MonModalTexte, $photoName, $binary, $fileType);

}