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
        $this->load->view("admin/rozhranie/prihlasenie_hlavicka");
        $this->load->view("admin/prihlasenie/prihlasenie");

        if ($this->session->userdata('email_admina')) {
            redirect("panel");
        }else{
            $this->prihlasit();
        }
    }

    public function prihlasit()
    {
        if ($this->input->post('pokus_o_prihlasenie')) {
            if ($this->validacia_vstupnych_udajov()) {

                $prihlasovacie_udaje = array('email' => $this->input->post('email'), 'heslo' => $this->input->post('heslo'));
                $prihlasovacie_udaje["heslo"] = $this->spravnost_hesla($prihlasovacie_udaje["heslo"], $this->Pouzivatel_model->existuje($prihlasovacie_udaje));

                if ($prihlasovacie_udaje["heslo"] != null) {

                    $rola = $this->Rola_pouzivatela_model->prihlas($prihlasovacie_udaje);
                    if(strcmp(ADMIN, $rola) == 0){
                        $this->session->set_userdata('email_admina', $this->input->post('email'));
                        $this->session->set_userdata('prihlaseny', true);
                        $this->index();
                    } else if(strcmp(ORGANIZATOR, $rola) == 0){

                    } else if(strcmp(POUZIVATEL, $rola) == 0){
                        if ($this->input->post('prehliadac')) {
                            $this->session->set_flashdata('chyba', 'Nesprávne prihlasovacie údaje!');
                            $this->load->view("admin/dialog/dialog_oznam");
                            $this->load->view("admin/rozhranie/prihlasenie_pata");

                        }else{
                            $this->Pouzivatel_model->aktualizuj($prihlasovacie_udaje['email'], null, array("token" => md5(uniqid(rand(), true))));
                            $this->session->set_flashdata('autentifikacia', 'Spravné prihlasovacie údaje');

                            $data["token"] = $this->Pouzivatel_model->token($prihlasovacie_udaje["email"]);
                            $this->load->view("json/json_vystup_pridanie_dat", $data);
                        }
                    }
                } else {
                    $this->session->set_flashdata('chyba', 'Nesprávne prihlasovacie údaje!');

                    if ($this->input->post('prehliadac')) {
                        $this->load->view("admin/dialog/dialog_oznam");
                        $this->load->view("admin/rozhranie/prihlasenie_pata");
                    } else {
                        $this->load->view("json/json_vystup_pridanie_dat");
                    }
                }
            } else {
                $this->session->set_flashdata('chyba', 'Nesprávne prihlasovacie údaje!');

                if ($this->input->post('prehliadac')) {
                    $this->load->view("admin/dialog/dialog_oznam");
                    $this->load->view("admin/rozhranie/prihlasenie_pata");
                } else {
                    $this->load->view("json/json_vystup_pridanie_dat");
                }
            }
        } else {
            $this->load->view("admin/rozhranie/prihlasenie_pata");
        }
    }

    private function validacia_vstupnych_udajov()
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

    private function spravnost_hesla($heslo_vstup, $heslo_db)
    {
        $hash = crypt($heslo_vstup, $heslo_db);
        if ($hash === $heslo_db) {
            return $heslo_db;
        } else {
            return null;
        }
    }

    public function pristup(){
        $this->session->sess_destroy();

        $this->load->view("admin/rozhranie/prihlasenie_hlavicka");
        $this->load->view("admin/prihlasenie/prihlasenie");
        $this->load->view("admin/rozhranie/prihlasenie_pata");
    }

    public function odhlasit()
    {
        $this->session->sess_destroy();
        $this->Pouzivatel_model->aktualizuj($this->input->post('email'), null, array("token" => ""));

        $this->session->set_flashdata('uspech', 'Odhlásenie prebehlo úspešne.');

        $this->load->view("json/json_vystup_pridanie_dat");
    }
}
?>