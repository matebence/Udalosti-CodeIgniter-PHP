<?php

class Pouzivatel_model extends CI_model
{
    public function novy_pouzivatel($novy_pouzivatel = array())
    {
        $novy = $this->db->insert('pouzivatel', $novy_pouzivatel);
        if ($novy) {
            return $this->db->insert_id();
        } else {
            return 0;
        }
    }

    public function aktualizuj_pouzivatela($email, $aktualizacne_udaje)
    {
        if (!empty($aktualizacne_udaje)) {
            $this->db->where('email', $email);
            $this->db->update('pouzivatel', $aktualizacne_udaje);
            return true;
        } else {
            return false;
        }
    }

    public function odstran_pouzivatela($id_pouzivatel)
    {
        $odstran = $this->db->delete('pouzivatel', array('idPouzivatel' => $id_pouzivatel));
        return $odstran ? true : false;
    }

    public function nove_heslo_pouzivatela($email, $nove_heslo)
    {
        if (!empty($nove_heslo)) {
            $this->db->where('md5(email)', $email);
            $this->db->update('pouzivatel', $nove_heslo);
            return true;
        } else {
            return false;
        }
    }

    public function zisti_pouzivatela_podla_emailu($email)
    {
        $this->db->select('meno, heslo, obrazok, idPouzivatel, idTelefonu');
        $this->db->from('pouzivatel');
        $this->db->where('email', $email);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $riadok = $query->row();
            return $riadok;
        } else {
            return null;
        }
    }

    public function zisti_pouzivatela_podla_id($id_pouzivatel)
    {
        $this->db->select('meno, heslo, obrazok, idPouzivatel, idTelefonu');
        $this->db->from('pouzivatel');
        $this->db->where('idPouzivatel', $id_pouzivatel);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $riadok = $query->row();
            return $riadok;
        } else {
            return null;
        }
    }

    public function zisti_ci_pouzivatel_existuje($prihlasovacie_udaje)
    {
        $this->db->select('heslo');
        $this->db->from('pouzivatel');
        $this->db->where('email', $prihlasovacie_udaje['email']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $riadok = $query->row();
            return $riadok->heslo;
        } else {
            return null;
        }
    }

    public function token_pouzivatela($email){
        $this->db->select('token');
        $this->db->from('pouzivatel');
        $this->db->where('email', $email);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return  $query->row()->token;
        }else{
            return "";
        }
    }
}
?>