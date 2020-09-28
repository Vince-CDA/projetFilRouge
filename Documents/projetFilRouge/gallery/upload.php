<?php
define('BASE_PATH', rtrim(realpath(dirname(__FILE__)), "/") . '/');

require './gallery/settings.php';


$upload_category = $_POST['category'];

$target_dir = "gallery/" . $upload_category . "/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        // echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        $message = "<p>Ce fichier n'est pas une image</p>";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    $message = "<p>Un fichier portant ce nom existe déjà</p>";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 10000000) {
    $message = "<p>Le fichier dépasse la taille autorisée</p>";
    $uploadOk = 0;
}
// Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif") {
    $message = "<p>Vous ne pouvez uploader que des images : JPG, JPEG, PNG or GIF.</p>";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "L'image n'a pas été uploadé";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $message = "<p>". basename($_FILES["fileToUpload"]["name"]). " a bien été uploadé.</p>";
        $message .= '<p><a href="./index.php?page=admin" class="button">Uploader une autre image...</a></p>';
        $message .= '<p><a href="index.php?page=galerie&category='.$upload_category.'">Aller à: '.$upload_category.'</a></p>';
        $_SESSION["selected_category"] = $upload_category;
    } else {
        $message ="<p>Erreur d'upload de fichier</p>";
    }
}

require 'gallery/templates/'.$template.'/upload_template.php';
