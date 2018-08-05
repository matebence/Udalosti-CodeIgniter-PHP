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

    public function pouzivatel_existuje($prihlasovacie_udaje)
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
}
?>