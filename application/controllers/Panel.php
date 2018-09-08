<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Panel extends CI_Controller
{
    private $data = array();

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Pouzivatel_model');
        $this->load->model('Udalost_model');

    }

    public function index()
    {
        $this->panel();
    }

    private function panel()
    {
        if ($this->session->userdata('email_admina')) {

            $this->pridaj_data("email_admina", $this->session->userdata('email_admina'));
            $this->pridaj_data("pocet_pouzivatelov", $this->Pouzivatel_model->pocet_pouzivatelov());
            $this->pridaj_data("pocet_udalosti", $this->Udalost_model->pocet_udalosti());
            $this->pridaj_data("registrovali_dnes", $this->Pouzivatel_model->registrovali_dnes());

            $this->load->view("admin/cast/panel_hlavicka");
            $this->load->view("admin/cast/panel_navigacia");
            $this->load->view("admin/panel", $this->data);
            $this->load->view("admin/cast/panel_pata");
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    public function pouzivatelia()
    {
        if ($this->session->userdata('email_admina')) {
            $this->load->view("admin/cast/panel_hlavicka");
            $this->load->view("admin/cast/panel_navigacia");
            $this->load->view("admin/pouzivatelia", $this->data);
            $this->load->view("admin/cast/panel_pata");
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    public function udalosti()
    {
        if ($this->session->userdata('email_admina')) {
            $this->load->view("admin/cast/panel_hlavicka");
            $this->load->view("admin/cast/panel_navigacia");
            $this->load->view("admin/pouzivatelia", $this->data);
            $this->load->view("admin/cast/panel_pata");
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    public function miesta()
    {
        if ($this->session->userdata('email_admina')) {
            $this->load->view("admin/cast/panel_hlavicka");
            $this->load->view("admin/cast/panel_navigacia");
            $this->load->view("admin/miesta", $this->data);
            $this->load->view("admin/cast/panel_pata");
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    public function administratori()
    {
        if ($this->session->userdata('email_admina')) {
            $this->load->view("admin/cast/panel_hlavicka");
            $this->load->view("admin/cast/panel_navigacia");
            $this->load->view("admin/administratori", $this->data);
            $this->load->view("admin/cast/panel_pata");
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    private function pridaj_data($nazov, $udaj){
        return $this->data[$nazov] = $udaj;
    }
}
?>