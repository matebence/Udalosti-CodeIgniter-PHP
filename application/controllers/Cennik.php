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
        $this->zoznam_cien();
    }

    private function zoznam_cien()
    {
        if ($this->session->userdata('email_admina')) {
            $this->load->view("json/json_admin", array(
                "zoznam_cien" => $this->Cennik_model->zoznam_cien()
            ));
        }else {
            redirect("prihlasenie/pristup");
        }
    }
}

?>