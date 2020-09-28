            <!-- Template de ma modal avec $MonModalTexte, $MonModalBouton, $MonModalTitre -->
            <div class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $MonModalTitre ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <?php echo isset($modalhead) ? $modalhead.'<p>'.$MonModalTexte : '<p>'.$MonModalTexte; ?></p>
            </div>
            <div class="modal-bouton text-right">
                <button  <?php echo isset($modalhead) ? '' : 'type="button" ' ?> <?php echo isset($idmodal) ? ' '.$idmodal.' '.$typemodal.' ' : ' ' ?> class="btn btn-success float-right lead modalbouton"><?php echo $MonModalBouton ?></button>
            </div>
            <?php echo isset($modalfoot) ? $modalfoot : ''; ?>
        </div>
    </div>
</div>
</div>
</div>