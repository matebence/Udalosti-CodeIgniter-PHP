<div class="modal fade" id="<?php if(isset($identifikator)){echo $identifikator;}?>" data-backdrop="false" tabindex="-1" role="dialog"
     aria-labelledby="nova-udalost" aria-hidden="true">
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
                                <form id="nova_udalost_formular" action="<?php if(isset($adresa)){echo $adresa;}?>" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Cenník</label>
                                                <select name="cennik" class="form-control">
                                                    <option value="1">Váha 1</option>
                                                    <option value="2">Váha 2</option>
                                                    <option value="3">Váha 3</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Názov</label>
                                                <input type="text" name="nazov" class="form-control" placeholder="Názov">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Obrázok</label>
                                            <div class="input-group upload">
                                                <label class="input-group-btn">
                                                    <span class="btn btn-basic">
                                                        Prehladávať&hellip; <input type="file" name="obrazok" style="display: none;">
                                                    </span>
                                                </label>
                                                <input type="text" class="form-control" readonly title="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group dateTimePicker">
                                                <label>Dátum</label>
                                                <input id="datum" type="text" name="datum" class="form-control" placeholder="Dátum">
                                                <script>
                                                    $('#datum').datepicker({
                                                        uiLibrary: 'bootstrap4',
                                                        format: 'yyyy/mm/dd'
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group dateTimePicker">
                                                <label>Čas</label>
                                                <input id="cas" type="text" name="cas" class="form-control" placeholder="Čas">
                                                <script>
                                                    $('#cas').timepicker({
                                                        uiLibrary: 'bootstrap4'
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Miesto</label>
                                                <input type="text" name="miesto" class="form-control" placeholder="Miesto udalosti">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Štát</label>
                                                <input type="text" name="stat" class="form-control" placeholder="Štát">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Okres</label>
                                                <input type="text" name="okres" class="form-control" placeholder="Okres">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Mesto</label>
                                                <input type="text" name="mesto" class="form-control" placeholder="Mesto">
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
                <button type="button" class="btn btn-success" id="udalost_dialog">Vytvoriť udalosť</button>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url() . "assets/js/"; ?>dialog.js"></script>