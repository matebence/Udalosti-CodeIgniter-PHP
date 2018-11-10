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
                                                <label>Cenník</label>
                                                <select id="cennik-<?php if(isset($identifikator)){echo $identifikator;}?>" name="cennik" class="form-control">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Názov</label>
                                                <input type="text" id="nazov-<?php if(isset($identifikator)){echo $identifikator;}?>" name="nazov" class="form-control" placeholder="Názov">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Štát</label>
                                                <input type="text" id="stat-<?php if(isset($identifikator)){echo $identifikator;}?>" class="form-control" value="Slovensko" disabled>
                                                <input type="hidden" name="stat" value="Slovensko">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Okres</label>
                                                <input type="text" id="okres-<?php if(isset($identifikator)){echo $identifikator;}?>" name="okres" class="form-control" placeholder="Okres">
                                                <ul class="list-group" id="okresy"></ul>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Mesto</label>
                                                <input type="text" id="mesto-<?php if(isset($identifikator)){echo $identifikator;}?>" name="mesto" class="form-control" placeholder="Mesto">
                                                <ul class="list-group" id="mesta-obce"></ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Obrázok</label>
                                            <div class="input-group upload">
                                                <label class="input-group-btn">
                                                    <span class="btn btn-basic obrazok_udalosti_pozicia">
                                                        Prehladávať&hellip; <input class="obrazok_udalosti" type="file" name="obrazok" style="display: none;">
                                                    </span>
                                                </label>
                                                <input type="text" id="obrazok_udalosti-<?php if(isset($identifikator)){echo $identifikator;}?>" class="form-control" readonly title="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group dateTimePicker">
                                                <label>Dátum</label>
                                                <input id="datum-<?php if(isset($identifikator)){echo $identifikator;}?>" type="text" name="datum" class="form-control" placeholder="Dátum">
                                                <script>
                                                    $('#datum-<?php if(isset($identifikator)){echo $identifikator;}?>').datepicker({
                                                        uiLibrary: 'bootstrap4',
                                                        format: 'yyyy/mm/dd'
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group dateTimePicker">
                                                <label>Čas</label>
                                                <input id="cas-<?php if(isset($identifikator)){echo $identifikator;}?>" type="text" name="cas" class="form-control" placeholder="Čas">
                                                <script>
                                                    $('#cas-<?php if(isset($identifikator)){echo $identifikator;}?>').timepicker({
                                                        uiLibrary: 'bootstrap4'
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Ulica</label>
                                                <input type="text" id="ulica-<?php if(isset($identifikator)){echo $identifikator;}?>" name="ulica" class="form-control" placeholder="Miesto udalosti">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Vstupenka</label>
                                                <input type="text" id="vstupenka-<?php if(isset($identifikator)){echo $identifikator;}?>" name="vstupenka" class="form-control" placeholder="Cena vstupenky">
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
                    if(strcmp($tlacidlo, "udalost_dialog_aktualizuj") == 0){
                        echo "<button type='button' class='btn btn-success' id='".$tlacidlo."'>Aktulizovať udalosť</button>";
                    }else{
                        echo "<button type='button' class='btn btn-success' id='".$tlacidlo."'>Vytvoriť udalosť</button>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>