<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Udalosti extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->library('image_lib');

        $this->load->model('Udalost_model');
        $this->load->model('Cennik_model');
        $this->load->model('Pouzivatel_model');
    }

    public function index()
    {
        $this->zoznam_udalosti();
    }

    private function zoznam_udalosti()
    {
        if (strcmp($this->input->post("token"), $this->Pouzivatel_model->token_pouzivatela($this->input->post("email"))) == 0) {
            if ($this->input->post("id_udalost")) {
                $data["udalosti"] = $this->Udalost_model->zoznam_pribudnutych_udalosti(
                    $this->input->post("stat"), null, null, $this->input->post("id_udalost"), $this->input->post("datum"), false);
            } else {
                $data["udalosti"] = $this->Udalost_model->zoznam_udalosti(
                    $this->input->post("stat"), $this->input->post("od"), $this->input->post("pocet"));
            }
            $this->load->view("json/json_vystup_dat", $data);
        } else {
            redirect("prihlasovanie/odhlasit_sa");
        }
    }

    public function vyhladavenie_udalosti()
    {
        if (strcmp($this->input->post("token"), $this->Pouzivatel_model->token_pouzivatela($this->input->post("email"))) == 0) {
            $data["udalosti"] = $this->Udalost_model->vyhladavenie_udalosti($this->input->post("nazov"), $this->input->post("stat"));
            $this->load->view("json/json_vystup_dat", $data);
        } else {
            redirect("prihlasovanie/odhlasit_sa");
        }
    }

    public function udalosti_podla_pozicie()
    {
        if (strcmp($this->input->post("token"), $this->Pouzivatel_model->token_pouzivatela($this->input->post("email"))) == 0) {
            if ($this->input->post("id_udalost")) {
                $data["udalosti"] = $this->Udalost_model->zoznam_pribudnutych_udalosti(
                    $this->input->post("stat"),
                    $this->input->post("okres"),
                    $this->input->post("mesto"),
                    $this->input->post("id_udalost"),
                    $this->input->post("datum"),
                    true);
            } else {
                $data["udalosti"] = $this->Udalost_model->zisti_udalosti_v_okoli(
                    $this->input->post("stat"),
                    $this->input->post("okres"),
                    $this->input->post("mesto"));
            }
            $this->load->view("json/json_vystup_dat", $data);
        } else {
            redirect("prihlasovanie/odhlasit_sa");
        }
    }

    public function podrobnosti_udalosti()
    {
        if ((strcmp($this->input->post("token"), $this->Pouzivatel_model->token_pouzivatela($this->input->post("email"))) == 0) && ($this->input->post("id_udalost"))) {
            $data["podrobnosti"] = $this->Udalost_model->informacie_o_udalosti($this->input->post("id_udalost"));
            $this->load->view("json/json_vystup_dat", $data);
        } else {
            redirect("prihlasovanie/odhlasit_sa");
        }
    }
}

?>