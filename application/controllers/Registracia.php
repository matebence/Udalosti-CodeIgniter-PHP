<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registracia extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');

        $this->load->model('Pouzivatel_model');
        $this->load->model('Rola_model');
        $this->load->model('Rola_pouzivatela_model');
    }

    public function index()
    {
        $this->registrovat_sa();
    }

    private function registrovat_sa()
    {
        if ($this->input->post("nova_registracia")) {
            if ($this->validacia_registracnych_udajov()) {
                    $novy_pouzivatel = array(
                        'email' => $this->input->post('email'),
                        'meno' => $this->input->post('meno'),
                        'heslo' => $this->sifrovanie_hesla($this->input->post('heslo')),
                        'token' => "",
                    );
                    $id_noveho_pouzivatela = $this->Pouzivatel_model->pouzivatel($novy_pouzivatel);
                    if ($id_noveho_pouzivatela) {
                        if ($this->Rola_pouzivatela_model->rola_pouzivatela($id_noveho_pouzivatela, $this->Rola_model->pouzivatel(POUZIVATEL))) {
                            $this->session->set_flashdata('uspech', 'Registrácia prebehla úspšne.');
                            $this->load->view("json/json_vystup_pridanie_dat");
                        } else {
                            $this->session->set_flashdata('chyba', 'Pri registrácií došlo chybe!');
                            $this->load->view("json/json_vystup_pridanie_dat");
                        }
                    } else {
                        $this->session->set_flashdata('chyba', 'Pri registrácií došlo chybe!');
                        $this->load->view("json/json_vystup_pridanie_dat");
                    }
            } else {
                $this->load->view("json/json_vystup_pridanie_dat");
            }
        }
    }

    private function validacia_registracnych_udajov()
    {
        $this->form_validation->set_rules('meno',
            'Meno regitrujúcého',
            'required|min_length[3]|max_length[20]|alpha',
            array('required' => 'Nesprávny formát mena!',
                'min_length' => 'Nesprávny formát mena!',
                'max_length' => 'Nesprávny formát mena!',
                'alpha' => 'Nesprávny formát mena!'));
        $this->form_validation->set_rules('email',
            'Email regitrujúcého',
            'required|valid_email|is_unique[pouzivatel.email]',
            array('required' => 'Nesprávny formát emailovej adresi!',
                'valid_email' => 'Nesprávny formát emailovej adresi!',
                'is_unique' => 'Emailová adresa už existuje!'));
        $this->form_validation->set_rules('heslo',
            'Heslo regitrujúcého',
            'required|min_length[5]|max_length[20]',
            array('required' => 'Políčko hesla je povinné!',
                'min_length' => 'Slabé heslo. Heslo je príliš krátke!',
                'max_length' => 'Dlžka hesla presahuje 20 charakterov!'));
        $this->form_validation->set_rules('potvrd',
            'Potvrdenie hesla',
            'required|min_length[5]|max_length[20]|matches[heslo]',
            array('required' => 'Heslá sa nezhodujú!',
                'min_length' => 'Heslá sa nezhodujú!',
                'max_length' => 'Heslá sa nezhodujú!',
                'matches' => 'Heslá sa nezhodujú!'));
        if ($this->form_validation->run() == true) {
            return true;
        } else {
            return false;
        }
    }

    private function sifrovanie_hesla($password)
    {
        $salt = $this->retazec(22);
        $spolu = BLOWFISH_FORMAT . $salt;
        $hash = crypt($password, $spolu);
        return $hash;
    }

    private function retazec($dlzka_vystupu)
    {
        $unique_random_retazec = md5(uniqid(mt_rand(), true));
        $base64_retazec = base64_encode($unique_random_retazec);
        $base64_retazec_bez_plus = str_replace('+', '.', $base64_retazec);
        $salt = substr($base64_retazec_bez_plus, 0, $dlzka_vystupu);
        return $salt;
    }
}
?>