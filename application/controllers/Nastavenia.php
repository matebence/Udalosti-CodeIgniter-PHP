<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nastavenia extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->library('image_lib');
        $this->load->library('email');
        $this->load->library('user_agent');

        $this->load->model('Pouzivatel_model');
        $this->load->model('Zaujem_model');
        $this->load->model('Pozvanka_model');
        $this->load->model('Rola_pouzivatela_model');
        $this->load->model('Vztah_model');
    }

    public function index()
    {
        $this->aktualizuj_pouzivatelske_udaje();
    }

    private function aktualizuj_pouzivatelske_udaje()
    {
        if ((strcmp($this->input->post("token"), $this->Pouzivatel_model->token_pouzivatela($this->input->post("email"))) == 0) && ($this->input->post("aktualizuj_udaje"))) {
            if ($this->validacia_udajov_pri_aktualizovani($this->input->post('meno'), $this->input->post('heslo'))) {
                $novy_obrazok_pouzivatela = $this->profilova_fotka_pouzivatela();
                $aktualizacne_udaje = array();
                if (strlen($novy_obrazok_pouzivatela) > 1) {
                    $aktualizacne_udaje['obrazok'] = $novy_obrazok_pouzivatela;

                    $pouzivatel_objekt = $this->Pouzivatel_model->zisti_pouzivatela_podla_emailu($this->input->post("email"));
                    if ($pouzivatel_objekt != null) {
                        $this->odstran_obrazok($pouzivatel_objekt->obrazok);
                    }
                }
                if ($this->input->post('meno')) {
                    $aktualizacne_udaje['meno'] = $this->input->post('meno');
                }
                if ($this->input->post('heslo')) {
                    $aktualizacne_udaje['heslo'] = $this->sifrovanie_hesla($this->input->post('heslo'));
                    $this->posli_mail_o_zmene_hesla($this->input->post("email"));
                }
                if ($this->Pouzivatel_model->aktualizuj_pouzivatela($this->input->post("email"), $aktualizacne_udaje)) {
                    $this->session->set_flashdata('uspech', 'Aktualizácia údajov prebehla úspešne.');
                } else {
                    $this->session->set_flashdata('chyba', 'Nasta chyba pri aktualizácií, prosím skúste ešte raz!');
                }
                $this->load->view("json/json_vystup_pridanie_dat");
            } else {
                $this->load->view("json/json_vystup_pridanie_dat");
            }
        } else {
            redirect("prihlasovanie/odhlasit_sa");
        }
    }

    private function validacia_udajov_pri_aktualizovani($meno, $heslo)
    {
        if ((($meno != null) || ($heslo != null))) {
            if ($meno != null) {
                $this->form_validation->set_rules('meno',
                    'Meno regitrujúcého',
                    'required|min_length[3]|max_length[20]|alpha',
                    array('required' => 'Nesprávny formát mena!',
                        'min_length' => 'Nesprávny formát mena!',
                        'max_length' => 'Nesprávny formát mena!',
                        'alpha' => 'Nesprávny formát mena!'));
            }
            if ($heslo != null) {
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
            }
            if ($this->form_validation->run() == true) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
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

    private function posli_mail_o_zmene_hesla($email)
    {
        $predmet = "Heslo bolo zmenené";
        $obsah = "Dobrý deň, \nV tejto správe informujeme Vás a zmene Vášho hesla. \nZmeny boli vykonané dňa \n" . date('Y-m-d H:i:s') . "\nĎalšie informácie: \n" . $this->ziskaj_informacie_o_spojeni()[0] . "\n" . $this->ziskaj_informacie_o_spojeni()[1] . "\n" . $this->ziskaj_informacie_o_spojeni()[2] . "\nS priateľským pozdravom\nZákaznícky servis udalosti.sk\nTento e-mail je generovaný automaticky, prosím neodpovedajte naň.";
        $this->posli_email($email, $predmet, $obsah);
    }

    private function ziskaj_informacie_o_spojeni()
    {
        if ($this->agent->is_browser()) {
            $prehliadac = $this->agent->browser() . ' ' . $this->agent->version();
        } elseif ($this->agent->is_robot()) {
            $prehliadac = $this->agent->robot();
        } elseif ($this->agent->is_mobile()) {
            $prehliadac = $this->agent->mobile();
        } else {
            $prehliadac = 'Neznámy prehliadač';
        }
        $informacie = array($prehliadac, $this->agent->platform(), $this->input->ip_address());
        return $informacie;
    }

    private function posli_email($emailova_adresa, $predmet, $obsah_emailu)
    {
        $this->email->from(NOREPLY_EMAIL_ADDRESS, FIRMA);
        $this->email->to($emailova_adresa);
        $this->email->subject($predmet);
        $this->email->message($obsah_emailu);

        if ($this->email->send()) {
            return true;
        } else {
            return false;
        }
    }

    private function profilova_fotka_pouzivatela()
    {
        $config['upload_path'] = './uploads/profil';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 8000;
        $config['max_width'] = 1500;
        $config['max_height'] = 1500;
        $config['overwrite'] = FALSE;

        $this->upload->initialize($config);
        if (!$this->upload->do_upload('profil')) {
            return "";
        } else {
            $meta_data_obrazka = $this->upload->data();
            return $this->velkost_obrazka($meta_data_obrazka, 800, 800);
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

    private function odstran_obrazok($obrazok)
    {
        if ((strcmp($obrazok, "") != 0) || strcmp($obrazok, "default") != 0) {
            unlink($obrazok);
        }
    }

    public function odstranenie_uctu()
    {
        if ((strcmp($this->input->post("token"), $this->Pouzivatel_model->token_pouzivatela($this->input->post("email"))) == 0) && ($this->input->post("odstran"))) {
            $pouzivatel_object = $this->Pouzivatel_model->zisti_pouzivatela_podla_emailu($this->input->post("email"));
            if ($pouzivatel_object != null) {
                if ($this->Pouzivatel_model->odstran_pouzivatela($pouzivatel_object->idPouzivatel)) {
                    if ($this->Zaujem_model->odstranenie_zaujmov_z_dovodu_odstranenia_uctu($pouzivatel_object->idPouzivatel)) {
                        if ($this->Pozvanka_model->odstranenie_pozvanok_z_dovodu_odstranenia_uctu($pouzivatel_object->idPouzivatel)) {
                            if ($this->Rola_pouzivatela_model->odstranenie_roli_pouzivatela_z_dovodu_odstranenia_uctu($pouzivatel_object->idPouzivatel)) {
                                if ($this->Vztah_model->odstranenie_vztahov_z_dovodu_odstranenia_uctu($pouzivatel_object->idPouzivatel)) {
                                    redirect("prihlasenie/odhlasit_sa");
                                } else {
                                    $this->session->set_flashdata('chyba', 'Pri odstránenie účtu došlo chybe - 5/5.');
                                }
                            } else {
                                $this->session->set_flashdata('chyba', 'Pri odstránenie účtu došlo chybe - 4/5.');
                            }
                        } else {
                            $this->session->set_flashdata('chyba', 'Pri odstránenie účtu došlo chybe - 3/5.');
                        }
                    } else {
                        $this->session->set_flashdata('chyba', 'Pri odstránenie účtu došlo chybe - 2/5.');
                    }
                } else {
                    $this->session->set_flashdata('chyba', 'Pri odstránenie účtu došlo chybe - 1/5.');
                }
            }
            $this->load->view("json/json_vystup_odpoved");
        } else {
            redirect("prihlasovanie/odhlasit_sa");
        }
    }
}

?>