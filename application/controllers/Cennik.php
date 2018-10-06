<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cennik extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');

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
            if ($this->validacia_vstupnych_udajov()) {

                $novy_cennik = array(
                    'vaha' => $this->input->post('vaha'),
                    'suma' => $this->input->post('suma'),
                );

                if ($this->Cennik_model->vytvorit($novy_cennik)) {
                    $this->load->view("admin/notifikacia/notifikacia_oznam.php",
                        array(
                            "ikona" => "pe-7s-check",
                            "typ" => "success",
                            "oznam" => "Cenník bol vytvorený"
                        ));
                }else{
                    $this->load->view("admin/notifikacia/notifikacia_oznam.php",
                        array(
                            "ikona" => "pe-7s-attention",
                            "typ" => "warning",
                            "oznam" => "Pri vytvorenie cenníka došlo chybe!"
                        ));
                }
            }else{
                $this->load->view("admin/notifikacia/notifikacia_oznam.php",
                    array(
                        "ikona" => "pe-7s-attention",
                        "typ" => "warning"
                    ));
            }
        }else {
            redirect("prihlasenie/pristup");
        }
    }

    public function aktualizuj($id_cennik)
    {
        if (($this->session->userdata('email_admina')) && ($id_cennik)) {
            if ($this->validacia_vstupnych_udajov()) {

                $aktualny_cennik = array(
                    'vaha' => $this->input->post('vaha'),
                    'suma' => $this->input->post('suma'),
                );

                if ($this->Cennik_model->aktualizuj($id_cennik, $aktualny_cennik)) {
                    $this->load->view("admin/notifikacia/notifikacia_oznam.php",
                        array(
                            "ikona" => "pe-7s-check",
                            "typ" => "success",
                            "oznam" => "Cenník bol aktualizovaný"
                        ));
                }else{
                    $this->load->view("admin/notifikacia/notifikacia_oznam.php",
                        array(
                            "ikona" => "pe-7s-attention",
                            "typ" => "warning",
                            "oznam" => "Pri aktualizovaní cenníka došlo chybe!"
                        ));
                }
            }else{
                $this->load->view("admin/notifikacia/notifikacia_oznam.php",
                    array(
                        "ikona" => "pe-7s-attention",
                        "typ" => "warning"
                    ));
            }
        }else {
            redirect("prihlasenie/pristup");
        }
    }

    public function odstran($id_cennik)
    {
        if (($this->session->userdata('email_admina')) && ($id_cennik)) {

            if($this->Cennik_model->odstran($id_cennik)){
                $this->load->view("admin/notifikacia/notifikacia_oznam.php",
                    array(
                        "ikona" => "pe-7s-check",
                        "typ" => "success",
                        "oznam" => "Cenník bol odstránení"
                    ));
            }else {
                $this->load->view("admin/notifikacia/notifikacia_oznam.php",
                    array(
                        "ikona" => "pe-7s-attention",
                        "typ" => "warning",
                        "oznam" => "Pri odstránení cenníka došlo chybe"
                    ));
            }
        }else {
            redirect("prihlasenie/pristup");
        }
    }

    private function validacia_vstupnych_udajov()
    {
        $this->form_validation->set_rules('vaha',
            'Váha danej sumy',
            'required|numeric',
            array('required' => 'Políčko váha je povinná!',
                  'numeric' => 'Váha musí byť číslo!'));
        $this->form_validation->set_rules('suma',
            'Suma danej udalosti',
            'required|numeric',
            array('required' => 'Políčko suma je povinná!',
                'numeric' => 'Suma musí byť číslo!'));
        if ($this->form_validation->run() == true) {
            return true;
        } else {
            return false;
        }
    }
}

?>