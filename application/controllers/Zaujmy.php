<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Zaujmy extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->zoznam();
    }

    private function zoznam()
    {
        if ($this->session->userdata('email_admina')) {
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