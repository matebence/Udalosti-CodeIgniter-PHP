<div id="dialog" class="dialog">
    <div class="dialog-obsah">
        <span class="zatvorit">&times;</span>
        <h2>Oznam</h2>
        <?php
        if (isset(validation_errors_array()["email"])) {
            echo "<p>".validation_errors_array()["email"]."</p>";
        }else if (isset(validation_errors_array()["heslo"])) {
            echo "<p>".validation_errors_array()["heslo"]."</p>";
        }else if (isset(validation_errors_array()["potvrd"])) {
            echo "<p>".validation_errors_array()["potvrd"]."</p>";
        }else if ($this->session->flashdata('chyba') != null) {
            echo "<p>".$this->session->flashdata('chyba')."</p>";
        }else if ($this->session->flashdata('uspech') != null) {
            echo "<p>".$this->session->flashdata('uspech')."</p>";
        }
        ?>
</div>
</div>
<script src="<?php echo base_url() . "node_modules/jquery/dist/"; ?>jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/js/"; ?>dialog.js"></script>
<footer class="pata">
    <p>©<?php echo date("Y"); ?> Udalosti</p>
</footer>
</body>
</html>