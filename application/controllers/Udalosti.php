<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Udalosti extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Udalost_model');
        $this->load->model('Pouzivatel_model');
    }

    public function index()
    {
        $this->zoznam_udalosti();
    }

    public function admin_panel()
    {
        if ($this->session->userdata('email_admina')) {
            $this->load->view("admin/panel");
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    private function zoznam_udalosti()
    {
        if ((strcmp($this->input->post("token"), $this->Pouzivatel_model->token($this->input->post("email"))) == 0 && ($this->input->post("email")))) {
            $data["udalosti"] = $this->Udalost_model->zoznam_udalosti(
                $this->input->post("stat"));
            $this->load->view("json/json_vystup_dat", $data);
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    public function udalosti_podla_pozicie()
    {
        if ((strcmp($this->input->post("token"), $this->Pouzivatel_model->token($this->input->post("email"))) == 0) && ($this->input->post("email"))) {
            $data["udalosti"] = $this->Udalost_model->zoznam_udalosti_v_okoli(
                $this->input->post("stat"),
                $this->input->post("okres"),
                $this->input->post("mesto"));
            $this->load->view("json/json_vystup_dat", $data);
        } else {
            redirect("prihlasenie/pristup");
        }
    }
}
?>