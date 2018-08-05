<?php

class Udalost_model extends CI_model
{
    public function udalost($udalost= array())
    {
        $udaj = $this->db->insert('udalost', $udalost);
        if ($udaj) {
            return $this->db->insert_id();
        } else {
            return 0;
        }
    }

    public function aktualizuj_udalost($id_udalost, $udaj)
    {
        if (!empty($udaj)) {
            $this->db->where('idUdalost', $id_udalost);
            $this->db->update('udalost', $udaj);
            return true;
        } else {
            return false;
        }
    }

    public function odstran_udalost($id_udalost)
    {
        $odstran = $this->db->delete('udalost', array('idUdalost' => $id_udalost));
        return $odstran ? true : false;
    }

    public function zoznam_udalosti($stat, $od, $pocet)
    {
        $this->db->select('udalost.idUdalost, obrazok, nazov, datum, cas, miesto');
        $this->db->from('udalost');
        $this->db->join('cennik', 'cennik.idCennik = udalost.idCennik');
        if ($stat != null) {
            $this->db->where("stat", $stat);
        }
        $this->db->where("datum >= CURDATE()");
        $this->db->order_by("vaha", "desc");
        $this->db->order_by("datum", "asc");
        $this->db->order_by("udalost.timestamp", "desc");
        $this->db->limit($pocet, $od);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function zoznam_udalosti_v_okoli($stat, $okres, $mesto)
    {
        $this->db->select('udalost.idUdalost, obrazok, nazov, datum, cas, miesto');
        $this->db->from('udalost');
        $this->db->join('cennik', 'cennik.idCennik = udalost.idCennik');
        if ($stat != null) {
            $this->db->or_where("(stat ='" . $stat . "'");
        }
        if ($okres != null) {
            $this->db->or_where("okres ='" . $okres . "'");
        }
        if ($mesto != null) {
            $this->db->or_where("mesto ='" . $mesto . "')");
        }
        $this->db->where("(datum >= CURDATE())");
        $this->db->order_by("vaha", "desc");
        $this->db->order_by("datum", "asc");
        $this->db->order_by("udalost.timestamp", "desc");
        $this->db->limit(TOP_10);
        $query = $this->db->get();
        return $query->result_array();
    }
}
?>