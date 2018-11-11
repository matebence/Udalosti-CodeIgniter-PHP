<?php

class Cennik_model extends CI_model
{
    public function vytvorit($cennik = array())
    {
        $udaj = $this->db->insert('cennik', $cennik);
        if ($udaj) {
            return $this->db->insert_id();
        } else {
            return 0;
        }
    }

    public function aktualizuj($id_cennik, $udaje)
    {
        if (!empty($udaje)) {
            $this->db->where('idCennik', $id_cennik);
            $this->db->update('cennik', $udaje);
            return true;
        } else {
            return false;
        }
    }

    public function odstran($id_cennik)
    {
        $odstran = $this->db->delete('cennik', array('idCennik' => $id_cennik));
        return $odstran ? true : false;
    }

    public function zoznam()
    {
        $this->db->select('*');
        $this->db->from('cennik');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return 0;
    }

    public function informacia($id_cennik)
    {
        $this->db->select('vaha, suma');
        $this->db->from('cennik');
        $this->db->where("idCennik", $id_cennik);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array()[0];
        }
        return null;
    }

    public function pocet()
    {
        $this->db->select('idCennik, COUNT(*) AS Pocet');
        $this->db->from('udalost');
        $this->db->group_by('idCennik');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return 0;
    }
}

?>