
<main>
    <section id="contact-5">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6 text-center">
            <h2><?php echo $Titre ?></h2>
          </div>
          <div class="col-lg-10 mt-4">
          <form action="page-contact" method="post">
            <form class="zform p-3 p-md-6 background-11 radius-secondary border color-9" method="post">
              <div class="row justify-content-center">
                <div class="col-md-12">
                  <div class="form-group"><input class="form-control background-white border-2x" type="hidden" name="formulaire" value="contact"></div>
                </div>
                <div class="col-md-6">
                  <div class="form-group"><label class="ls text-uppercase color-3 fw-700 mb-0">Prénom</label><input class="form-control background-white" type="text" name="firstname" required="required"></div>
                </div>
                <div class="col-md-6">
                  <div class="form-group"><label class="ls text-uppercase color-3 fw-700 mb-0">Nom</label><input class="form-control background-white"  type="text" name="lastname" required="required"></div>
                </div>
                <div class="col-md-6">
                  <div class="form-group"><label class="ls text-uppercase color-3 fw-700 mb-0">Objet</label><input class="form-control background-white" type="text" name="objet" required="required"></div>
                </div>
                <div class="col-md-6">
                  <div class="form-group"><label class="ls text-uppercase color-3 fw-700 mb-0">Adresse mail</label><input class="form-control background-white" type="email" name="from" required="required"></div>
                </div>
                <div class="col-12">
                  <div class="form-group"><label class="ls text-uppercase color-3 fw-700 mb-0">Message</label><textarea class="form-control background-white" rows="8" name="message"></textarea></div>
                </div>
                <div class="g-recaptcha col-6" data-sitekey="6LfVpssZAAAAALskuUcMWYxfZ-WYY2hOxIJi4cxr"></div>
                <div class="col-md-6 text-center mt-4"><input class="btn btn-primary btn-block" type="submit" name="submit" value="Envoyer le message"></div>
              </div>
              <div class="zform-feedback mt-3"></div>
            </form>
          </div>
        </div>
        <div id="map"></div>
        <!--/.row-->
      </div>
      <!--/.container-->
    </section>
  </main><!--  -->