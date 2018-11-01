<div class="alert alert-danger" role="alert">
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
    ?>
</div>