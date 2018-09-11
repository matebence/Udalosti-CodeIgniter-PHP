<?php if((empty(validation_errors_array())) && (strcmp($oznam, "Udalosť bola vytvorená") == 0)){
    echo "uspech";
}
?>

<script type="text/javascript">
    $(document).ready(function(){
        $.notify({
            icon: '<?php if(isset($ikona)){ echo $ikona;} ?>',
            <?php
            if(!empty(validation_errors_array())){
                foreach (validation_errors_array() as $kluc=>$hodnota ){
                    echo "message: '".validation_errors_array()[$kluc]."'";
                    break;
                }
            }else if(isset($oznam)){
                echo "message: '".$oznam."'";
            }
            ?>
        },{
            type: '<?php if(isset($typ)){ echo $typ;} ?>',
            timer: 2000
        });
    });
</script>