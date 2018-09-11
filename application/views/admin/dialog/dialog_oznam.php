<div id="dialog" class="dialog">
    <div class="dialog-obsah">
        <span class="zatvorit">&times;</span>
        <h2>Oznam</h2>
        <?php
        if(!empty(validation_errors_array())){
            foreach (validation_errors_array() as $kluc=>$hodnota ){
                echo "<p>".validation_errors_array()[$kluc]."</p>";
                break;
            }
        }else if ($this->session->flashdata('chyba') != null) {
            echo "<p>".$this->session->flashdata('chyba')."</p>";
        }else if ($this->session->flashdata('uspech') != null) {
            echo "<p>".$this->session->flashdata('uspech')."</p>";
        }
        ?>
    </div>
    <script src="<?php echo base_url() . "assets/js/"; ?>dialog.js"></script>
</div>