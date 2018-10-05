<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cennik extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Cennik_model');
    }

    public function index()
    {
        $this->zoznam();
    }

    private function zoznam()
    {
        if ($this->session->userdata('email_admina')) {
            $this->load->view("json/json_admin", array(
                "zoznam_cien" => $this->Cennik_model->zoznam()
            ));
        }else {
            redirect("prihlasenie/pristup");
        }
    }

    public function informacia($id_cennik){
        if ($this->session->userdata('email_admina')) {
            $this->load->view("json/json_admin", array(
                "aktualny_cennik" => $this->Cennik_model->informacia($id_cennik)
            ));
        }else {
            redirect("prihlasenie/pristup");
        }
    }

    public function vytvorit()
    {
        if ($this->session->userdata('email_admina')) {
        }else {
            redirect("prihlasenie/pristup");
        }
    }

    public function aktualizuj()
    {
        if ($this->session->userdata('email_admina')) {
        }else {
            redirect("prihlasenie/pristup");
        }
    }

    public function odstran()
    {
        if ($this->session->userdata('email_admina')) {
        }else {
            redirect("prihlasenie/pristup");
        }
    }
}

?>