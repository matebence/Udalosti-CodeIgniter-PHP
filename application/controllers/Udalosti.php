<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Udalosti extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->library('image_lib');

        $this->load->model('Udalost_model');
        $this->load->model('Organizator_model');
        $this->load->model('Pouzivatel_model');
        $this->load->model('Miesto_model');
    }

    public function index()
    {
        $this->zoznam();
    }

    public function vytvorit()
    {
        if ($this->session->userdata('email_admina') || $this->session->userdata('email_organizatora')) {
            if ($this->validacia_vstupnych_udajov()) {
                $obrazok = $this->obrazok();

                if (strcmp($obrazok, "chyba") == 0) {
                    $this->load->view("web/notifikacia/notifikacia_oznam.php",
                        array(
                            "ikona" => "pe-7s-attention",
                            "typ" => "warning",
                            "oznam" => "Chyba obrázka! Skúste ešte raz."
                        ));
                } else {
                    $miesto_udalosti = array(
                        "stat" => $this->input->post("stat"),
                        "okres" => $this->input->post("okres"),
                        "mesto" => $this->input->post("mesto"),
                        "ulica" => $this->input->post("ulica")
                    );

                    $nova_udalost = array(
                        "idCennik" => $this->input->post("cennik"),
                        "idMiesto" => $this->Miesto_model->vytvorit($miesto_udalosti),
                        "obrazok" => $obrazok,
                        "nazov" => $this->input->post("nazov"),
                        "datum" => $this->input->post("datum"),
                        "cas" => $this->input->post("cas"),
                        "vstupenka" => $this->input->post("vstupenka")
                    );

                    $organizator_udalosti = array();
                    if ($this->session->userdata('email_admina')) {

                        $nova_udalost["stav"] = PRIJATE;
                        $id_novej_udalosti = $this->Udalost_model->vytvorit($nova_udalost);

                        if ($id_novej_udalosti) {
                            $organizator_udalosti = array(
                                "idUdalost" => $id_novej_udalosti,
                                "idPouzivatel" => $this->Pouzivatel_model->id_hladaneho_pouzivatela($this->session->userdata('email_admina'))
                            );
                        }
                    } else if ($this->session->userdata('email_organizatora')) {

                        $nova_udalost["stav"] = NEPRECITANE;
                        $id_novej_udalosti = $this->Udalost_model->vytvorit($nova_udalost);

                        if ($id_novej_udalosti) {
                            $organizator_udalosti = array(
                                "idUdalost" => $id_novej_udalosti,
                                "idPouzivatel" => $this->Pouzivatel_model->id_hladaneho_pouzivatela($this->session->userdata('email_organizatora'))
                            );
                        }
                    }

                    $id_organizatora_udalosti = $this->Organizator_model->vytvorit($organizator_udalosti);
                    if ($id_organizatora_udalosti) {
                        $this->load->view("web/notifikacia/notifikacia_oznam.php",
                            array(
                                "ikona" => "pe-7s-check",
                                "typ" => "success",
                                "oznam" => "Udalosť bola vytvorená"
                            ));
                    } else {
                        $this->load->view("web/notifikacia/notifikacia_oznam.php",
                            array(
                                "ikona" => "pe-7s-attention",
                                "typ" => "warning",
                                "oznam" => "Pri vytvorenie novej udalosti došlo chybe!"
                            ));
                    }
                }
            } else {
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

    public function aktualizuj($id_udalost)
    {
        if ((($this->session->userdata('email_admina')) || ($this->session->userdata('email_organizatora'))) && ($id_udalost)) {
            if ($this->validacia_vstupnych_udajov()) {

                $obrazok = null;
                if ($this->input->post("zmena_obrazka")) {
                    $obrazok = $this->obrazok();
                }

                $miesto_udalosti = array(
                    "stat" => $this->input->post("stat"),
                    "okres" => $this->input->post("okres"),
                    "mesto" => $this->input->post("mesto"),
                    "ulica" => $this->input->post("ulica")
                );

                $id_miesto = $this->Udalost_model->informacia($id_udalost)["idMiesto"];
                $aktualne_miesto = $this->Miesto_model->aktualizuj($id_miesto, $miesto_udalosti);

                if ($aktualne_miesto) {
                    $udalost = array(
                        "idCennik" => $this->input->post("cennik"),
                        "idMiesto" => $id_miesto,
                        "nazov" => $this->input->post("nazov"),
                        "datum" => $this->input->post("datum"),
                        "cas" => $this->input->post("cas"),
                        "vstupenka" => $this->input->post("vstupenka")
                    );

                    if ($obrazok != null) {
                        if (strcmp($obrazok, "chyba") == 0) {
                            $this->load->view("web/notifikacia/notifikacia_oznam.php",
                                array(
                                    "ikona" => "pe-7s-attention",
                                    "typ" => "warning",
                                    "oznam" => "Chyba obrázka! Skúste ešte raz."
                                ));
                            return;
                        } else {
                            $udalost["obrazok"] = $obrazok;
                            $this->odstran_obrazok_a_miesto($id_udalost, false);
                        }
                    }

                    $aktualizovana_udalost = $this->Udalost_model->aktualizuj($id_udalost, $udalost);
                    if ($aktualizovana_udalost) {
                        $this->load->view("web/notifikacia/notifikacia_oznam.php",
                            array(
                                "ikona" => "pe-7s-check",
                                "typ" => "success",
                                "oznam" => "Udalosť bola aktualizovaná"
                            ));
                    } else {
                        $this->load->view("web/notifikacia/notifikacia_oznam.php",
                            array(
                                "ikona" => "pe-7s-attention",
                                "typ" => "warning",
                                "oznam" => "Pri aktualizovanie udalosti došlo chybe!"
                            ));
                    }
                }
            } else {
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

    public function prijat($id_udalost)
    {
        if (($this->session->userdata('email_admina')) && ($id_udalost)) {
            $udalost = array(
                "stav" => PRIJATE
            );

            $prijata_udalost = $this->Udalost_model->aktualizuj($id_udalost, $udalost);
            if ($prijata_udalost) {
                $this->load->view("web/notifikacia/notifikacia_oznam.php",
                    array(
                        "ikona" => "pe-7s-check",
                        "typ" => "success",
                        "oznam" => "Udalosť bola pridaná do aktuálnych udalostí"
                    ));
            } else {
                $this->load->view("web/notifikacia/notifikacia_oznam.php",
                    array(
                        "ikona" => "pe-7s-attention",
                        "typ" => "warning",
                        "oznam" => "Pri pridaní udalosti do aktuálnych udalosti nastala chyba"
                    ));
            }
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    public function odmietnut($id_udalost)
    {
        if (($this->session->userdata('email_admina')) && ($id_udalost)) {
            $udalost = array(
                "stav" => ODMIETNUTE
            );

            $odmietnuta_udalost = $this->Udalost_model->aktualizuj($id_udalost, $udalost);
            if ($odmietnuta_udalost) {
                $this->load->view("web/notifikacia/notifikacia_oznam.php",
                    array(
                        "ikona" => "pe-7s-check",
                        "typ" => "success",
                        "oznam" => "Udalosť bola odobraná z aktuálnych udalostí"
                    ));
            } else {
                $this->load->view("web/notifikacia/notifikacia_oznam.php",
                    array(
                        "ikona" => "pe-7s-attention",
                        "typ" => "warning",
                        "oznam" => "Pri odobraní udalosti z aktuálnych udalosti nastala chyba"
                    ));
            }
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    public function odstran($id_udalost)
    {
        if ((($this->session->userdata('email_admina')) || ($this->session->userdata('email_organizatora'))) && ($id_udalost)) {

            $this->odstran_obrazok_a_miesto($id_udalost, true);
            $id_organizatora = 0;

            if ($this->session->userdata('email_admina')) {
                $id_organizatora = $this->Organizator_model->odstran($id_udalost, $this->Pouzivatel_model->id_hladaneho_pouzivatela($this->session->userdata('email_admina')));
            } else if ($this->session->userdata('email_organizatora')) {
                $id_organizatora = $this->Organizator_model->odstran($id_udalost, $this->Pouzivatel_model->id_hladaneho_pouzivatela($this->session->userdata('email_organizatora')));
            }

            if ($id_organizatora) {
                if ($this->Udalost_model->odstran($id_udalost)) {

                    $this->load->view("web/notifikacia/notifikacia_oznam.php",
                        array(
                            "ikona" => "pe-7s-check",
                            "typ" => "success",
                            "oznam" => "Odstránenie prebehlo úspešne"
                        ));
                } else {

                    $this->load->view("web/notifikacia/notifikacia_oznam.php",
                        array(
                            "ikona" => "pe-7s-attention",
                            "typ" => "warning",
                            "oznam" => "Pri odstránení nastala chyba"
                        ));
                }
            }
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    private function zoznam()
    {
        if ((strcmp($this->input->post("token"), $this->Pouzivatel_model->token($this->input->post("email"))) == 0 && ($this->input->post("email")))) {
            $data["udalosti"] = $this->Udalost_model->zoznam_udalosti(
                $this->input->post("stat"),
                $this->input->post("email"));
            $this->load->view("json/json_vystup_dat", $data);
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    public function zoznam_podla_pozicie()
    {
        if ((strcmp($this->input->post("token"), $this->Pouzivatel_model->token($this->input->post("email"))) == 0) && ($this->input->post("email"))) {
            $data["udalosti"] = $this->Udalost_model->zoznam_udalosti_v_okoli(
                $this->input->post("stat"),
                $this->input->post("email"),
                $this->input->post("okres"),
                $this->input->post("mesto"));
            $this->load->view("json/json_vystup_dat", $data);
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    public function informacia($id_udalost)
    {
        if ((($this->session->userdata('email_admina')) || ($this->session->userdata('email_organizatora'))) && ($id_udalost)) {
            $this->load->view("json/json_admin", array(
                "aktualne_udaje_udalosti" => $this->Udalost_model->informacia($id_udalost)
            ));
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    private function obrazok()
    {
        $config['upload_path'] = './uploads';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 8000;
        $config['max_width'] = 2000;
        $config['max_height'] = 1500;
        $config['overwrite'] = FALSE;
        $config['encrypt_name'] = TRUE;

        $this->upload->initialize($config);
        if (!$this->upload->do_upload('obrazok')) {
            return "chyba";
        } else {
            $meta_data_obrazka = $this->upload->data();
            return $this->velkost_obrazka($meta_data_obrazka, 850, 400);
        }
    }

    private function velkost_obrazka($data, $sirka, $vyska)
    {
        $nazov_obrazka = $data['file_name'];

        $config['image_library'] = 'gd2';
        $config['source_image'] = './uploads/' . $nazov_obrazka;
        $config['create_thumb'] = FALSE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = $sirka;
        $config['height'] = $vyska;

        $this->image_lib->clear();
        $this->image_lib->initialize($config);
        $this->image_lib->resize();

        return 'uploads/' . $nazov_obrazka;
    }

    private function odstran_obrazok_a_miesto($id_udalost, $miesto)
    {
        $udalost = $this->Udalost_model->informacia($id_udalost);

        if ($miesto) {
            $this->Miesto_model->odstran($udalost["idMiesto"]);
        }

        if(file_exists($udalost["obrazok"])){
            unlink($udalost["obrazok"]);
        }
    }

    private function validacia_vstupnych_udajov()
    {
        $this->form_validation->set_rules('cennik',
            'Váha danej udalosti podľa cenníka',
            'required|numeric',
            array('required' => 'Cenník nebol vybratí',
                'numeric' => 'Nesprávny formát cenníka!'));
        $this->form_validation->set_rules('stat',
            'Štát kde sa udalosť koná',
            'required|min_length[3]|max_length[20]',
            array('required' => 'Nesprávny formát štátu!',
                'min_length' => 'Nesprávny formát štátu!',
                'max_length' => 'Nesprávny formát štátu!'));
        $this->form_validation->set_rules('okres',
            'Okres kde sa udalosť koná',
            'required|min_length[3]|max_length[20]',
            array('required' => 'Nesprávny formát okresu!',
                'min_length' => 'Nesprávny formát okresu!',
                'max_length' => 'Nesprávny formát okresu!'));
        $this->form_validation->set_rules('mesto',
            'Mesto kde sa udalosť koná',
            'required|min_length[3]|max_length[20]',
            array('required' => 'Nesprávny formát mesta!',
                'min_length' => 'Nesprávny formát mesta!',
                'max_length' => 'Nesprávny formát mesta!'));
        $this->form_validation->set_rules('ulica',
            'Miesto kde sa udalosť koná',
            'required|min_length[3]|max_length[40]',
            array('required' => 'Nesprávny formát ulice!',
                'min_length' => 'Nesprávny formát ulice!',
                'max_length' => 'Nesprávny formát ulice!'));
        $this->form_validation->set_rules('nazov',
            'Názov udalosti',
            'required|min_length[3]|max_length[40]',
            array('required' => 'Nesprávny formát názvu!',
                'min_length' => 'Nesprávny formát názvu!',
                'max_length' => 'Nesprávny formát názvu!'));
        $this->form_validation->set_rules('datum',
            'Dátum kedy sa udalosť koná',
            'required',
            array('required' => 'Dátum nie je vyplnené'));
        $this->form_validation->set_rules('cas',
            'Čas kedy sa udalosť koná',
            'required',
            array('required' => 'Čas nie je vyplnené'));
        $this->form_validation->set_rules('vstupenka',
            'Cena vstupenky na udalosť',
            'required',
            array('required' => 'Cena vstupenky nebola zadaná'));

        if ($this->form_validation->run() == true) {
            return true;
        } else {
            return false;
        }
    }
}

?>