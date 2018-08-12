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

    public function zoznam_pribudnutych_udalosti($stat,$okres,$mesto, $id_udalost, $datum, $pozicia)
    {
        $this->db->select('idZaujem, udalost.idUdalost, obrazok, nazov, datum, cas, mesto');
        $this->db->from('zaujem');
        $this->db->join('udalost', 'udalost.idUdalost = zaujem.idUdalost', "right");
        $this->db->join('cennik', 'cennik.idCennik = udalost.idCennik');

        if ($pozicia) {
            if ($stat != null) {
                $this->db->where("(stat = '".$stat."'");
            }
            if ($okres != null) {
                $this->db->where("(okres = '".$okres."'");
            }
            if ($mesto != null) {
                $this->db->or_where("(mesto = '".$mesto."')");
            }
        } else {
            if ($stat != null) {
                $this->db->where("stat", $stat);
            }
        }

        $this->db->where("datum <=", $datum);
        $this->db->where("datum >= CURDATE()");
        $this->db->where("udalost.timestamp >= (SELECT timestamp FROM udalost WHERE idUdalost = " . $id_udalost . ")");
        $this->db->where("udalost.idUdalost >", $id_udalost);
        $this->db->limit(TOP_5);
        $this->db->order_by("vaha", "desc");
        $this->db->order_by("datum", "asc");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function vyhladavenie_udalosti($nazov, $stat)
    {
        $this->db->select('idZaujem, udalost.idUdalost, obrazok, nazov, datum, cas,mesto');
        $this->db->from('zaujem');
        $this->db->join('udalost', 'udalost.idUdalost = zaujem.idUdalost', "right");
        $this->db->join('cennik', 'cennik.idCennik = udalost.idCennik');
        if ($stat != null) {
            $this->db->where("stat", $stat);
        }
        $this->db->where("datum >= CURDATE()");
        $this->db->like("nazov", $nazov);
        $this->db->order_by("vaha", "desc");
        $this->db->order_by("datum", "asc");
        $this->db->order_by("udalost.timestamp", "desc");
        $this->db->limit(TOP_5);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function zisti_udalosti_v_okoli($stat, $okres, $mesto)
    {
        $this->db->select('idZaujem, udalost.idUdalost, obrazok, nazov, datum, cas, mesto');
        $this->db->from('zaujem');
        $this->db->join('udalost', 'udalost.idUdalost = zaujem.idUdalost', "right");
        $this->db->join('cennik', 'cennik.idCennik = udalost.idCennik');
         if ($stat != null) {
            $podmienka = "";
            if ($okres == null) {
                $podmienka = "(stat ='" . $stat . "')";
            } else {
                $podmienka = "(stat ='" . $stat . "'";
            }
            $this->db->or_where($podmienka);
        }
        if ($okres != null) {
            $podmienka = "";
            if ($mesto == null) {
                $podmienka = "okres ='" . $okres . "')";
            } else {
                $podmienka = "okres ='" . $okres . "'";
            }
            $this->db->where($podmienka);
        }
        if ($mesto != null) {
            $this->db->where("mesto ='" . $mesto . "')");
        }
        $this->db->where("(datum >= CURDATE())");
        $this->db->order_by("vaha", "desc");
        $this->db->order_by("datum", "asc");
        $this->db->order_by("udalost.timestamp", "desc");
        $this->db->limit(TOP_10);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function informacie_o_udalosti($id_udalost)
    {
        $this->db->select('idZaujem, udalost.idUdalost, obrazok, nazov, datum, cas, mesto');
        $this->db->from('zaujem');
        $this->db->join('udalost', 'udalost.idUdalost = zaujem.idUdalost', "right");
        $this->db->where("udalost.idUdalost", $id_udalost);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function na_udalost_pridu($id_udalost)
    {
        $this->db->select('idPouzivatel, pouzivatel.meno');
        $this->db->from('udalost');
        $this->db->join('zaujem', 'udalost.idUdalost = zaujem.idUdalost');
        $this->db->join('pouzivatel', 'pouzivatel.idPouzivatel = zaujem.idPouzivatel');
        $this->db->where("udalost.idUdalost", $id_udalost);
        $query = $this->db->get();
        return $query->result_array();
    }
}

?>