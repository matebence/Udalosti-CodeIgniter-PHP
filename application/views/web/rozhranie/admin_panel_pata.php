            <footer class="footer">
                <div class="container-fluid">
                    <p class="copyright pull-right">
                        &copy;<?php echo date("Y"); ?> <a href="<?php echo site_url("panel"); ?>">Udalosti</a>
                    </p>
                </div>
            </footer>

            </div>
        </div>
        <script src="<?php echo base_url() . "node_modules/unofficial-light-bootstrap-dashboard/"; ?>assets/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url() . "node_modules/unofficial-light-bootstrap-dashboard/"; ?>assets/js/chartist.min.js"></script>
        <script src="<?php echo base_url() . "node_modules/unofficial-light-bootstrap-dashboard/"; ?>assets/js/bootstrap-notify.js"></script>
        <script src="<?php echo base_url() . "node_modules/unofficial-light-bootstrap-dashboard/"; ?>assets/js/light-bootstrap-dashboard.js?v=1.4.0"></script>

        <script src="<?php echo base_url() . "assets/js/"; ?>panel.js"></script>
        <script src="<?php echo base_url() . "assets/js/"; ?>dialog.js"></script>

        <script>
            <?php
            if(isset($prihlaseny)){
                if($prihlaseny){
                    echo "$(document).ready(function(){";
                        echo "$.notify({";
                            echo "icon: 'pe-7s-unlock',";
                            echo "message: 'Úspešné prihlásenie! Vítame Vás <b>$email_admina</b>.'";
                    echo "},{";
                        echo "type: 'info',";
                        echo "timer: 4000";
                    echo "});";
                    echo "});";
                }
            }
            ?>
        </script>
    </body>
</html>