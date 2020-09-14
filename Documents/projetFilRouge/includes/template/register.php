
            <!-- Formulaire d'inscription et d'édition de profil, ternaire pour afficher ls informations si celles-ci existent (donc si l'utilisateur est connecté), cas contraire : C'est une inscription -->
<section class="py-0" id="forms-1">
    <div class="background-holder overlay overlay-0" style="background-image:url(./images/38.jpg);"></div>
    <!--/.background-holder-->
    <div class="container">
        <div class="row h-full align-items-center justify-content-center py-5">
            <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5">
                <div class="tabs background-white radius-secondary pb-4">
                    <div class="tab-contents px-5">
                        <div class="tab-content active">
                            <form action="page-<?php echo $MaPage ?><?php echo isset($Id) ? '-'.$Id : ''; ?>" method="post" class="register-form" enctype="multipart/form-data">
                                <h1 id="bandeau" class="lead bold h1 pb-4 text-center"><b><?php echo $Titre ?></b></h1>
                                <input type="hidden" name="formulaire" value="<?php echo $Action; ?>" />
                                <input type="hidden" name="IdAdherent" value="<?php echo isset($Id) ? $Id : ''; ?>" />
                                <div class="row text-center">
                                <div class="col-lg-12 mb-2">
                                    <?php
                                    //L'image profil sera par défaut upload_photo_default.jpg ($img) dans le $directory_img_upload
                                    $img = !empty($image) ? $image : 'upload_photo_default.jpg';
                                    ?>
                                    <div class="col-lg-12 text-center">
                                    <img src="<?php echo $directory_img_upload.$img; ?>" alt="">
                                </div>
                                        <input class="mt-2" type="file" name="image" />

                                    </div>
                                    <div class="col-lg-6">
                                        <label class="py-0 mb-0" for="name">Identifiant</label>
                                        <br /><input size="16" type="text" id="login" name="Login" value="<?php echo isset($Identifiant) ? $Identifiant : '' ?>" placeholder="" required />
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="py-0 mb-0"  for="name">Mot de passe</label>
                                        <br /><input size="16" type="password" id="password" name="Password" value="" placeholder="" required />
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="py-0 mb-0"  for="name">Prénom</label>
                                        <br /><input size="16" type="text" id="firstname" name="Prenom" value="<?php echo isset($Prenom) ? $Prenom : '' ?>" placeholder="" required />
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="py-0 mb-0"  for="name">Nom</label>
                                        <br /><input size="16" type="text" id="name" name="Nom" value="<?php echo isset($Nom) ? $Nom : '' ?>" required />
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="py-0 mb-0"  for="name">Date de naissance</label>
                                        <br /><input size="16" type="date" id="birth" name="DNaiss" value="<?php echo isset($DateNaiss) ? $DateNaiss : '' ?>" required />
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="py-0 mb-0"  for="name">Adresse</label>
                                        <br /><input size="16" type="text" id="adress" name="Adresse1" value="<?php echo isset($Adresse) ? $Adresse : '' ?>" required />
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="py-0 mb-0"  for="cp">CP</label>
                                        <br /><input size="16" type="text" id="zip" name="CdPost" value="<?php echo isset($CodeP) ? $CodeP : '' ?>" required />
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="py-0 mb-0"  for="name">Ville</label>
                                        <br /><input size="16" type="text" id="city" name="Ville" value="<?php echo isset($Ville) ? $Ville : '' ?>" required />
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="py-0 mb-0"  for="email">Email</label>
                                        <br /><input size="16" type="email" id="email" name="Email" value="<?php echo isset($Email) ? $Email : '' ?>" required />
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="py-0 mb-0"  for="mobile">Téléphone</label>
                                        <br /><input size="16" type="text" id="mobile" name="Tel" value="<?php echo isset($Tel) ? $Tel : '' ?>" required />
                                    </div>
                                    <div class="col-lg-12">
                                        <label class="py-0 mb-0"  for="mobile">Votre cylindrée</label>
                                    </div>
                                    <div class="col-lg-12">
                                        <input type="radio" name="CC" value="125 cm3" <?php echo isset($CC) && $CC == "125 cm3" ? 'checked' : '';  ?>/>
                                        <label  for="mobile">125 cm3</label>
                                        <input type="radio" name="CC" value="250 cm3" <?php echo isset($CC) && $CC == "250 cm3" ? 'checked' : '';  ?>/>
                                        <label  for="mobile">250 cm3</label>
                                        <input type="radio" name="CC" value="> 250 cm3" <?php echo isset($CC) && $CC == "> 250 cm3" ? 'checked' : '';  ?>/>
                                        <label  for="mobile">> 250 cm3</label>
                                        <input type="radio" name="CC" value="aucune" <?php echo isset($CC) && $CC == "aucune" ? 'checked' : '';  ?>/>
                                        <label  for="mobile">aucune</label>
                                    </div>
                                    <div class="col-lg-12">
                                        <label class="py-0 mb-0"  for="mobile">En vous inscrivant, vous acceptez que votre image soit utilisée sur le site internet</label>
                                    </div>
                                <div class="g-recaptcha" data-sitekey="6LfVpssZAAAAALskuUcMWYxfZ-WYY2hOxIJi4cxr" ></div>
                                </div>
                                <button type="submit" class="btn btn-success float-right lead"><?php echo $Btn_Register; ?></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/.row-->
    </div>
    <!--/.container-->
</section>