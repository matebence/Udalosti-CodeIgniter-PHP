<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Zaujem_model');
        $this->load->model('Pouzivatel_model');
        $this->load->model('Vztah_model');
    }

    public function index()
    {
        $this->profil();
    }

    public function profil()
    {
        if (strcmp($this->input->post("token"), $this->Pouzivatel_model->token_pouzivatela($this->input->post("email"))) == 0) {
            $pouzivatel_object = $this->Pouzivatel_model->zisti_pouzivatela_podla_emailu($this->input->post("email"));
            if ($pouzivatel_object != null) {
                $data["profil"] = $this->Zaujem_model->udalosti_kde_pouzivatel_bol($pouzivatel_object->idPouzivatel, $this->input->post("od"), $this->input->post("pocet"));
                $data["meno"] = $pouzivatel_object->meno;
            }
            $this->load->view("json/json_vystup_dat", $data);
        } else {
            redirect("prihlasovanie/odhlasit_sa");
        }
    }

    public function profil_pouzivatela()
    {
        if (($this->input->post('id_pouzivatel')) && (strcmp($this->input->post("token"), $this->Pouzivatel_model->token_pouzivatela($this->input->post("email"))) == 0)) {
            $pouzivatel_object_prihlaseny = $this->Pouzivatel_model->zisti_pouzivatela_podla_emailu($this->input->post("email"));
            $pouzivatel_object = $this->Pouzivatel_model->zisti_pouzivatela_podla_id($this->input->post('id_pouzivatel'));

            if ($pouzivatel_object != null && $pouzivatel_object_prihlaseny != null) {
                $data["meno"] = $pouzivatel_object->meno;
                $data["idPouzivatel"] = $pouzivatel_object->idPouzivatel;
                if ($this->Vztah_model->zisi_priatelsvo($pouzivatel_object_prihlaseny->idPouzivatel, $this->input->post('id_pouzivatel'))) {
                    $data["udalosti_pouzivatela"] = $this->Zaujem_model->udalosti_kde_pouzivatel_bol($this->input->post('id_pouzivatel'), $this->input->post("od"), $this->input->post("pocet"));
                }
                $this->load->view("json/json_vystup_dat", $data);
            }
        } else {
            redirect("prihlasovanie/odhlasit_sa");
        }
    }
}

?>