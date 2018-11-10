<?php if((empty(validation_errors_array())) && (strcmp($ikona, "pe-7s-check") == 0)){
    echo "<p style='display: none'>uspech</p>";
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