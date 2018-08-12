<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pomoc extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->library('email');

        $this->load->model('Pouzivatel_model');
    }

    public function index()
    {
        $this->zabudnute_heslo();
    }

    private function zabudnute_heslo()
    {
        if ($this->input->post("zabudnute_heslo")) {
            $this->form_validation->set_rules('email',
                'Email používatela',
                'required|valid_email',
                array('required' => 'Nesprávny formát emailovej adresi!',
                    'valid_email' => 'Nesprávny formát emailovej adresi!'));

            if ($this->form_validation->run() == true) {
                $emailova_adresa_prijemcu = $this->input->post("email");
                $pouzivatel_object = $this->Pouzivatel_model->zisti_pouzivatela_podla_emailu($emailova_adresa_prijemcu);

                if ($pouzivatel_object != null) {
                    $heslo = $pouzivatel_object->heslo;
                    $this->posli_obnovovaciu_adresu_na_email($emailova_adresa_prijemcu, $heslo);
                } else {
                    $this->session->set_flashdata('chyba', 'Na Vašu emailovú adresu sme poslali mail!');
                    $this->load->view("json/json_vystup_pridanie_dat");
                }
            } else {
                $this->load->view("json/json_vystup_pridanie_dat");
            }
        } else {
            redirect("prihlasovanie/odhlasit_sa");
        }
    }

    private function posli_obnovovaciu_adresu_na_email($emailova_adresa_prijemcu, $heslo)
    {
        $obsah = "Dobrý deň,\npožiadal(a) ste nás o zaslanie zabudnutého hesla, pokračujte cez nižšie uvedený odkaz prosím:\n%s\nĎakujeme a prajeme príjemný deň.\nS priateľským pozdravom\nZákaznícky servis udalosti.sk\nTento e-mail je generovaný automaticky, prosím neodpovedajte naň.";
        $adresa = site_url() . "/pomoc/formular_pre_zabudnute_heslo?kluc=" . md5($emailova_adresa_prijemcu) . "&hodnota=" . $heslo;

        if ($heslo != null && $this->posli_email($emailova_adresa_prijemcu, "Zabudnuté heslo", sprintf($obsah, $adresa))) {
            $this->session->set_flashdata('uspech', 'Na Vašu emailovú adresu sme poslali mail.');
            $this->load->view("json/json_vystup_pridanie_dat");
        } else {
            $this->session->set_flashdata('chyba', 'Na Vašu emailovú adresu sme poslali mail!');
            $this->load->view("json/json_vystup_pridanie_dat");
        }
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

    public function formular_pre_zabudnute_heslo()
    {
        if (($this->input->get("kluc")) && ($this->input->get("hodnota"))) {
            $data['email_hash'] = $this->input->get("kluc");
            $this->load->view("zabudnute_heslo", $data);
        }
    }

    public function obnovenie_hesla()
    {
        if ($this->input->post("nove_heslo")) {
            $this->form_validation->set_rules('heslo',
                'Nové heslo používatela',
                'required|min_length[5]|max_length[20]',
                array('required' => 'Políčko hesla je povinné!',
                    'min_length' => 'Slabé heslo. Heslo je príliš krátke!',
                    'max_length' => 'Dlžka hesla presahuje 20 charakterov!'));
            $this->form_validation->set_rules('potvrd',
                'Potvrdenie nového hesla používatela',
                'required|min_length[5]|max_length[20]|matches[heslo]',
                array('required' => 'Heslá sa nezhodujú!',
                    'min_length' => 'Heslá sa nezhodujú!',
                    'max_length' => 'Heslá sa nezhodujú!',
                    'matches' => 'Heslá sa nezhodujú!'));

            if ($this->form_validation->run() == true) {
                $nove_heslo = array('heslo' => $this->sifrovanie_hesla($this->input->post('heslo')));
                $email = $this->input->post("email_hash");

                if ($this->Pouzivatel_model->nove_heslo_pouzivatela($email, $nove_heslo)) {
                    $this->session->set_flashdata('uspech', 'Aktualizácia hesla prebehla úspešne.');
                } else {
                    $this->session->set_flashdata('chyba', 'Pri aktualizácií hesla došlo ku chybe!');
                }
                $this->load->view("json/json_vystup_pridanie_dat");
            } else {
                $this->load->view("zabudnute_heslo");
            }
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
}

?>