<body>
    <div class="prihlasovanie">
        <div class="logo">
            <img id="obrazok" src="<?php echo base_url() . "assets/img/"; ?>udalosti_logo.png" alt="Udalosti logo" title="Udalosti logo">
            <h1 id="nazov">Udalosti</h1>
        </div>

        <div class="formular_prihlasenie">
            <form action="<?php echo site_url(''); ?>" method="post">
                <input id="email_prihlasenie" type="text" name="email" placeholder="Email" />
                <input id="heslo" type="password" name="heslo" placeholder="Heslo" />
                <input type="hidden" name="prehliadac" value="1">
                <input id="prihlasenie" type="submit" name="pokus_o_prihlasenie" value="Prihlásiť sa">
            </form>
        </div>

        <div class="formular_zabudnute_heslo">
            <form id="zabudnute_heslo_formular" action="<?php echo site_url('pomoc'); ?>">
                <input id="email_zabudnute" type="text" name="email" placeholder="Email" />
                <input type="hidden" name="zabudnute_heslo" value="heslo">
                <input id="poslat" type="submit" value="Poslať">
            </form>
        </div>

        <a id="zabudnute_heslo">Zabudliste heslo?</a>
    </div>