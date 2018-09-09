<body>
    <div class="telo">
        <div class="logo">
            <img id="obrazok" src="<?php echo base_url() . "assets/img/"; ?>udalosti_logo.png" alt="Udalosti logo" title="Udalosti logo">
            <h1 id="nazov">Udalosti</h1>
        </div>

        <div class="formular_prihlasenie">
            <form action="<?php echo site_url('prihlasenie'); ?>" method="post">
                <input id="email_prihlasenie" type="text" name="email" placeholder="Email" />
                <input id="heslo" type="password" name="heslo" placeholder="Heslo" />
                <input id="prihlasenie" type="submit" value="Prihlásiť sa">

                <input type="hidden" name="prehliadac" value="1">
                <input type="hidden" name="pokus_o_prihlasenie" value="pokus_o_prihlasenie">
            </form>
        </div>

        <div class="formular_zabudnute_heslo">
            <form id="telo_formulara_zabudnute_heslo" action="<?php echo site_url('pomoc'); ?>">
                <input id="email_zabudnute" type="text" name="email" placeholder="Email" />
                <input id="poslat" type="submit" value="Poslať">

                <input type="hidden" name="zabudnute_heslo" value="zabudnute_heslo">
            </form>
        </div>

        <a id="zabudnute_heslo">Zabudliste heslo?</a>
    </div>