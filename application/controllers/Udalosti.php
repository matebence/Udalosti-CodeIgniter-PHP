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
        $this->load->model('Pouzivatel_model');
    }

    public function index()
    {
        $this->zoznam_udalosti();
    }

    private function zoznam_udalosti()
    {
        if ((strcmp($this->input->post("token"), $this->Pouzivatel_model->token($this->input->post("email"))) == 0 && ($this->input->post("email")))) {
            $data["udalosti"] = $this->Udalost_model->zoznam_udalosti(
                $this->input->post("stat"));
            $this->load->view("json/json_vystup_dat", $data);
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    public function udalosti_podla_pozicie()
    {
        if ((strcmp($this->input->post("token"), $this->Pouzivatel_model->token($this->input->post("email"))) == 0) && ($this->input->post("email"))) {
            $data["udalosti"] = $this->Udalost_model->zoznam_udalosti_v_okoli(
                $this->input->post("stat"),
                $this->input->post("okres"),
                $this->input->post("mesto"));
            $this->load->view("json/json_vystup_dat", $data);
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    public function nova_udalost(){
        if ($this->session->userdata('email_admina')) {
            
        } else {
            redirect("prihlasenie/pristup");
        }
    }

    private function validacia_vstupnych_udajov_novej_udalosti()
    {
        $this->form_validation->set_rules('cennik',
            'Váha danej udalosti podľa cenníka',
            'required|numeric',
            array('required' => 'Cenník nebol vybratí',
                'numeric' => 'Nesprávny formát cenníka!'));
        $this->form_validation->set_rules('nazov',
            'Názov udalosti',
            'required|min_length[3]|max_length[20]|alpha',
            array('required' => 'Nesprávny formát názvu!',
                'min_length' => 'Nesprávny formát názvu!',
                'max_length' => 'Nesprávny formát názvu!',
                'alpha' => 'Nesprávny formát názvu!'));
        $this->form_validation->set_rules('datum',
            'Dátum kedy sa udalosť koná',
            'required',
            array('required' => 'Dátum nie je vyplnené'));
        $this->form_validation->set_rules('cas',
            'Čas kedy sa udalosť koná',
            'required',
            array('required' => 'Čas nie je vyplnené'));
        $this->form_validation->set_rules('miesto',
            'Miesto kde sa udalosť koná',
            'required|min_length[3]|max_length[20]|alpha',
            array('required' => 'Nesprávny formát miesta!',
                'min_length' => 'Nesprávny formát miesta!',
                'max_length' => 'Nesprávny formát miesta!',
                'alpha' => 'Nesprávny formát miesta!'));
        $this->form_validation->set_rules('stat',
            'Štát kde sa udalosť koná',
            'required|min_length[3]|max_length[20]|alpha',
            array('required' => 'Nesprávny formát štátu!',
                'min_length' => 'Nesprávny formát štátu!',
                'max_length' => 'Nesprávny formát štátu!',
                'alpha' => 'Nesprávny formát štátu!'));
        $this->form_validation->set_rules('okres',
            'Okres kde sa udalosť koná',
            'required|min_length[3]|max_length[20]|alpha',
            array('required' => 'Nesprávny formát okresu!',
                'min_length' => 'Nesprávny formát okresu!',
                'max_length' => 'Nesprávny formát okresu!',
                'alpha' => 'Nesprávny formát okresu!'));
          $this->form_validation->set_rules('mesto',
            'Mesto kde sa udalosť koná',
            'required|min_length[3]|max_length[20]|alpha',
            array('required' => 'Nesprávny formát mesta!',
                'min_length' => 'Nesprávny formát mesta!',
                'max_length' => 'Nesprávny formát mesta!',
                'alpha' => 'Nesprávny formát mesta!'));
        if ($this->form_validation->run() == true) {
            return true;
        } else {
            return false;
        }
    }

    private function fotka_udalosti()
    {
        $config['upload_path'] = './uploads';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 8000;
        $config['max_width'] = 1500;
        $config['max_height'] = 1000;
        $config['overwrite'] = FALSE;
        $config['encrypt_name'] = TRUE;

        $this->upload->initialize($config);
        if (!$this->upload->do_upload('obrazok')) {
            return "";
        } else {
            $meta_data_obrazka = $this->upload->data();
            return $this->velkost_obrazka($meta_data_obrazka, 1350, 900);
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
}
?>