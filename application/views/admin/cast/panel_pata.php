<footer class="footer">
    <div class="container-fluid">
        <p class="copyright pull-right">
            &copy;<?php echo date("Y"); ?> <a href="<?php echo site_url("panel"); ?>">Udalosti</a>
        </p>
    </div>
</footer>

</div>
</div>
<script src="<?php echo base_url() . "node_modules/unofficial-light-bootstrap-dashboard/"; ?>assets/js/jquery.3.2.1.min.js"></script>
<script src="<?php echo base_url() . "node_modules/unofficial-light-bootstrap-dashboard/"; ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url() . "node_modules/unofficial-light-bootstrap-dashboard/"; ?>assets/js/chartist.min.js"></script>
<script src="<?php echo base_url() . "node_modules/unofficial-light-bootstrap-dashboard/"; ?>assets/js/bootstrap-notify.js"></script>
<script src="<?php echo base_url() . "node_modules/unofficial-light-bootstrap-dashboard/"; ?>assets/js/light-bootstrap-dashboard.js?v=1.4.0"></script>
<script src="<?php echo base_url() . "assets/js/"; ?>panel.js"></script>

<script>
    $(document).ready(function(){
        $.notify({
            icon: 'pe-7s-unlock',
            message: "Úspešné prihlásenie! Vítame Vás <b><?php if(isset($email_admina)){echo $email_admina;} ?></b>."
        },{
            type: 'info',
            timer: 4000
        });
    });
</script>
</body>
</html>