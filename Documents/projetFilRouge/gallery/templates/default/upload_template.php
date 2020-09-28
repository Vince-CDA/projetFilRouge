<!DOCTYPE html>
<html>

 <head>
  <title><?php echo $settings['title']; ?></title>
  <link rel="stylesheet" href="gallery/templates/default/gallery.css">
 </head>

 <body>
  <header id="site_header">
   <img src="icon_1.png" alt="">
   <h1><?php echo $settings['title']; ?></h1>
   <nav>
    <ol>
     <li><a href="./page-galerie">Accueil galerie</a></li>
    </ol>
   </nav>
   <div class="clear"></div>
  </header>
  <article>
    <?php echo $message; ?>
  </article>
  <footer>
   <nav>
    <ol>
     <li><a href="index.php?page=galerie">Revenir à la galerie</a></li>
    </ol>
   </nav>
  </footer>
 </body>

</html>