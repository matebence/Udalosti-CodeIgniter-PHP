<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pouzivatelia extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');

        $this->load->model('Pouzivatel_model');
        $this->load->model('Rola_model');
        $this->load->model('Rola_pouzivatela_model');
    }

    public function aktualizuj_pouzivatela(){
        if ($this->session->userdata('email_admina')) {
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    public function odstran_pouzivatela(){
        if ($this->session->userdata('email_admina')) {
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    public function informacia_o_pouzivatelovi(){
        if ($this->session->userdata('email_admina')) {
        } else {
            redirect("prihlasenie/pristup");
        }
    }
}
?>