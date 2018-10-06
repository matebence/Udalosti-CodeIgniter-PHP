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
            $this->pridaj_data("email_admina",
                $this->session->userdata('email_admina'));

            $this->uspesne_prihlasenie();

            $this->dlazdice("pocet_pouzivatelov", "pocet_administratorov", "pocet_udalosti", "aktivny_pouzivatelia", "registrovali_dnes");

            $this->load->view("admin/rozhranie/panel_hlavicka");
            $this->load->view("admin/rozhranie/panel_navigacia");

            $this->load->view("admin/panel/panel",
                $this->data);

            $this->dialog(site_url('udalosti/vytvorit'),"Nová udalosť", "", "nova-udalost", "udalost_dialog_vytvorit", "nova_udalost_formular", "dialog_udalosti");

            $this->load->view("admin/rozhranie/panel_pata");
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    public function udalosti()
    {
        if ($this->session->userdata('email_admina')) {
            $this->pridaj_data("vsetky_udalosti",
                $this->Udalost_model->zoznam());

            $this->load->view("admin/rozhranie/panel_hlavicka");
            $this->load->view("admin/rozhranie/panel_navigacia");

            $this->load->view("admin/panel/panel_udalosti",
                $this->data);

            $this->dialog(site_url('udalosti/vytvorit'),"Nová udalosť", "", "nova-udalost", "udalost_dialog_vytvorit", "nova_udalost_formular", "dialog_udalosti");
            $this->dialog(site_url('udalosti/odstran'),"Odstránenie udalosti", "Naozaj chcete odstrániť udalosť?", "odstranit-udalost", "udalost_dialog_odstranit", "", "dialog_odstranit");
            $this->dialog(site_url('udalosti/aktualizuj'),"Aktualizovanie udalosti", "", "aktualizovat-udalost", "udalost_dialog_aktualizuj", "aktulizovat_udalost_formular", "dialog_udalosti");

            $this->load->view("admin/rozhranie/panel_pata");
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    public function pouzivatelia()
    {
        if ($this->session->userdata('email_admina')) {
            $this->pridaj_data("zoznam_pouzivatelov",
                $this->Rola_pouzivatela_model->zoznam_pouzivatelov());

            $this->load->view("admin/rozhranie/panel_hlavicka");
            $this->load->view("admin/rozhranie/panel_navigacia");

            $this->load->view("admin/panel/panel_pouzivatelia",
                $this->data);

            $this->dialog(site_url('udalosti/vytvorit'),"Nová udalosť", "", "nova-udalost", "udalost_dialog_vytvorit", "nova_udalost_formular", "dialog_udalosti");

            $this->dialog(site_url('registracia/vytvorit'),"Nový používatel", "", "novy-pouzivatel_admin", "pouzivatel_admin_dialog_vytvorit", "novy_pouzivatel_admin_formular", "dialog_pouzivatel_admin");
            $this->dialog(site_url('pouzivatelia/odstran'),"Odstránenie používatela", "Naozaj chcete odstrániť používatela?", "odstranit-pouzivatel_admin", "pouzivatel_admin_dialog_odstranit", "", "dialog_odstranit");
            $this->dialog(site_url('pouzivatelia/aktualizuj'),"Aktualizovať používatela", "", "aktualizovat-pouzivatel_admin", "pouzivatel_admin_dialog_aktualizuj", "aktulizovat_pouzivatel_admin_formular", "dialog_pouzivatel_admin");

            $this->load->view("admin/rozhranie/panel_pata");
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    public function cennik()
    {
        if ($this->session->userdata('email_admina')) {
            $this->pridaj_data("zoznam_cien",
                $this->Cennik_model->zoznam());

            $this->load->view("admin/rozhranie/panel_hlavicka");
            $this->load->view("admin/rozhranie/panel_navigacia");

            $this->load->view("admin/panel/panel_cennik",
                $this->data);

            $this->dialog(site_url('udalosti/vytvorit'),"Nová udalosť", "", "nova-udalost", "udalost_dialog_vytvorit", "nova_udalost_formular", "dialog_udalosti");

            $this->dialog(site_url('cennik/vytvorit'),"Nový cenník", "", "novy-cennik", "cennik_dialog_vytvorit", "novy_cennik_formular", "dialog_cennik");
            $this->dialog(site_url('cennik/odstran'),"Odstránenie cenníka", "Naozaj chcete odstrániť cenník?", "odstranit-cennik", "cennik_dialog_odstranit", "", "dialog_odstranit");
            $this->dialog(site_url('cennik/aktualizuj'),"Aktualizovať cenník", "", "aktualizovat-cennik", "cennik_dialog_aktualizuj", "aktulizovat_cennik_formular", "dialog_cennik");

            $this->load->view("admin/rozhranie/panel_pata");
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    public function zaujmy()
    {
        if ($this->session->userdata('email_admina')) {
            $this->pridaj_data("zaujmy",
                $this->Zaujem_model->zoznam());

            $this->load->view("admin/rozhranie/panel_hlavicka");
            $this->load->view("admin/rozhranie/panel_navigacia");

            $this->load->view("admin/panel/panel_zaujmy",
                $this->data);

            $this->dialog(site_url('udalosti/vytvorit'),"Nová udalosť", "", "nova-udalost", "udalost_dialog_vytvorit", "nova_udalost_formular", "dialog_udalosti");

            $this->load->view("admin/rozhranie/panel_pata");
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    public function miesta()
    {
        if ($this->session->userdata('email_admina')) {
            $this->pridaj_data("miesta",
                $this->Miesto_model->zoznam());

            $this->load->view("admin/rozhranie/panel_hlavicka");
            $this->load->view("admin/rozhranie/panel_navigacia");

            $this->load->view("admin/panel/panel_miesta",
                $this->data);

            $this->dialog(site_url('udalosti/vytvorit'),"Nová udalosť", "", "nova-udalost", "udalost_dialog_vytvorit", "nova_udalost_formular", "dialog_udalosti");

            $this->load->view("admin/rozhranie/panel_pata");
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    public function lokalizacia()
    {
        if ($this->session->userdata('email_admina')) {
            $this->load->view("admin/rozhranie/panel_hlavicka");
            $this->load->view("admin/rozhranie/panel_navigacia");

            $this->load->view("admin/panel/panel_lokalizacia",
                $this->data);

            $this->dialog(site_url('udalosti/vytvorit'),"Nová udalosť", "", "nova-udalost", "udalost_dialog_vytvorit", "nova_udalost_formular", "dialog_udalosti");

            $this->load->view("admin/rozhranie/panel_pata");
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    public function administratori()
    {
        if ($this->session->userdata('email_admina')) {
            $this->pridaj_data("zoznam_administratorov",
                $this->Rola_pouzivatela_model->zoznam_administratorov($this->session->userdata('email_admina')));

            $this->load->view("admin/rozhranie/panel_hlavicka");
            $this->load->view("admin/rozhranie/panel_navigacia");

            $this->load->view("admin/panel/panel_administratori",
                $this->data);

            $this->dialog(site_url('udalosti/vytvorit'),"Nová udalosť", "", "nova-udalost", "udalost_dialog_vytvorit", "nova_udalost_formular", "dialog_udalosti");

            $this->dialog(site_url('registracia/vytvorit'),"Nový administrátor", "", "novy-pouzivatel_admin", "pouzivatel_admin_dialog_vytvorit", "novy_pouzivatel_admin_formular", "dialog_pouzivatel_admin");
            $this->dialog(site_url('pouzivatelia/odstran'),"Odstránenie administrátora", "Naozaj chcete odstrániť administrátora?", "odstranit-pouzivatel_admin", "pouzivatel_admin_dialog_odstranit", "", "dialog_odstranit");
            $this->dialog(site_url('pouzivatelia/aktualizuj'),"Aktualizovať administrátora", "", "aktualizovat-pouzivatel_admin", "pouzivatel_admin_dialog_aktualizuj", "aktulizovat_pouzivatel_admin_formular", "dialog_pouzivatel_admin");

            $this->load->view("admin/rozhranie/panel_pata");
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
                    "udalosti" => $this->Udalost_model->zoznam()));
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
        $this->load->view("admin/dialog/".$dialog,
            array(
                "adresa" => $adresa,
                "titul" => $titul,
                "text" => $text,
                "identifikator" => $identifikator,
                "tlacidlo" => $tlacidlo,
                "formular" => $formular
            ));
    }

    private function dlazdice($info_pouzivatel, $info_admin, $info_udalosti, $info_aktyvny, $info_registracia){
        $this->pridaj_data($info_pouzivatel,
            $this->Rola_pouzivatela_model->pocet("pouzivatel"));
        $this->pridaj_data($info_admin,
            $this->Rola_pouzivatela_model->pocet("admin"));
        $this->pridaj_data($info_udalosti,
            $this->Udalost_model->pocet_udalosti());
        $this->pridaj_data($info_aktyvny,
            $this->Pouzivatel_model->aktivny_pouzivatelia());
        $this->pridaj_data($info_registracia,
            $this->Pouzivatel_model->registrovali_dnes());
    }
}
?>