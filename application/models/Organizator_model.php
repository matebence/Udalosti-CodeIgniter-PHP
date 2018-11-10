<?php

class Organizator_model extends CI_model
{
    public function vytvorit($organizator = array())
    {
        $udaj = $this->db->insert('organizator', $organizator);
        if ($udaj) {
            return $this->db->insert_id();
        } else {
            return 0;
        }
    }

    public function aktualizuj($id_pouzivatel, $udaj)
    {
        if (!empty($udaj)) {
            $this->db->where('idPouzivatel', $id_pouzivatel);
            $this->db->update('organizator', $udaj);
            return true;
        } else {
            return false;
        }
    }

    public function odstran($id_udalost, $id_pouzivatel)
    {
        $odstran = $this->db->delete('organizator', array('idUdalost' => $id_udalost, 'idPouzivatel' => $id_pouzivatel));
        return $odstran ? true : false;
    }

    public function zoznam($email, $stav)
    {
        $this->db->select('*');
        $this->db->from('organizator');
        $this->db->join('pouzivatel', 'organizator.idPouzivatel = pouzivatel.idPouzivatel');
        $this->db->join('udalost', 'organizator.idUdalost = udalost.idUdalost');
        $this->db->join('cennik', 'udalost.idCennik = cennik.idCennik');
        $this->db->join('miesto', 'udalost.idMiesto = miesto.idMiesto');

        if ($stav != null) {
            $this->db->where("udalost.stav", $stav);
        }
        if ($email != null) {
            $this->db->where("pouzivatel.email", $email);
        }

        $this->db->order_by("udalost.timestamp", "desc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }
}

?>