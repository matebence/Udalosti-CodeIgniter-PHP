<?php

if ($this->session->flashdata('uspech') != null) {
    echo "<div id='dialog' class='alert alert-success' role='alert'>";
}else{
    echo "<div id='dialog' class='alert alert-danger' role='alert'>";
}
?>

    <h4 class="alert-heading">Oznam</h4>
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

    $this->session->set_flashdata('uspech', null);
    $this->session->set_flashdata('chyba', null);
    ?>
</div>