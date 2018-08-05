<?php

class Rola_model extends CI_model
{
    public function nova_rola($nova_rola = array())
    {
        $rola = $this->db->insert('rola', $nova_rola);
        if ($rola) {
            return $this->db->insert_id();
        } else {
            return 0;
        }
    }

    public function aktualizuj_rolu($id_rola, $aktualizacne_udaje)
    {
        if (!empty($aktualizacne_udaje)) {
            $this->db->where('idRola', $id_rola);
            $this->db->update('rola', $aktualizacne_udaje);
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

    public function rola($typ_roli)
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