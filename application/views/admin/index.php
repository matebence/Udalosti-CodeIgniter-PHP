<!DOCTYPE html>
<html>
    <head>
        <title>Udalosti</title>
        <link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url() . "assets/img/favicon/"; ?>apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url() . "assets/img/favicon/"; ?>apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url() . "assets/img/favicon/"; ?>apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url() . "assets/img/favicon/"; ?>apple-icon-76x76.png">

        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url() . "assets/img/favicon/"; ?>apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url() . "assets/img/favicon/"; ?>apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url() . "assets/img/favicon/"; ?>apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url() . "assets/img/favicon/"; ?>apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url() . "assets/img/favicon/"; ?>apple-icon-180x180.png">

        <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo base_url() . "assets/img/favicon/"; ?>android-icon-192x192.png">

        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url() . "assets/img/favicon/"; ?>favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url() . "assets/img/favicon/"; ?>favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url() . "assets/img/favicon/"; ?>favicon-16x16.png">

        <link rel="manifest" href="<?php echo base_url() . "assets/img/favicon/"; ?>manifest.json">

        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">

        <meta name="theme-color" content="#ffffff">

        <link rel="stylesheet" type="text/css" href="<?php echo base_url() . "assets/css/"; ?>prihlasenie.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <body>
        <div class="prihlasovanie">
            <div class="logo">
                <img id="obrazok" src="<?php echo base_url() . "assets/img/"; ?>udalosti_logo.png" alt="Udalosti logo" title="Udalosti logo">
                <h1 id="nazov">Udalosti</h1>
            </div>

            <div class="formular">
                <form action="<?php echo site_url('prihlasenie/prihlasit_sa'); ?>">
                    <input type="text" name="email" placeholder="Email" />
                    <input type="password" name="heslo" placeholder="Heslo" />
                    <input type="submit" name="pokus_o_prihlasenie" value="Prihlásiť sa">
                </form>
            </div>

            <div class="zabudnuteHeslo">
                <form action="<?php echo site_url('prihlasenie/prihlasit_sa'); ?>">
                    <input type="text" name="email" placeholder="Email" />
                    <input type="submit" name="pokus_o_prihlasenie" value="Poslať">
                </form>
            </div>

            
        </div>
        <footer class="pata">
            <p>©2018 Udalosti</p>
        </footer>
    </body>
</html>