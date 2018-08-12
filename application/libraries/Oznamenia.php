<?php

class Oznamenia
{
    private $obrazok;
    private $meno;
    private $id_udalost;
    private $id_vztah;
    private $precitana;
    private $nazov;
    private $mesto;
    private $udalost;

    function __construct() {
    }

    public function set_obrazok($obrazok){
        $this->obrazok = $obrazok;
    }

    public function set_meno($meno){
        $this->meno = $meno;
    }

    public function set_id_udalost($id_udalost){
        $this->id_udalost = $id_udalost;
    }

    public function set_id_vztah($id_vztah){
        $this->id_vztah = $id_vztah;
    }

    public function set_precitana($precitana){
        $this->precitana = $precitana;
    }

    public function set_nazov($nazov){
        $this->nazov = $nazov;
    }

    public function set_mesto($mesto){
        $this->mesto = $mesto;
    }

    public function set_udalost($udalost){
        $this->udalost = $udalost;
    }

    public function ziskaj_spravu() {
        $json = array();
        $json['oznamenie']['obrazok'] = $this->obrazok;
        $json['oznamenie']['meno'] = $this->meno;
        $json['oznamenie']['id_udalost'] = $this->id_udalost;
        $json['oznamenie']['id_vztah'] = $this->id_vztah;
        $json['oznamenie']['precitana'] = $this->precitana;
        $json['oznamenie']['nazov'] = $this->nazov;
        $json['oznamenie']['mesto'] = $this->mesto;
        $json['oznamenie']['udalost'] = $this->udalost;
        $json['oznamenie']['timestamp'] = date('Y-m-d G:i:s');
        return $json;
    }
}
?>