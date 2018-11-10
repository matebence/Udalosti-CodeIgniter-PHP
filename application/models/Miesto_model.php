<?php

class Miesto_model extends CI_model
{
    public function vytvorit($miesto = array())
    {
        $udaj = $this->db->insert('miesto', $miesto);
        if ($udaj) {
            return $this->db->insert_id();
        } else {
            return 0;
        }
    }

    public function aktualizuj($id_miesto, $udaj)
    {
        if (!empty($udaj)) {
            $this->db->where('idMiesto', $id_miesto);
            $this->db->update('miesto', $udaj);
            return true;
        } else {
            return false;
        }
    }

    public function odstran($id_miesto)
    {
        $odstran = $this->db->delete('miesto', array('idMiesto' => $id_miesto));
        return $odstran ? true : false;
    }

    public function zoznam($id_pouzivatel)
    {
        $this->db->select('stat, okres, mesto');
        $this->db->from('miesto');
        $this->db->join('udalost', 'miesto.idMiesto = udalost.idMiesto');
        $this->db->join('organizator', 'organizator.idUdalost = udalost.idUdalost');

        if ($id_pouzivatel > 0) {
            $this->db->where("organizator.idPouzivatel", $id_pouzivatel);
        }

        $this->db->where("datum >= CURDATE()");
        $this->db->group_by('mesto');
        $this->db->order_by("datum", "asc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }
}

?>