<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pozvanky extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Pozvanka_model');
        $this->load->model('Pouzivatel_model');
        $this->load->model('Udalost_model');
        $this->load->model('Vztah_model');

        $this->load->library('Firebase');
        $this->load->library('Oznamenia');
    }

    public function index()
    {
        $this->zoznam_neprecitanych_oznameni();
    }

    private function zoznam_neprecitanych_oznameni()
    {
        if (strcmp($this->input->post("token"), $this->Pouzivatel_model->token_pouzivatela($this->input->post("email"))) == 0) {
            $pouzivatel_object = $this->Pouzivatel_model->zisti_pouzivatela_podla_emailu($this->input->post("email"));
            if ($pouzivatel_object != null) {
                $data["oznamenia"] = $this->Pozvanka_model->zoznam_oznameni($pouzivatel_object->idPouzivatel, $this->input->post("od"), $this->input->post("pocet"));
                $data["ziadosti"] = $this->Vztah_model->zoznam_vztahov_cakajuci_na_odpoved($pouzivatel_object->idPouzivatel, $this->input->post("od"), $this->input->post("pocet"));
                $this->Pozvanka_model->precitaj_oznamenie($pouzivatel_object->idPouzivatel);
            }
            $this->load->view("json/json_vystup_dat", $data);
        } else {
            redirect("prihlasovanie/odhlasit_sa");
        }
    }

    public function nova_pozvanka()
    {
        if ((strcmp($this->input->post("token"), $this->Pouzivatel_model->token_pouzivatela($this->input->post("email"))) == 0) && ($this->input->post('pozvanka'))) {

            $pouzivatel_object_odosielatel = $this->Pouzivatel_model->zisti_pouzivatela_podla_emailu($this->input->post("email"));
            if ($pouzivatel_object_odosielatel != null) {
                $pozvanka = array(
                    "idUdalost" => $this->input->post('id_udalost'),
                    "idPouzivatelAkcia" => $pouzivatel_object_odosielatel->idPouzivatel,
                    "idPouzivatelOdpoved" => $this->input->post('pozvany'),
                    "precitana" => NOVA_POZVANKA
                );
                if ($this->Pozvanka_model->nova_pozvanka($pozvanka)) {
                    $this->session->set_flashdata('uspech', 'Pozvanka odoslaná.');
                    $pouzivatel_object_prijemca = $this->Pouzivatel_model->zisti_pouzivatela_podla_id($this->input->post("pozvany"));
                    $this->notifikacna_sprava($this->input->post('id_udalost'), $pouzivatel_object_odosielatel->meno, $pouzivatel_object_odosielatel->obrazok, $pouzivatel_object_prijemca->idTelefonu);
                } else {
                    $this->session->set_flashdata('chyba', 'Nastala chyba skuske ešte raz!');
                }
            }
            $this->load->view("json/json_vystup_odpoved");
        } else {
            redirect("prihlasovanie/odhlasit_sa");
        }
    }

    private function notifikacna_sprava($id_udalost, $meno, $obrazok, $id_telefonu)
    {
        $udalost = $this->Udalost_model->informacie_o_udalosti($id_udalost)[0];
        $host = "http://10.0.2.2/udalosti/";
        $precitana = "0";

        $this->oznamenia->set_obrazok($obrazok);
        $this->oznamenia->set_meno($meno);
        $this->oznamenia->set_id_udalost($id_udalost);
        $this->oznamenia->set_id_vztah("");
        $this->oznamenia->set_precitana($precitana);
        $this->oznamenia->set_nazov($udalost["nazov"]);
        $this->oznamenia->set_mesto($udalost["mesto"]);
        $this->oznamenia->set_udalost($host . $udalost["obrazok"]);

        $json = '';
        $odpoved = '';

        $json = $this->oznamenia->ziskaj_spravu();
        $odpoved = $this->firebase->posli_jednemu($id_telefonu, $json);
    }
}
?>