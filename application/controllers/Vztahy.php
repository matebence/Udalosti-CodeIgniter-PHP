<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vztahy extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Vztah_model');
        $this->load->model('Pouzivatel_model');

        $this->load->library('Firebase');
        $this->load->library('Oznamenia');
    }

    public function index()
    {
        $this->zoznam_priatelov();
    }

    private function zoznam_priatelov()
    {
        if (strcmp($this->input->post("token"), $this->Pouzivatel_model->token_pouzivatela($this->input->post("email"))) == 0) {
            $pouzivatel_object = $this->Pouzivatel_model->zisti_pouzivatela_podla_emailu($this->input->post("email"));
            if ($pouzivatel_object != null) {
                $data["priatelia"] = $this->Vztah_model->zoznam_priatelov($pouzivatel_object->idPouzivatel, $this->input->post("od"), $this->input->post("pocet"));
            }
            $this->load->view("json/json_vystup_dat", $data);
        } else {
            redirect("prihlasovanie/odhlasit_sa");
        }
    }

    public function posli_ziadost_o_priatelstvo()
    {
        if (($this->input->post('ziadost_o_priatelsvo')) && (strcmp($this->input->post("token"), $this->Pouzivatel_model->token_pouzivatela($this->input->post("email"))) == 0)) {
            $pouzivatel_object_odosielatel = $this->Pouzivatel_model->zisti_pouzivatela_podla_emailu($this->input->post("email"));
            if ($pouzivatel_object_odosielatel != null) {
                if ($this->Vztah_model->zisi_priatelsvo($pouzivatel_object_odosielatel->idPouzivatel, $this->input->post('nove_priatelstvo'), true)) {
                    $this->session->set_flashdata('chyba', 'Žiadost o priatelstvo už bola odoslaná');
                } else {
                    $id_vztah = $this->Vztah_model->novy_mozny_vztah($pouzivatel_object_odosielatel->idPouzivatel, $this->input->post('nove_priatelstvo'));
                    if ($id_vztah > -1) {
                        $pouzivatel_object_prijemca = $this->Pouzivatel_model->zisti_pouzivatela_podla_id($this->input->post("nove_priatelstvo"));
                        $this->notifikacna_sprava($id_vztah, $pouzivatel_object_odosielatel->meno, $pouzivatel_object_odosielatel->obrazok, $pouzivatel_object_prijemca->idTelefonu);
                        $this->session->set_flashdata('uspech', 'Žiadosť o priatelsvo bolo odaslané.');
                    } else {
                        $this->session->set_flashdata('chyba', 'Nastala chyba prosim skúste ešte raz!');
                    }
                }
                $this->load->view("json/json_vystup_odpoved");
            }
        } else {
            redirect("prihlasovanie/odhlasit_sa");
        }
    }

    private function notifikacna_sprava($id_vztah, $meno, $obrazok, $id_telefonu)
    {
        $this->oznamenia->set_obrazok($obrazok);
        $this->oznamenia->set_meno($meno);
        $this->oznamenia->set_id_vztah($id_vztah);

        $this->oznamenia->set_id_udalost("");
        $this->oznamenia->set_precitana("");
        $this->oznamenia->set_nazov("");
        $this->oznamenia->set_mesto("");
        $this->oznamenia->set_udalost("");

        $json = '';
        $odpoved = '';

        $json = $this->oznamenia->ziskaj_spravu();
        $odpoved = $this->firebase->posli_jednemu($id_telefonu, $json);
    }

    public function zrusenie_priatelstva()
    {
        if (($this->input->post('zrusenie')) && (strcmp($this->input->post("token"), $this->Pouzivatel_model->token_pouzivatela($this->input->post("email"))) == 0)) {
            $pouzivatel_object_prihlaseny = $this->Pouzivatel_model->zisti_pouzivatela_podla_emailu($this->input->post("email"));
            if ($pouzivatel_object_prihlaseny != null) {
                if ($this->Vztah_model->odstranenie_vztahu($pouzivatel_object_prihlaseny->idPouzivatel, $this->input->post('priatel'))) {
                    $this->session->set_flashdata('uspech', 'Priatelstvo bolo zrušené');
                } else {
                    $this->session->set_flashdata('chyba', 'Nastala chyba prosim skúste ešte raz!');
                }
                $this->load->view("json/json_vystup_odpoved");
            }
        } else {
            redirect("prihlasovanie/odhlasit_sa");
        }
    }

    public function test(){
        print_r($this->Vztah_model->spatna_odpoved_na_ziadost(54,7));
    }

    public function odpoved_na_ziadost()
    {
        if (($this->input->post('odpoved_na_ziadost')) && (strcmp($this->input->post("token"), $this->Pouzivatel_model->token_pouzivatela($this->input->post("email"))) == 0)) {
            $odpoved = $this->input->post('odpoved_na_ziadost');
            $idZiadost = $this->input->post('id_ziadost');

            $pouzivatel_object_prihlaseny = $this->Pouzivatel_model->zisti_pouzivatela_podla_emailu($this->input->post("email"));
            if (strcmp($odpoved, PRIJATI) == 0) {
                if ($pouzivatel_object_prihlaseny != null) {
                    $pouzivatel_object_prijemca = $this->Pouzivatel_model->zisti_pouzivatela_podla_id($this->Vztah_model->spatna_odpoved_na_ziadost($this->input->post('id_ziadost'),$pouzivatel_object_prihlaseny->idPouzivatel));
                    if($pouzivatel_object_prijemca != null){
                        if($this->Vztah_model->odpoved_na_ziadost($idZiadost, PRIJATI)){
                            $this->notifikacna_sprava($this->input->post('id_ziadost'),$pouzivatel_object_prihlaseny->meno,"",$pouzivatel_object_prijemca->idTelefonu);
                        }
                    }
                }
            } else if (strcmp($odpoved, ODMIETNUTY) == 0) {
                if ($pouzivatel_object_prihlaseny != null) {
                    $this->Vztah_model->odpoved_na_ziadost($idZiadost, ODMIETNUTY);
                }
            }
        } else {
            redirect("prihlasovanie/odhlasit_sa");
        }
    }
}

?>