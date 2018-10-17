<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Zaujmy extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');

        $this->load->model('Zaujem_model');
        $this->load->model('Pouzivatel_model');
    }

    public function index()
    {
        $this->vytvorit();
    }

    private function vytvorit()
    {
        if ((strcmp($this->input->post("token"), $this->Pouzivatel_model->token($this->input->post("email"))) == 0 && ($this->input->post("email")))) {
            if ($this->validacia_vstupnych_udajov()) {
                $novy_zaujem = array(
                    'idUdalost' => $this->input->post('idUdalost'),
                    'idPouzivatel' => $this->Pouzivatel_model->id_hladaneho_pouzivatela($this->input->post("email"))
                );

                $id_noveho_zaujmu = $this->Zaujem_model->vytvorit($novy_zaujem);
                if ($id_noveho_zaujmu) {
                    $this->session->set_flashdata('uspech', 'Udalosť bola pridaná do záujmov');
                }else{
                    $this->session->set_flashdata('chyba', 'Chyba udalosť sa nepridala do záujmov');
                }

                $this->load->view("json/json_vystup_odpoved");
            }
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    private function validacia_vstupnych_udajov(){
        $this->form_validation->set_rules('email',
            'Email používatela',
            'required|valid_email',
            array('required' => 'Email je povinné pole!',
                'valid_email' => 'Nesprávny formát emailovej adresi!'));
        $this->form_validation->set_rules('token',
            'Token používatela',
            'required|min_length[32]',
            array('required' => 'Token je povinné pole!',
                'min_length' => 'Nesprávny token!'));
        $this->form_validation->set_rules('idUdalost',
            'Identifikátor udalosti',
            'required|numeric',
            array('required' => 'idUdalosť je povinné pole!',
                'numeric' => 'idUdalosť musí byť číslo!'));
        if ($this->form_validation->run() == true) {
            return true;
        } else {
            return false;
        }
    }

    public function potvrd()
    {
        if ((strcmp($this->input->post("token"), $this->Pouzivatel_model->token($this->input->post("email"))) == 0 && ($this->input->post("email")))) {
            $data["udalosti"] = $this->Zaujem_model->potvrdenie_zaujmu(
                $this->input->post("idUdalost"),
                $this->Pouzivatel_model->id_hladaneho_pouzivatela($this->input->post("email")
            ));
            $this->load->view("json/json_vystup_dat", $data);
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    public function zoznam()
    {
        if ((strcmp($this->input->post("token"), $this->Pouzivatel_model->token($this->input->post("email"))) == 0 && ($this->input->post("email")))) {
            $data["udalosti"] = $this->Zaujem_model->zaujmy(
                $this->input->post("email"));
            $this->load->view("json/json_vystup_dat", $data);
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    public function odstran()
    {
        if ((strcmp($this->input->post("token"), $this->Pouzivatel_model->token($this->input->post("email"))) == 0 && ($this->input->post("email")))) {
            $stav =  $this->Zaujem_model->odstran($this->input->post("idUdalost"), $this->Pouzivatel_model->id_hladaneho_pouzivatela($this->input->post("email")));

            if($stav){
                $this->session->set_flashdata('uspech', 'Udalosť bola odstránená zo záujmov');
            }else{
                $this->session->set_flashdata('chyba', 'Chyba pri odstráneni udalosti zo záujmov');
            }
            $this->load->view("json/json_vystup_odpoved");
        } else {
            redirect("prihlasenie/pristup");
        }
    }
}

?>