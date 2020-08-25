<?php
// Include and initialize DB class
require_once './config/DB.class.php';
$db = new DB();

// Fetch the images data
$condition = array('where' => array('status' => 1));
$images = $db->getRows('images', $condition);
?>

<div class="gallery">
    <?php
    if(!empty($images)){
        foreach($images as $row){
            $uploadDir = 'upload/images/';
            $imageURL = $uploadDir.$row["file_name"];
    ?>
    <div class="col-lg-3">
        <a href="<?php echo $imageURL; ?>" data-fancybox="gallery" data-caption="<?php echo $row["title"]; ?>" >
            <img src="<?php echo $imageURL; ?>" alt="" />
            <p><?php echo $row["title"]; ?></p>
        </a>
    </div>
    <?php }
    } ?>
</div>