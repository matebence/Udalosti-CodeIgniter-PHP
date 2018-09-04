<body>
<div class="prihlasovanie">
    <div class="logo">
        <img id="obrazok" src="<?php echo base_url() . "assets/img/"; ?>udalosti_logo.png" alt="Udalosti logo" title="Udalosti logo">
        <h1 id="nazov">Udalosti</h1>
    </div>

    <div class="formular_prihlasenie">
        <form id="zabudnute_heslo_formular" action="<?php echo site_url('pomoc/obnovenie_hesla'); ?>" method="post">
            <input id="heslo" type="password" name="heslo" placeholder="Nové heslo" />
            <input id="potvrd" type="password" name="potvrd" placeholder="Potvrdenie Hesla" />
            <input type="hidden" name="prehliadac" value="1">
            <input type="hidden" name="nove_heslo" value="heslo">
            <input id="prihlasenie" type="submit" name="nove_heslo" value="Poslať">
        </form>
    </div>
</div>