<link rel="stylesheet" href="./css/style1.css" />

<?php

$postData = $imgData = array();

// récupération de la session "sessData" servant à l'ajout ou l'édition des images
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';

// Récupération du message de status de la session
if (!empty($sessData['status']['msg'])) {
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}

// Récupération des données affichés de la session
if (!empty($sessData['postData'])) {
    $postData = $sessData['postData'];
    unset($_SESSION['sessData']['postData']);
}

// Obtention des données des images
if (!empty($_GET['id'])) {
    // Inclusion du fichier de configuration
    require_once './config/DB.class.php';
    $db = new DB();
    
    $conditions['where'] = array(
        'id' => $_GET['id'],
    );
    $conditions['return_type'] = 'single';
    $imgData = $db->getRows('images', $conditions);
}

// Pre-filled data
$imgData = !empty($postData)?$postData:$imgData;

// Define action
$actionLabel = !empty($_GET['id'])?'Edit':'Add';
?>

<!-- Display status message -->
<?php if (!empty($statusMsg)) { ?>
<div class="container">    
<div class="row">
<div class="col-12">
    <div class="alert alert-<?php echo $statusMsgType; ?>"><?php echo $statusMsg; ?></div>
</div>
<?php } ?>

<div class="row">
    <div class="col-md-6 m-auto">
        <form method="post" action="./libs/postAction.php" enctype="multipart/form-data">
            <div class="form-group">
                <label>Image</label>
                <?php if (!empty($imgData['file_name'])) { ?>
                    <img src="upload/images/<?php echo $imgData['file_name']; ?>">
                <?php } ?>
                <input type="file" name="image" class="form-control">
            </div>
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control" placeholder="Enter title" value="<?php echo !empty($imgData['title'])?$imgData['title']:''; ?>" >
            </div>
            <input type="hidden" name="id" value="<?php echo !empty($imgData['id'])?$imgData['id']:''; ?>">
            <input type="submit" name="imgSubmit" class="btn btn-success" value="Envoyer la photo">
        </form>
    </div>
</div>
