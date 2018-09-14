<body>
<div class="telo">
    <div class="logo">
        <img id="obrazok" src="<?php echo base_url() . "assets/img/"; ?>udalosti_logo.png" alt="Udalosti logo" title="Udalosti logo">
        <h1 id="nazov">Udalosti</h1>
    </div>

    <div class="formular_obnovenie_hesla">
        <form id="telo_formulara_obnovenie_hesla" action="<?php echo site_url('pomoc/obnovenie_hesla'); ?>" method="post">
            <input id="heslo" type="password" name="heslo" placeholder="Nové heslo" autofocus/>
            <input id="potvrd" type="password" name="potvrd" placeholder="Potvrdenie Hesla" />
            <input id="prihlasenie" type="submit" value="Poslať">

            <input type="hidden" name="prehliadac" value="1">
            <input type="hidden" name="nove_heslo" value="nove_heslo">
            <?php if (isset($email_hash)) { echo "<input type='hidden' name='email_hash' value='" . $email_hash . "'required>";}?>
        </form>
    </div>
</div>