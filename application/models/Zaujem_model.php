<?php

class Zaujem_model extends CI_model
{
    public function vytvorit($zaujem = array())
    {
        $udaj = $this->db->insert('zaujem', $zaujem);
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
            $this->db->update('zaujem', $udaj);
            return true;
        } else {
            return false;
        }
    }

    public function odstran($id_udalost, $id_pouzivatel)
    {
        $odstran = $this->db->delete('zaujem', array('idUdalost' => $id_udalost, 'idPouzivatel' => $id_pouzivatel));
        return $odstran ? true : false;
    }

    public function zoznam($id_pouzivatel)
    {
        $this->db->select('nazov, mesto, datum, COUNT(*) as pocet');
        $this->db->from('zaujem');
        $this->db->join('udalost', 'zaujem.idUdalost = udalost.idUdalost');
        $this->db->join('miesto', 'udalost.idMiesto = miesto.idMiesto ');
        $this->db->join('pouzivatel', 'zaujem.idPouzivatel = pouzivatel.idPouzivatel');
        $this->db->join('organizator', 'organizator.idUdalost = udalost.idUdalost');

        if ($id_pouzivatel > 0) {
            $this->db->where("organizator.idPouzivatel", $id_pouzivatel);
        }

        $this->db->group_by('zaujem.idUdalost');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return 0;
    }

    public function zaujmy($email)
    {
        $this->db->select("udalost.idUdalost, obrazok, nazov, DATE_FORMAT(datum,'%m') as den, MONTHNAME(datum) as mesiac, DATE_FORMAT(cas, '%H:%i') as cas, mesto, ulica, vstupenka, COUNT(zaujem.idUdalost) as zaujemcovia, IF(SUM(pouzivatel.email = '" . $email . "') > 0, 1, 0) as zaujem");
        $this->db->from('zaujem');
        $this->db->join('udalost', 'udalost.idUdalost = zaujem.idUdalost', 'right');
        $this->db->join('pouzivatel', 'pouzivatel.idPouzivatel = zaujem.idPouzivatel', 'left');
        $this->db->join('cennik', 'udalost.idCennik = cennik.idCennik');
        $this->db->join('miesto', 'udalost.idMiesto = miesto.idMiesto');
        $this->db->group_by("udalost.idUdalost");
        $this->db->order_by("datum", "asc");

        $pomocna_tabulka = $this->db->get_compiled_select();

        $this->db->select('*');
        $this->db->from("($pomocna_tabulka) as zaujmy");
        $this->db->where("zaujem", true);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function potvrdenie_zaujmu($id_udalost, $email)
    {
        $this->db->select("udalost.idUdalost, obrazok, nazov, DATE_FORMAT(datum,'%m') as den, MONTHNAME(datum) as mesiac, DATE_FORMAT(cas, '%H:%i') as cas, mesto, ulica, vstupenka, COUNT(zaujem.idUdalost) as zaujemcovia, IF(SUM(pouzivatel.email = '" . $email . "') > 0, 1, 0) as zaujem");
        $this->db->from('zaujem');
        $this->db->join('udalost', 'udalost.idUdalost = zaujem.idUdalost', 'right');
        $this->db->join('pouzivatel', 'pouzivatel.idPouzivatel = zaujem.idPouzivatel', 'left');
        $this->db->join('miesto', 'udalost.idMiesto = miesto.idMiesto');
        $this->db->where("udalost.idUdalost", $id_udalost);
        $query = $this->db->get();
        return $query->result_array();
    }
}

?>