
<main>
    <section id="contact-5">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6 text-center">
            <h2><?php echo $Titre ?></h2>
          </div>
          <div class="col-lg-10 mt-4">
          <form action="./index.php?page=contact" method="post">
            <form class="zform p-3 p-md-6 background-11 radius-secondary border color-9" method="post">
              <div class="row justify-content-center">
                <div class="col-md-12">
                  <div class="form-group"><input class="form-control background-white border-2x" type="hidden" name="formulaire" value="contact"></div>
                </div>
                <div class="col-md-6">
                  <div class="form-group"><label class="ls text-uppercase color-3 fw-700 mb-0" for="firstname">Prénom</label><input class="form-control background-white" id="exampleInputName1" type="text" name="firstname" required="required"></div>
                </div>
                <div class="col-md-6">
                  <div class="form-group"><label class="ls text-uppercase color-3 fw-700 mb-0" for="name">Nom</label><input class="form-control background-white" id="exampleInputName2" type="text" name="lastname" required="required"></div>
                </div>
                <div class="col-md-6">
                  <div class="form-group"><label class="ls text-uppercase color-3 fw-700 mb-0" for="exampleInputCompany">Objet</label><input class="form-control background-white" id="exampleInputCompany" type="text" name="objet" required="required"></div>
                </div>
                <div class="col-md-6">
                  <div class="form-group"><label class="ls text-uppercase color-3 fw-700 mb-0" for="exampleInputEmail1">Adresse mail</label><input class="form-control background-white" id="exampleInputEmail1" type="email" name="from" required="required"></div>
                </div>
                <div class="col-12">
                  <div class="form-group"><label class="ls text-uppercase color-3 fw-700 mb-0" for="exampleInputPassword1">Message</label><textarea class="form-control background-white" id="exampleInputPassword1" rows="8" name="message"></textarea></div>
                </div>
                <div class="col-md-6 text-center mt-4"><input class="btn btn-primary btn-block" type="submit" name="submit" value="Envoyer le message"></div>
              </div>
              <div class="zform-feedback mt-3"></div>
            </form>
          </div>
        </div>
        <!--/.row-->
      </div>
      <!--/.container-->
    </section>
  </main><!--  -->