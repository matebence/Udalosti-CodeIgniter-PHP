<div class="modal fade" id="<?php if(isset($identifikator)){echo $identifikator;}?>" data-backdrop="false"  tabindex="-1" role="dialog" aria-labelledby="<?php if(isset($identifikator)){echo $identifikator;}?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><?php if(isset($titul)){echo $titul;}?></h4>
            </div>
            <div class="modal-body">
                <?php if(isset($text)){echo $text;}?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Zrušiť</button>
                <button type="button" class="btn btn-danger <?php if(isset($tlacidlo)){echo $tlacidlo;}?>">Áno, odstrániť</button>
            </div>
        </div>
    </div>
</div>