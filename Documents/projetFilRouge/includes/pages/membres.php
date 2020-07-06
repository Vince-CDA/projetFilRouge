<main>
    <section class="text-center" id="team-1">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h2 class="mb-3">Dedicated &amp; Passionate Team</h2>
                    <p class="lead">Meet the Slick&apos;s crew - a dedicated and passionate team who wants to improve your experience of creating websites.</p><a class="btn btn-danger btn-capsule btn-sm my-4" href="#">Hire our team</a>
                </div>
            </div>
            <div class="row justify-content-center mt-4">
                <div class="col-lg-11">
                    <div class="row">
                        <?php

                        //la requete
                        $reponse = $bdd->query('SELECT * FROM adherent');

                        //boucle les données récupérées
                        while ($donnees = $reponse->fetch()) {

                            //le template html du membre
                        include('./includes/template/membre.php');

                        }

                        ?>
                    </div>
            </div>
    </section>
</main>