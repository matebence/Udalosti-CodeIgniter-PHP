<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Miesta extends CI_Controller
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
}
?>