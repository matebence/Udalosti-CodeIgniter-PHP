<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registracia extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->library('image_lib');

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
                $obrazok_pouzivatela = $this->profilova_fotka_pouzivatela();
                if (!(empty($obrazok_pouzivatela))) {
                    $novy_pouzivatel = array(
                        'obrazok' => $obrazok_pouzivatela,
                        'meno' => $this->input->post('meno'),
                        'email' => $this->input->post('email'),
                        'heslo' => $this->sifrovanie_hesla($this->input->post('heslo')),
                        'pohlavie' => $this->input->post('pohlavie'),
                        'idTelefonu' => $this->input->post('idTelefonu'),
                        'token' => "",
                    );
                    $id_noveho_pouzivatela = $this->Pouzivatel_model->novy_pouzivatel($novy_pouzivatel);
                    if ($id_noveho_pouzivatela) {
                        if ($this->Rola_pouzivatela_model->nova_rola_pouzivatela($id_noveho_pouzivatela, $this->Rola_model->zisti_rolu("pouzivatel"))) {
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
        $this->form_validation->set_rules('pohlavie',
            'Pohlavie regitrujúcého',
            'required',
            array('required' => 'Nevybrali ste pohlavie!'));
        $this->form_validation->set_rules('idTelefonu',
            'Registračné číslo Cloud Messegegu',
            'required|is_unique[pouzivatel.idTelefonu]',
            array('required' => 'Zariadenie sme už zaregistrovali. Pre odstránenie registrácie odinštalujte aplikáciu!',
                'is_unique' => 'Zariadenie sme už zaregistrovali. Pre odstránenie registrácie odinštalujte aplikáciu!'));
        if ($this->form_validation->run() == true) {
            return true;
        } else {
            return false;
        }
    }

    private function sifrovanie_hesla($password)
    {
        $salt = $this->generuj_nahodny_retazec(22);
        $spolu = BLOWFISH_FORMAT . $salt;
        $hash = crypt($password, $spolu);
        return $hash;
    }

    private function generuj_nahodny_retazec($dlzka_vystupu)
    {
        $unique_random_retazec = md5(uniqid(mt_rand(), true));
        $base64_retazec = base64_encode($unique_random_retazec);
        $base64_retazec_bez_plus = str_replace('+', '.', $base64_retazec);
        $salt = substr($base64_retazec_bez_plus, 0, $dlzka_vystupu);
        return $salt;
    }

    private function profilova_fotka_pouzivatela()
    {
        $config['upload_path'] = './uploads/profil';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 8000;
        $config['max_width'] = 1500;
        $config['max_height'] = 1500;
        $config['encrypt_name'] = TRUE;
        $config['overwrite'] = FALSE;

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('profil')) {
            if (empty($_FILES['profil']['name'])) {
                return "default";
            }
            $this->session->set_flashdata('chyba', 'Pri nahratie fotky sa stala chyba! Prosím skúste ešte raz!');
            return "";
        } else {
            $meta_data_obrazka = $this->upload->data();
            return $this->velkost_obrazka($meta_data_obrazka, 500, 500);
        }
    }

    private function velkost_obrazka($data, $sirka, $vyska)
    {
        $nazov_obrazka = $data['file_name'];

        $config['image_library'] = 'gd2';
        $config['source_image'] = './uploads/profil/' . $nazov_obrazka;
        $config['create_thumb'] = FALSE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = $sirka;
        $config['height'] = $vyska;

        $this->image_lib->clear();
        $this->image_lib->initialize($config);
        $this->image_lib->resize();

        return 'uploads/profil/' . $nazov_obrazka;
    }
}

?>