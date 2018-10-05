<?php

class Zaujem_model extends CI_model
{
    public function zaujem($zaujem = array())
    {
        $udaj = $this->db->insert('zaujem', $zaujem);
        if ($udaj) {
            return $this->db->insert_id();
        } else {
            return 0;
        }
    }

    public function aktualizuj_zaujem($id_zaujem, $udaj)
    {
        if (!empty($udaj)) {
            $this->db->where('idZaujem', $id_zaujem);
            $this->db->update('zaujem', $udaj);
            return true;
        } else {
            return false;
        }
    }

    public function odstran_zaujem($id_zaujem)
    {
        $odstran = $this->db->delete('zaujem', array('idZaujem' => $id_zaujem));
        return $odstran ? true : false;
    }

    public function zaujmy_pouzivatelov()
    {
        $this->db->select('nazov, COUNT(*) as pocet');
        $this->db->from('zaujem');
        $this->db->join('udalost', 'zaujem.idUdalost = udalost.idUdalost');
        $this->db->join('pouzivatel', 'zaujem.idPouzivatel = pouzivatel.idPouzivatel');
        $this->db->group_by('zaujem.idUdalost');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return 0;
    }
}

?>