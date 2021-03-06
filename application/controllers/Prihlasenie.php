<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prihlasenie extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');

        $this->load->model('Pouzivatel_model');
        $this->load->model('Rola_pouzivatela_model');
    }

    public function index()
    {
        $this->prihlasit_sa();
    }

    private function prihlasit_sa()
    {
        if ($this->input->post('pokus_o_prihlasenie')) {
            if ($this->validacia_prihlasovacych_udajov()) {
                $prihlasovacie_udaje = array(
                    'email' => $this->input->post('email'),
                    'heslo' => $this->input->post('heslo')
                );
                if ($this->spravnost_hesla($prihlasovacie_udaje["heslo"], $this->Pouzivatel_model->existuje($prihlasovacie_udaje))) {
                    if (!($this->rola($prihlasovacie_udaje))) {

                        $this->Pouzivatel_model->aktualizuj_pouzivatela($prihlasovacie_udaje['email'], array("token" => md5(uniqid(rand(), true))));
                        $this->session->set_flashdata('autentifikacia', 'Spravné prihlasovacie údaje');

                        $data["token"] = $this->Pouzivatel_model->token($prihlasovacie_udaje["email"]);
                        $this->load->view("json/json_vystup_pridanie_dat", $data);
                    }
                } else {
                    $this->session->set_flashdata('chyba', 'Nesprávne prihlasovacie údaje!');
                    $this->load->view("json/json_vystup_pridanie_dat");
                }
            } else {
                $this->session->set_flashdata('chyba', 'Nesprávne prihlasovacie údaje!');
                $this->load->view("json/json_vystup_pridanie_dat");
            }
        }
    }

    private function validacia_prihlasovacych_udajov()
    {
        $this->form_validation->set_rules('email',
            'Email',
            'required|valid_email',
            array('required' => 'Neplatný pokus o prihlásenie, skúste ešte raz!',
                'valid_email' => 'Nesprávny formát emailovej adresi!'));
        $this->form_validation->set_rules('heslo',
            'Heslo',
            'required',
            array('required' => 'Neplatný pokus o prihlásenie, skúste ešte raz!'));
        if ($this->form_validation->run() == true) {
            return true;
        } else {
            return false;
        }
    }

    private function rola($prihlasovacie_udaje)
    {
        return $this->Rola_pouzivatela_model->prihlas_pouzivatela($prihlasovacie_udaje) ? true : false;
    }

    private function spravnost_hesla($heslo_vstup, $heslo_db)
    {
        $hash = crypt($heslo_vstup, $heslo_db);
        if ($hash === $heslo_db) {
            return true;
        } else {
            return false;
        }
    }

    public function odhlasit_sa()
    {
        $this->session->sess_destroy();
        $this->Pouzivatel_model->aktualizuj_pouzivatela($this->input->post('email'), array("token" => ""));
        $this->session->set_flashdata('uspech', 'Odhlásenie prebehlo úspešne.');

        $this->load->view("json/json_vystup_pridanie_dat");
    }
}
?>