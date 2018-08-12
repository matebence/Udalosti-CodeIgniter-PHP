<form method="post" action="<?php echo site_url('pomoc/obnovenie_hesla'); ?>">
    <?php if (isset($email_hash)) { echo "<input type='hidden' name='email_hash' value='" . $email_hash . "'required>";}?>
    <input type="password" name="heslo" placeholder="Heslo" required>
    <input type="password" name="potvrd" placeholder="Heslo ešte raz" required>
    <input type="submit" name="nove_heslo" value="Potvrdiť" required>
</form>

<?php
$chyba = $this->session->flashdata('chyba');
$uspech = $this->session->flashdata('uspech');

if ($chyba) {
    echo $chyba;
}
if ($uspech) {
    echo $uspech;
}

echo validation_errors();
?>