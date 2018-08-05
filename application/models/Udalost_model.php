<?php

class Udalost_model extends CI_model
{
    public function nova_udalost($nova_udalost = array())
    {
        $udalost = $this->db->insert('udalost', $nova_udalost);
        if ($udalost) {
            return $this->db->insert_id();
        } else {
            return 0;
        }
    }

    public function aktualizuj_udalost($id_udalost, $aktualizacne_udaje)
    {
        if (!empty($aktualizacne_udaje)) {
            $this->db->where('idUdalost', $id_udalost);
            $this->db->update('udalost', $aktualizacne_udaje);
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
        $this->db->select('idZaujem, udalost.idUdalost, obrazok, nazov, datum, cas, mesto');
        $this->db->from('zaujem');
        $this->db->join('udalost', 'udalost.idUdalost = zaujem.idUdalost', "right");
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
        $this->db->select('idZaujem, udalost.idUdalost, obrazok, nazov, datum, cas, mesto');
        $this->db->from('zaujem');
        $this->db->join('udalost', 'udalost.idUdalost = zaujem.idUdalost', "right");
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