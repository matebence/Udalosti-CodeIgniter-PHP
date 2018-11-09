<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pouzivatelia extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');

        $this->load->model('Pouzivatel_model');
        $this->load->model('Rola_pouzivatela_model');
    }

    public function informacia($id_pouzivatel){
        if (($this->session->userdata('email_admina')) && ($id_pouzivatel)) {
            $this->load->view("json/json_admin", array(
                "aktualny_pouzivatel" => $this->Rola_pouzivatela_model->informacia($id_pouzivatel)
            ));
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    public function aktualizuj($id_pouzivatel){
        if (($this->session->userdata('email_admina')) && ($id_pouzivatel)) {
            $heslo_bolo_aktualizovane = false;

            if(($this->input->post("heslo")) && ($this->input->post("potvrd"))){
                $heslo_bolo_aktualizovane = true;
            }

            if ($this->validacia_vstupnych_udajov($heslo_bolo_aktualizovane)) {
                $pouzivatel = array(
                    "meno" => $this->input->post("meno"),
                    "email" => $this->input->post("email"));
                if($heslo_bolo_aktualizovane){
                    $pouzivatel["heslo"] = $this->sifrovanie_hesla($this->input->post('heslo'));
                }

                $aktualizovany_pouzivatel = $this->Pouzivatel_model->aktualizuj(null, $id_pouzivatel, $pouzivatel);
                if($aktualizovany_pouzivatel){

                    $pouzivatel = null;
                    $admin = false;
                    $oznam = "";

                    if(strcmp($this->input->post('rola'), "web") == 0){
                        $pouzivatel = $this->Rola_pouzivatela_model->aktualizuj($id_pouzivatel, array("idRola" => 1));
                        $admin = true;
                    }else if(strcmp($this->input->post('rola'), "pouzivatel") == 0){
                        $pouzivatel = $this->Rola_pouzivatela_model->aktualizuj($id_pouzivatel, array("idRola" => 2));
                    }

                    if($pouzivatel){
                        if($admin){
                            $oznam = "Administrátor bol aktualizovaný";
                        }else{
                            $oznam = "Použivatel bol aktualizovaný";
                        }

                        $this->load->view("web/notifikacia/notifikacia_oznam.php",
                            array(
                                "ikona" => "pe-7s-check",
                                "typ" => "success",
                                "oznam" => $oznam,
                                "presmeruj" => $admin
                            ));
                    }else{
                        $this->load->view("web/notifikacia/notifikacia_oznam.php",
                            array(
                                "ikona" => "pe-7s-attention",
                                "typ" => "warning",
                                "oznam" => "Pri aktualizovaní používateľa došlo chybe!"
                            ));
                    }
                }
            }else{
                $this->load->view("web/notifikacia/notifikacia_oznam.php",
                    array(
                        "ikona" => "pe-7s-attention",
                        "typ" => "warning"
                    ));
            }
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    public function akceptovat($id_pouzivatel){
        if (($this->session->userdata('email_admina')) && ($id_pouzivatel)) {
            $pouzivatel = array(
                "stav" => AKCEPTOVANE
            );

            $akceptovany_pouzivatel = $this->Pouzivatel_model->aktualizuj(null, $id_pouzivatel, $pouzivatel);
            if ($akceptovany_pouzivatel) {
                $this->load->view("web/notifikacia/notifikacia_oznam.php",
                    array(
                        "ikona" => "pe-7s-check",
                        "typ" => "success",
                        "oznam" => "Používateľ akceptovaný"
                    ));
            } else {
                $this->load->view("web/notifikacia/notifikacia_oznam.php",
                    array(
                        "ikona" => "pe-7s-attention",
                        "typ" => "warning",
                        "oznam" => "Pri akceptovaní používateľa došlo chybe"
                    ));
            }
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    public function blokovat($id_pouzivatel){
        if (($this->session->userdata('email_admina')) && ($id_pouzivatel)) {
            $pouzivatel = array(
                "stav" => BLOKOVANE
            );

            $blokovany_pouzivatel = $this->Pouzivatel_model->aktualizuj(null, $id_pouzivatel, $pouzivatel);
            if ($blokovany_pouzivatel) {
                $this->load->view("web/notifikacia/notifikacia_oznam.php",
                    array(
                        "ikona" => "pe-7s-check",
                        "typ" => "success",
                        "oznam" => "Používateľ blokovaný"
                    ));
            } else {
                $this->load->view("web/notifikacia/notifikacia_oznam.php",
                    array(
                        "ikona" => "pe-7s-attention",
                        "typ" => "warning",
                        "oznam" => "Pri blokovaní používateľa došlo chybe"
                    ));
            }
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    public function odstran($id_pouzivatel){
        if (($this->session->userdata('email_admina')) && ($id_pouzivatel)) {

            if(($this->Pouzivatel_model->odstran($id_pouzivatel)) && ($this->Rola_pouzivatela_model->odstran($id_pouzivatel))){
                $this->load->view("web/notifikacia/notifikacia_oznam.php",
                    array(
                        "ikona" => "pe-7s-check",
                        "typ" => "success",
                        "oznam" => "Odstránenie prebehlo úspešne"
                    ));
            }else {
                $this->load->view("web/notifikacia/notifikacia_oznam.php",
                    array(
                        "ikona" => "pe-7s-attention",
                        "typ" => "warning",
                        "oznam" => "Pri odstránení nastala chyba"
                    ));
            }
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    private function validacia_vstupnych_udajov($nove_heslo)
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
            'required|valid_email',
            array('required' => 'Nesprávny formát emailovej adresi!',
                'valid_email' => 'Nesprávny formát emailovej adresi!'));

        if($nove_heslo){
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