<!DOCTYPE html>
<html lang="<?php echo $settings['lang']; ?>">

 <head>
  <title><?php echo $settings['title']; ?></title>
  <link rel="stylesheet" href="gallery/templates/default/gallery.css">
 </head>
 <body>
  <article>
    <header><h1><?php echo $requested_category; ?></h1></header>
    <?php echo $HTML_cup; ?>
  </article>
  <footer>
   <nav>
    <ol>
    <?php if (isset($_SESSION['User_Level']) && $_SESSION['User_Level'] > 0) {
    ?>
     <li><a href="index.php?page=admin">Uploader des images</a></li>
<?php
} ?>
    </ol>
   </nav>
  </footer>
 </body>

</html>