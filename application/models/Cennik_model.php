<?php

class Cennik_model extends CI_model
{
    public function cennik($cennik= array())
    {
        $udaj = $this->db->insert('cennik', $cennik);
        if ($udaj) {
            return $this->db->insert_id();
        } else {
            return 0;
        }
    }

    public function aktualizuj_cennik($id_cennik, $udaje)
    {
        if (!empty($udaje)) {
            $this->db->where('idCennik', $id_cennik);
            $this->db->update('cennik', $udaje);
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