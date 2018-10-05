<div class="modal fade" id="<?php if(isset($identifikator)){echo $identifikator;}?>" data-backdrop="false" tabindex="-1" role="dialog"
     aria-labelledby="<?php if(isset($identifikator)){echo $identifikator;}?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><?php if(isset($titul)){echo $titul;}?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="content">
                                <form id="<?php if(isset($formular)){echo $formular;}?>" action="<?php if(isset($adresa)){echo $adresa;}?>" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Váha</label>
                                                <input type="text" id="vaha-<?php if(isset($identifikator)){echo $identifikator;}?>" name="vaha" class="form-control" placeholder="Váha">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Suma</label>
                                                <input type="text" id="suma-<?php if(isset($identifikator)){echo $identifikator;}?>" name="suma" class="form-control" placeholder="Suma">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Zrušiť</button>
                <?php
                if(isset($tlacidlo)){
                    if(strcmp($tlacidlo, "cennik_dialog_aktualizuj") == 0){
                        echo "<button type='button' class='btn btn-success' id='".$tlacidlo."'>Aktulizovať cennik</button>";
                    }else{
                        echo "<button type='button' class='btn btn-success' id='".$tlacidlo."'>Vytvoriť cennik</button>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>