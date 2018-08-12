<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pouzivatelia extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Rola_pouzivatela_model');
        $this->load->model('Pouzivatel_model');
    }

    public function index()
    {
        $this->zoznam_pouzivatelov();
    }

    private function zoznam_pouzivatelov()
    {
        if (strcmp($this->input->post("token"), $this->Pouzivatel_model->token_pouzivatela($this->input->post("email"))) == 0) {
            $pouzivatel_object = $this->Pouzivatel_model->zisti_pouzivatela_podla_emailu($this->input->post("email"));
            if ($pouzivatel_object != null) {
                $data["pouzivatelia"] = $this->Rola_pouzivatela_model->zoznam_pouzivatelov($this->input->post("email"), $pouzivatel_object->idPouzivatel, $this->input->post("od"), $this->input->post("pocet"));
                $this->load->view("json/json_vystup_dat", $data);
            }
        } else {
            redirect("prihlasovanie/odhlasit_sa");
        }
    }

    public function vyhladavanie_pouzivatelov()
    {
        if (strcmp($this->input->post("token"), $this->Pouzivatel_model->token_pouzivatela($this->input->post("email"))) == 0) {
            $data["pouzivatelia"] = $this->Rola_pouzivatela_model->vyhladavanie_pouzivatelov($this->input->post("meno"));
            $this->load->view("json/json_vystup_dat", $data);
        } else {
            redirect("prihlasovanie/odhlasit_sa");
        }
    }
}

?>