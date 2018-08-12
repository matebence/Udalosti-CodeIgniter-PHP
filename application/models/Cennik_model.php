<?php

class Cennik_model extends CI_model
{
    public function novy_cennik($cena = array())
    {
        $nova_cena = $this->db->insert('cennik', $cena);
        if ($nova_cena) {
            return $this->db->insert_id();
        } else {
            return 0;
        }
    }

    public function aktualizuj_cennik($id_cennik, $aktualizacne_udaje)
    {
        if (!empty($aktualizacne_udaje)) {
            $this->db->where('idCennik', $id_cennik);
            $this->db->update('cennik', $aktualizacne_udaje);
            return true;
        } else {
            return false;
        }
    }

    public function odstran_cennik($id_cennik)
    {
        $odstran = $this->db->delete('cennik', array('idCennik' => $id_cennik));
        return $odstran ? true : false;
    }
}

?>