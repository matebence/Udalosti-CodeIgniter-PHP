<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Zaujmy extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Zaujem_model');
        $this->load->model('Pouzivatel_model');
    }

    public function index()
    {
        $this->ukaz_buduce_udalosti_podla_datumu();
    }

    private function ukaz_buduce_udalosti_podla_datumu()
    {
        if (strcmp($this->input->post("token"), $this->Pouzivatel_model->token_pouzivatela($this->input->post("email"))) == 0) {
            $pouzivatel_object = $this->Pouzivatel_model->zisti_pouzivatela_podla_emailu($this->input->post("email"));
            if ($pouzivatel_object != null) {
                $data["buduce_udalosti"] = $this->Zaujem_model->udalosti_o_ktorych_ma_pouzivatel_zaujem($pouzivatel_object->idPouzivatel, $this->input->post("od"), $this->input->post("pocet"));
            }
            $this->load->view("json/json_vystup_dat", $data);
        } else {
            redirect("prihlasovanie/odhlasit_sa");
        }
    }

    public function zaujem_o_udalost()
    {
        if ((strcmp($this->input->post("token"), $this->Pouzivatel_model->token_pouzivatela($this->input->post("email"))) == 0) && ($this->input->post('zaujem'))) {

            $pouzivatel_object = $this->Pouzivatel_model->zisti_pouzivatela_podla_emailu($this->input->post("email"));
            if ($pouzivatel_object != null) {
                $zaujem = array(
                    "idUdalost" => $this->input->post('id_udalost'),
                    "idPouzivatel" => $pouzivatel_object->idPouzivatel
                );

                $udaj = $this->Zaujem_model->udalosti_kde_pouzivatel_bol($pouzivatel_object->idPouzivatel, $this->input->post('id_udalost'), $this->input->post("od"), $this->input->post("pocet"));
                if (empty($udaj)) {
                    if ($this->Zaujem_model->pouzivatel_bude_tam($zaujem)) {
                        $this->session->set_flashdata('uspech', 'Udalosť bola označena a pridaná do kalendára.');
                    } else {
                        $this->session->set_flashdata('chyba', 'Nastala chyba skuske ešte raz!');
                    }
                } else {
                    $this->Zaujem_model->pouzivatel_uz_nema_zaujem_o_udalost($udaj[0]["idZaujem"]);
                    $this->session->set_flashdata('uspech', 'Udalosť bola odobraná z kalendára.');
                }
            }
            $this->load->view("json/json_vystup_odpoved");
        } else {
            redirect("prihlasovanie/odhlasit_sa");
        }
    }

    public function odstranenie_zo_zaujmov()
    {
        if (($this->input->post('odstranenie')) && (strcmp($this->input->post("token"), $this->Pouzivatel_model->token_pouzivatela($this->input->post("email"))) == 0)) {
            if ($this->Zaujem_model->pouzivatel_uz_nema_zaujem_o_udalost($this->input->post('udalost'))) {
                $this->session->set_flashdata('uspech', 'Udalosť bola odobraná z kalendára.');
            } else {
                $this->session->set_flashdata('chyba', 'Nastala chyba skuske ešte raz!');
            }
            $this->load->view("json/json_vystup_odpoved");
        } else {
            redirect("prihlasovanie/odhlasit_sa");
        }
    }
}

?>