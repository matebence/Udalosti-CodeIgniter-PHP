<?php

class Pouzivatel_model extends CI_model
{
    public function pouzivatel($pouzivatel= array())
    {
        $udaj = $this->db->insert('pouzivatel', $pouzivatel);
        if ($udaj) {
            return $this->db->insert_id();
        } else {
            return 0;
        }
    }

    public function aktualizuj_pouzivatela($email, $udaj)
    {
        if (!empty($udaj)) {
            $this->db->where('email', $email);
            $this->db->update('pouzivatel', $udaj);
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

    public function existuje($prihlasovacie_udaje)
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

    public function token($email){
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