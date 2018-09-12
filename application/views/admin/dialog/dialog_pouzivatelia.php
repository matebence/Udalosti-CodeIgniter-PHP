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
                                                <label>Meno</label>
                                                <input type="text" id="meno-<?php if(isset($identifikator)){echo $identifikator;}?>" name="meno" class="form-control" placeholder="Meno">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="text" id="email-<?php if(isset($identifikator)){echo $identifikator;}?>" name="email" class="form-control" placeholder="Email">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Heslo</label>
                                                <input type="password" id="heslo-<?php if(isset($identifikator)){echo $identifikator;}?>" name="heslo" class="form-control" placeholder="Heslo">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Potvrdenie hesla</label>
                                                <input type="password" id="potvrd-<?php if(isset($identifikator)){echo $identifikator;}?>" name="potvrd" class="form-control" placeholder="Potvrdenie hesla">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Rola</label>
                                                <select id="rola-<?php if(isset($identifikator)){echo $identifikator;}?>" name="rola" class="form-control">
                                                    <option value="pouzivatel">Používatel</option>
                                                    <option value="admin">Administrátor</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="nova_registracia" value="1">
                                    <input type="hidden" name="prehliadac" value="1">
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
                    if(strcmp($tlacidlo, "udalost_dialog_aktualizuj") == 0){
                        echo "<button type='button' class='btn btn-success' id='".$tlacidlo."'>Aktulizovať používatela</button>";
                    }else{
                        echo "<button type='button' class='btn btn-success' id='".$tlacidlo."'>Vytvoriť používatela</button>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>