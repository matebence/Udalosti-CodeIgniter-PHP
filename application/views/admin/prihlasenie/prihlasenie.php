<body>
    <div class="telo">
        <div class="logo">
            <div class="logo-stred">
                <img id="obrazok" src="<?php echo base_url() . "assets/img/"; ?>udalosti_logo.png" alt="Udalosti logo" title="Udalosti logo">
                <h1 id="nazov">Udalosti</h1>
            </div>
        </div>

        <div class="formular_prihlasenie">
            <form id="telo_formulara_prihlasenie" action="<?php echo site_url('prihlasenie'); ?>" method="post">
                <input id="email_prihlasenie" type="email" name="email" placeholder="Email" autofocus/>
                <input id="heslo" type="password" name="heslo" placeholder="Heslo" />
                <input id="prihlasenie" type="submit" value="Prihlásiť sa">

                <input type="hidden" name="prehliadac" value="1">
                <input type="hidden" name="pokus_o_prihlasenie" value="pokus_o_prihlasenie">
            </form>
        </div>

        <div class="formular_registracia">
            <form id="telo_formulara_registracia" action="<?php echo site_url('registracia'); ?>">
                <input id="registracia_meno" type="text" name="meno" placeholder="Meno"/>
                <input id="registracia_email" type="email" name="email" placeholder="Email"/>
                <input id="registracia_heslo" type="password" name="heslo" placeholder="Heslo"/>
                <input id="registracia_potvrd" type="password" name="potvrd" placeholder="Potvrdenie hesla"/>
                <input id="registrovat" type="submit" value="Registrovať">

                <input type="hidden" name="prehliadac" value="1">
                <input type="hidden" name="rola" value="<?php echo  ORGANIZATOR; ?>">
                <input type="hidden" name="nova_registracia" value="novy_organizator">
            </form>
        </div>

        <div class="formular_zabudnute_heslo">
            <form id="telo_formulara_zabudnute_heslo" action="<?php echo site_url('pomoc'); ?>">
                <input id="email_zabudnute" type="email" name="email" placeholder="Email"/>
                <input id="poslat" type="submit" value="Poslať">

                <input type="hidden" name="zabudnute_heslo" value="zabudnute_heslo">
            </form>
        </div>

        <a id="registracia">Registrácia</a>
        <a id="oddelovac">|</a>
        <a id="zabudnute_heslo">Zabudnuté heslo</a>
    </div>