<link href="./css/style1.css" rel="stylesheet">

<?php
// Include and initialize DB class
require_once './config/DB.class.php';
$db = new DB();

// Fetch the images data
$condition = array('where' => array('status' => 1));
$images = $db->getRows('images', $condition);
?>
    <?php
    if(!empty($images)){
        foreach($images as $row){
            $uploadDir = 'upload/images/';
            $imageURL = $uploadDir.$row["file_name"];
    ?>
    <div class="background-holder overlay overlay-0" style="background-image:url(./images/38.jpg);"></div>
    <!--/.background-holder-->
    </div>
    <div class="row gallery container col-lg-8">
        <a href="<?php echo $imageURL; ?>" data-fancybox="gallery" data-caption="<?php echo $row["title"]; ?>" >
            <img src="<?php echo $imageURL; ?>" alt="" />
            <p><?php echo $row["title"]; ?></p>
        </a>
    </div>
    <?php }
    } ?>
</div>