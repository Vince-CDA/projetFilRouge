<!DOCTYPE html>
<html lang="<?php echo $settings['lang']; ?>">
<head>
 <title>Administration | <?php echo $settings['title']; ?></title>
  <link rel="stylesheet" href="gallery/templates/default/gallery.css">
  <style type="text/css">
   #Loader {display:none;position:absolute;top:140px;left:20%;width:50%;height:50%;font-size:3em;text-align:center;background:rgba(243,243,250,0.9);border-radius:15px;}
   #Loader .text {position:relative;top:36%;}
  </style>
</head>
<body>
  <article>
   <?php echo $HTML_article_content; ?>
  </article>
  <footer>
   <nav>
    <ol>
     <li><a href="index.php?page=galerie">Retour à la galerie</a></li>
    </ol>
   </nav>
  </footer>
  <div id="Loader"><div class="text"><p>Uploader...</p><div>&#x279f;&#x279f;</div></div></div>
  <script type="text/javascript">
  function uploadFile() {
	document.getElementById('Loader').style.display = "block";
    setTimeout(ulFormSubmit, 1000);
  }
  function ulFormSubmit() {
	document.getElementById('uploadForm').submit();
  }
  </script>
</body>
</html>