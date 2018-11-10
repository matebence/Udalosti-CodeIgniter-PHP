<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Panel extends CI_Controller
{
    private $data = array();

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Pouzivatel_model');
        $this->load->model('Rola_pouzivatela_model');
        $this->load->model('Udalost_model');
        $this->load->model('Cennik_model');
        $this->load->model('Zaujem_model');
        $this->load->model('Miesto_model');
    }

    public function index()
    {
        $this->panel();
    }

    private function panel()
    {
        if ($this->session->userdata('email_admina')) {

            $spravy = $this->Udalost_model->pocet_sprav();
            $pocet_sprav = 0;

            if(isset($spravy[0])){
                $pocet_sprav += $spravy[0]["Pocet"];

                if($spravy[0]["Pocet"] > 0) {
                    $this->pridaj_data("udalosti_spravy", $spravy[0]["Pocet"] . "x nové udalosti");
                }
            }
            if(isset($spravy[1])){
                $pocet_sprav += $spravy[1]["Pocet"];

                if($spravy[1]["Pocet"] > 0){
                    $this->pridaj_data("organizatory_spravy", $spravy[1]["Pocet"]. "x nové organizátori");
                }
            }

            $this->pridaj_data("email_admina", $this->session->userdata('email_admina'));
            $this->pridaj_data("spravy", $pocet_sprav);

            $this->uspesne_prihlasenie();
            $this->dlazdice("pocet_pouzivatelov", "pocet_organizatorov", "pocet_administratorov", "pocet_udalosti", "aktivny_pouzivatelia", "registrovali_dnes");

            $this->load->view("web/rozhranie/panel_hlavicka");
            $this->load->view("web/rozhranie/admin_panel_navigacia", $this->data);
            $this->load->view("web/panel/admin_panel", $this->data);

            $this->dialog(site_url('udalosti/vytvorit'),"Nová udalosť", "", "nova-udalost", "udalost_dialog_vytvorit", "nova_udalost_formular", "dialog_udalosti");

            $this->load->view("web/rozhranie/admin_panel_pata");
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    public function udalosti()
    {
        if ($this->session->userdata('email_admina')) {

            $spravy = $this->Udalost_model->pocet_sprav();
            $pocet_sprav = 0;

            if(isset($spravy[0])){
                $pocet_sprav += $spravy[0]["Pocet"];

                if($spravy[0]["Pocet"] > 0) {
                    $this->pridaj_data("udalosti_spravy", $spravy[0]["Pocet"] . "x nové udalosti");
                }
            }
            if(isset($spravy[1])){
                $pocet_sprav += $spravy[1]["Pocet"];

                if($spravy[1]["Pocet"] > 0){
                    $this->pridaj_data("organizatory_spravy", $spravy[1]["Pocet"]. "x nové organizátori");
                }
            }

            $this->pridaj_data("nepotvrdene_udalosti", $this->Udalost_model->zoznam(NEPRECITANE));
            $this->pridaj_data("aktualne_udalosti", $this->Udalost_model->zoznam(PRIJATE));
            $this->pridaj_data("odmietnute_udalosti", $this->Udalost_model->zoznam(ODMIETNUTE));
            $this->pridaj_data("spravy", $pocet_sprav);

            $this->load->view("web/rozhranie/panel_hlavicka");
            $this->load->view("web/rozhranie/admin_panel_navigacia", $this->data);
            $this->load->view("web/panel/admin_panel_udalosti", $this->data);

            $this->dialog(site_url('udalosti/vytvorit'),"Nová udalosť", "", "nova-udalost", "udalost_dialog_vytvorit", "nova_udalost_formular", "dialog_udalosti");
            $this->dialog(site_url('udalosti/aktualizuj'),"Aktualizovanie udalosti", "", "aktualizovat-udalost", "udalost_dialog_aktualizuj", "aktulizovat_udalost_formular", "dialog_udalosti");
            $this->dialog(site_url('udalosti/odstran'),"Odstránenie udalosti", "Naozaj chcete odstrániť udalosť?", "odstranit-udalost", "udalost_dialog_odstranit", "", "dialog_potvrdit");
            $this->dialog(site_url('udalosti/prijat'),"Potvrdenie udalosti", "Naozaj chcete pridať udalosť do aktuálnych udalosti?", "prijat-udalost", "udalost_dialog_prijat", "", "dialog_potvrdit");
            $this->dialog(site_url('udalosti/odmietnut'),"Odmietnutie udalosti", "Naozaj chcete odobrať udalosť z aktuálnych udalosti?", "odmietnut-udalost", "udalost_dialog_odmietnut", "", "dialog_potvrdit");

            $this->load->view("web/rozhranie/admin_panel_pata");
        } else if($this->session->userdata('email_organizatora')){

            $this->pridaj_data("email_organizatora", $this->session->userdata('email_organizatora'));

            $this->uspesne_prihlasenie();

            $this->load->view("web/rozhranie/panel_hlavicka");
            $this->load->view("web/rozhranie/organizator_panel_navigacia");
            $this->load->view("web/rozhranie/organizator_panel_pata", $this->data);
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    public function pouzivatelia()
    {
        if ($this->session->userdata('email_admina')) {

            $spravy = $this->Udalost_model->pocet_sprav();
            $pocet_sprav = 0;

            if(isset($spravy[0])){
                $pocet_sprav += $spravy[0]["Pocet"];

                if($spravy[0]["Pocet"] > 0) {
                    $this->pridaj_data("udalosti_spravy", $spravy[0]["Pocet"] . "x nové udalosti");
                }
            }
            if(isset($spravy[1])){
                $pocet_sprav += $spravy[1]["Pocet"];

                if($spravy[1]["Pocet"] > 0){
                    $this->pridaj_data("organizatory_spravy", $spravy[1]["Pocet"]. "x nové organizátori");
                }
            }

            $this->pridaj_data("zoznam_pouzivatelov", $this->Rola_pouzivatela_model->zoznam_pouzivatelov());
            $this->pridaj_data("spravy", $pocet_sprav);

            $this->load->view("web/rozhranie/panel_hlavicka");
            $this->load->view("web/rozhranie/admin_panel_navigacia", $this->data);
            $this->load->view("web/panel/admin_panel_pouzivatelia", $this->data);

            $this->dialog(site_url('udalosti/vytvorit'),"Nová udalosť", "", "nova-udalost", "udalost_dialog_vytvorit", "nova_udalost_formular", "dialog_udalosti");

            $this->dialog(site_url('registracia/vytvorit'),"Nový používateľ", "", "novy-pouzivatel", "pouzivatel_dialog_vytvorit", "novy_pouzivatel_formular", "dialog_pouzivatel");
            $this->dialog(site_url('pouzivatelia/aktualizuj'),"Aktualizovať používateľa", "", "aktualizovat-pouzivatel", "pouzivatel_dialog_aktualizuj", "aktulizovat_pouzivatel_formular", "dialog_pouzivatel");
            $this->dialog(site_url('pouzivatelia/odstran'),"Odstránenie používateľa", "Naozaj chcete odstrániť používateľa?", "odstranit-pouzivatel", "pouzivatel_dialog_odstranit", "", "dialog_potvrdit");
            $this->dialog(site_url('pouzivatelia/akceptovat'),"Akceptovanie používateľa", "Naozaj chcete akceptovať používateľa?", "akceptovat-pouzivatel", "pouzivatel_dialog_akceptovat", "", "dialog_potvrdit");
            $this->dialog(site_url('pouzivatelia/blokovat'),"Blokovanie používateľa", "Naozaj chcete blokovať používateľa?", "blokovat-pouzivatel", "pouzivatel_dialog_blokovat", "", "dialog_potvrdit");

            $this->load->view("web/rozhranie/admin_panel_pata");
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    public function cennik()
    {
        if ($this->session->userdata('email_admina')) {

            $spravy = $this->Udalost_model->pocet_sprav();
            $pocet_sprav = 0;

            if(isset($spravy[0])){
                $pocet_sprav += $spravy[0]["Pocet"];

                if($spravy[0]["Pocet"] > 0) {
                    $this->pridaj_data("udalosti_spravy", $spravy[0]["Pocet"] . "x nové udalosti");
                }
            }
            if(isset($spravy[1])){
                $pocet_sprav += $spravy[1]["Pocet"];

                if($spravy[1]["Pocet"] > 0){
                    $this->pridaj_data("organizatory_spravy", $spravy[1]["Pocet"]. "x nové organizátori");
                }
            }

            $this->pridaj_data("zoznam_cien", $this->Cennik_model->zoznam());
            $this->pridaj_data("spravy", $pocet_sprav);

            $this->load->view("web/rozhranie/panel_hlavicka");
            $this->load->view("web/rozhranie/admin_panel_navigacia", $this->data);
            $this->load->view("web/panel/admin_panel_cennik", $this->data);

            $this->dialog(site_url('udalosti/vytvorit'),"Nová udalosť", "", "nova-udalost", "udalost_dialog_vytvorit", "nova_udalost_formular", "dialog_udalosti");

            $this->dialog(site_url('cennik/vytvorit'),"Nový cenník", "", "novy-cennik", "cennik_dialog_vytvorit", "novy_cennik_formular", "dialog_cennik");
            $this->dialog(site_url('cennik/odstran'),"Odstránenie cenníka", "Naozaj chcete odstrániť cenník?", "odstranit-cennik", "cennik_dialog_odstranit", "", "dialog_potvrdit");
            $this->dialog(site_url('cennik/aktualizuj'),"Aktualizovať cenník", "", "aktualizovat-cennik", "cennik_dialog_aktualizuj", "aktulizovat_cennik_formular", "dialog_cennik");

            $this->load->view("web/rozhranie/admin_panel_pata");
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    public function zaujmy()
    {
        if ($this->session->userdata('email_admina')) {

            $spravy = $this->Udalost_model->pocet_sprav();
            $pocet_sprav = 0;

            if(isset($spravy[0])){
                $pocet_sprav += $spravy[0]["Pocet"];

                if($spravy[0]["Pocet"] > 0) {
                    $this->pridaj_data("udalosti_spravy", $spravy[0]["Pocet"] . "x nové udalosti");
                }
            }
            if(isset($spravy[1])){
                $pocet_sprav += $spravy[1]["Pocet"];

                if($spravy[1]["Pocet"] > 0){
                    $this->pridaj_data("organizatory_spravy", $spravy[1]["Pocet"]. "x nové organizátori");
                }
            }

            $this->pridaj_data("zaujmy", $this->Zaujem_model->zoznam());
            $this->pridaj_data("spravy", $pocet_sprav);

            $this->load->view("web/rozhranie/panel_hlavicka");
            $this->load->view("web/rozhranie/admin_panel_navigacia", $this->data);
            $this->load->view("web/panel/admin_panel_zaujmy", $this->data);

            $this->dialog(site_url('udalosti/vytvorit'),"Nová udalosť", "", "nova-udalost", "udalost_dialog_vytvorit", "nova_udalost_formular", "dialog_udalosti");

            $this->load->view("web/rozhranie/admin_panel_pata");
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    public function miesta()
    {
        if ($this->session->userdata('email_admina')) {

            $spravy = $this->Udalost_model->pocet_sprav();
            $pocet_sprav = 0;

            if(isset($spravy[0])){
                $pocet_sprav += $spravy[0]["Pocet"];

                if($spravy[0]["Pocet"] > 0) {
                    $this->pridaj_data("udalosti_spravy", $spravy[0]["Pocet"] . "x nové udalosti");
                }
            }
            if(isset($spravy[1])){
                $pocet_sprav += $spravy[1]["Pocet"];

                if($spravy[1]["Pocet"] > 0){
                    $this->pridaj_data("organizatory_spravy", $spravy[1]["Pocet"]. "x nové organizátori");
                }
            }

            $this->pridaj_data("miesta", $this->Miesto_model->zoznam());
            $this->pridaj_data("spravy", $pocet_sprav);

            $this->load->view("web/rozhranie/panel_hlavicka");
            $this->load->view("web/rozhranie/admin_panel_navigacia", $this->data);
            $this->load->view("web/panel/admin_panel_miesta", $this->data);

            $this->dialog(site_url('udalosti/vytvorit'),"Nová udalosť", "", "nova-udalost", "udalost_dialog_vytvorit", "nova_udalost_formular", "dialog_udalosti");

            $this->load->view("web/rozhranie/admin_panel_pata");
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    public function lokalizacia()
    {
        if ($this->session->userdata('email_admina')) {

            $spravy = $this->Udalost_model->pocet_sprav();
            $pocet_sprav = 0;

            if(isset($spravy[0])){
                $pocet_sprav += $spravy[0]["Pocet"];

                if($spravy[0]["Pocet"] > 0) {
                    $this->pridaj_data("udalosti_spravy", $spravy[0]["Pocet"] . "x nové udalosti");
                }
            }
            if(isset($spravy[1])){
                $pocet_sprav += $spravy[1]["Pocet"];

                if($spravy[1]["Pocet"] > 0){
                    $this->pridaj_data("organizatory_spravy", $spravy[1]["Pocet"]. "x nové organizátori");
                }
            }

            $this->pridaj_data("spravy", $pocet_sprav);

            $this->load->view("web/rozhranie/panel_hlavicka");
            $this->load->view("web/rozhranie/admin_panel_navigacia", $this->data);
            $this->load->view("web/panel/admin_panel_lokalizacia", $this->data);

            $this->dialog(site_url('udalosti/vytvorit'),"Nová udalosť", "", "nova-udalost", "udalost_dialog_vytvorit", "nova_udalost_formular", "dialog_udalosti");

            $this->load->view("web/rozhranie/admin_panel_pata");
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    public function organizatori()
    {
        if ($this->session->userdata('email_admina')) {

            $spravy = $this->Udalost_model->pocet_sprav();
            $pocet_sprav = 0;

            if(isset($spravy[0])){
                $pocet_sprav += $spravy[0]["Pocet"];

                if($spravy[0]["Pocet"] > 0) {
                    $this->pridaj_data("udalosti_spravy", $spravy[0]["Pocet"] . "x nové udalosti");
                }
            }
            if(isset($spravy[1])){
                $pocet_sprav += $spravy[1]["Pocet"];

                if($spravy[1]["Pocet"] > 0){
                    $this->pridaj_data("organizatory_spravy", $spravy[1]["Pocet"]. "x nové organizátori");
                }
            }

            $this->pridaj_data("nepotvrdene_organizatori", $this->Rola_pouzivatela_model->zoznam_organizatorov($this->session->userdata('email_admina'), NEPRECITANE));
            $this->pridaj_data("zoznam_organizatorov", $this->Rola_pouzivatela_model->zoznam_organizatorov($this->session->userdata('email_admina'), AKCEPTOVANE));
            $this->pridaj_data("odmietnute_organizatori", $this->Rola_pouzivatela_model->zoznam_organizatorov($this->session->userdata('email_admina'), BLOKOVANE));
            $this->pridaj_data("spravy", $pocet_sprav);

            $this->load->view("web/rozhranie/panel_hlavicka");
            $this->load->view("web/rozhranie/admin_panel_navigacia", $this->data);
            $this->load->view("web/panel/admin_panel_organizatori", $this->data);

            $this->dialog(site_url('udalosti/vytvorit'),"Nová udalosť", "", "nova-udalost", "udalost_dialog_vytvorit", "nova_udalost_formular", "dialog_udalosti");

            $this->dialog(site_url('registracia/vytvorit'),"Nový organizátor", "", "novy-pouzivatel", "pouzivatel_dialog_vytvorit", "novy_pouzivatel_formular", "dialog_pouzivatel");
            $this->dialog(site_url('pouzivatelia/aktualizuj'),"Aktualizovať organizátora", "", "aktualizovat-pouzivatel", "pouzivatel_dialog_aktualizuj", "aktulizovat_pouzivatel_formular", "dialog_pouzivatel");
            $this->dialog(site_url('pouzivatelia/odstran'),"Odstránenie organizátora", "Naozaj chcete odstrániť organizátora?", "odstranit-pouzivatel", "pouzivatel_dialog_odstranit", "", "dialog_potvrdit");
            $this->dialog(site_url('pouzivatelia/akceptovat'),"Akceptovanie organizátora", "Naozaj chcete akceptovať organizátora?", "akceptovat-pouzivatel", "pouzivatel_dialog_akceptovat", "", "dialog_potvrdit");
            $this->dialog(site_url('pouzivatelia/blokovat'),"Blokovanie organizátora", "Naozaj chcete blokovať organizátora?", "blokovat-pouzivatel", "pouzivatel_dialog_blokovat", "", "dialog_potvrdit");

            $this->load->view("web/rozhranie/admin_panel_pata");
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    public function administratori()
    {
        if ($this->session->userdata('email_admina')) {

            $spravy = $this->Udalost_model->pocet_sprav();
            $pocet_sprav = 0;

            if(isset($spravy[0])){
                $pocet_sprav += $spravy[0]["Pocet"];

                if($spravy[0]["Pocet"] > 0) {
                    $this->pridaj_data("udalosti_spravy", $spravy[0]["Pocet"] . "x nové udalosti");
                }
            }
            if(isset($spravy[1])){
                $pocet_sprav += $spravy[1]["Pocet"];

                if($spravy[1]["Pocet"] > 0){
                    $this->pridaj_data("organizatory_spravy", $spravy[1]["Pocet"]. "x nové organizátori");
                }
            }

            $this->pridaj_data("zoznam_administratorov", $this->Rola_pouzivatela_model->zoznam_administratorov($this->session->userdata('email_admina')));
            $this->pridaj_data("spravy", $pocet_sprav);

            $this->load->view("web/rozhranie/panel_hlavicka");
            $this->load->view("web/rozhranie/admin_panel_navigacia", $this->data);
            $this->load->view("web/panel/admin_panel_administratori", $this->data);

            $this->dialog(site_url('udalosti/vytvorit'),"Nová udalosť", "", "nova-udalost", "udalost_dialog_vytvorit", "nova_udalost_formular", "dialog_udalosti");

            $this->dialog(site_url('registracia/vytvorit'),"Nový administrátor", "", "novy-pouzivatel", "pouzivatel_dialog_vytvorit", "novy_pouzivatel_formular", "dialog_pouzivatel");
            $this->dialog(site_url('pouzivatelia/odstran'),"Odstránenie administrátora", "Naozaj chcete odstrániť administrátora?", "odstranit-pouzivatel", "pouzivatel_dialog_odstranit", "", "dialog_potvrdit");
            $this->dialog(site_url('pouzivatelia/aktualizuj'),"Aktualizovať administrátora", "", "aktualizovat-pouzivatel", "pouzivatel_dialog_aktualizuj", "aktulizovat_pouzivatel_formular", "dialog_pouzivatel");

            $this->load->view("web/rozhranie/admin_panel_pata");
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    public function ziskaj_data(){
        if ($this->session->userdata('email_admina')) {
        if($this->input->post("panel")){
            $this->load->view("json/json_admin",
                array(
                    "cennik" => $this->Cennik_model->pocet(),
                    "mesiac" => $this->Udalost_model->pocet_udalosti_v_mesiaci(),
                    "stat" => $this->Udalost_model->udalosti_podla_statu(),
                    "okres" => $this->Udalost_model->udalosti_podla_okresu(),
                    "zaujmy" => $this->Zaujem_model->zoznam()));
        }else{
            $this->load->view("json/json_admin",
                array(
                    "udalosti" => $this->Udalost_model->zoznam(PRIJATE)));
        }
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    private function pridaj_data($nazov, $udaj){
        return $this->data[$nazov] = $udaj;
    }

    private function uspesne_prihlasenie(){
        if($this->session->userdata('prihlaseny')){
            $this->pridaj_data("prihlaseny", true);
            $this->session->unset_userdata('prihlaseny');
        }
    }

    private function dialog($adresa, $titul, $text, $identifikator, $tlacidlo, $formular, $dialog){
        $this->load->view("web/dialog/".$dialog,
            array(
                "adresa" => $adresa,
                "titul" => $titul,
                "text" => $text,
                "identifikator" => $identifikator,
                "tlacidlo" => $tlacidlo,
                "formular" => $formular
            ));
    }

    private function dlazdice($info_pouzivatel, $info_organizator, $info_admin, $info_udalosti, $info_aktyvny, $info_registracia){
        $this->pridaj_data($info_pouzivatel,
            $this->Rola_pouzivatela_model->pocet(POUZIVATEL));
        $this->pridaj_data($info_organizator,
            $this->Rola_pouzivatela_model->pocet(ORGANIZATOR));
        $this->pridaj_data($info_admin,
            $this->Rola_pouzivatela_model->pocet(ADMIN));
        $this->pridaj_data($info_udalosti,
            $this->Udalost_model->pocet_udalosti());
        $this->pridaj_data($info_aktyvny,
            $this->Pouzivatel_model->aktivny_pouzivatelia());
        $this->pridaj_data($info_registracia,
            $this->Pouzivatel_model->registrovali_dnes());
    }
}
?>