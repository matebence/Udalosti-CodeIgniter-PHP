<?php

class Rola_model extends CI_model
{
    public function rola($rola= array())
    {
        $udaj = $this->db->insert('rola', $rola);
        if ($udaj) {
            return $this->db->insert_id();
        } else {
            return 0;
        }
    }

    public function aktualizuj_rolu($id_rola, $udaj)
    {
        if (!empty($udaj)) {
            $this->db->where('idRola', $id_rola);
            $this->db->update('rola', $udaj);
            return true;
        } else {
            return false;
        }
    }

    public function odstran_rolu($id_rola)
    {
        $odstran = $this->db->delete('rola', array('idRola' => $id_rola));
        return $odstran ? true : false;
    }

    public function pouzivatel($typ_roli)
    {
        $this->db->select('idRola');
        $this->db->from('rola');
        $this->db->where('nazov', $typ_roli);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $riadok = $query->row();
            return $riadok->idRola;
        } else {
            return 0;
        }
    }
}
?>