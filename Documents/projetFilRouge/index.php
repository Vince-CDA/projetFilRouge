<?php

/* J'inclus mon fichier config avec mes logins de base de données local */

include('./config/config.php');

/* J'inclus les méthodes POST */

include('./libs/methode_post.php');

/* J'inclus les méthodes GET */

include ('./libs/methode_get.php');

/* J'inclus le header de mon site */

include './includes/layout/header.php';

/* J'inclus le corps de ma page */

include './includes/pages/'.$mapage.'.php';

/* J'inclus le footer de mon site */

include './includes/layout/footer.php';
