<?php

class Udalost_model extends CI_model
{
    public function udalost($udalost = array())
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

    public function zoznam_udalosti($stat)
    {
        $this->db->select("udalost.idUdalost, obrazok, nazov, DAY(datum) as den, MONTHNAME(datum) as mesiac, DATE_FORMAT(cas, '%H:%i') as cas, mesto, miesto");
        $this->db->from('udalost');
        $this->db->join('cennik', 'cennik.idCennik = udalost.idCennik');
        if ($stat != null) {
            $this->db->where("stat", $stat);
        }
        $this->db->where("datum >= CURDATE()");
        $this->db->order_by("datum", "asc");
        $this->db->order_by("vaha", "desc");
        $this->db->order_by("udalost.timestamp", "desc");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function zoznam_udalosti_v_okoli($stat, $okres, $mesto)
    {
        $this->db->select("udalost.idUdalost, obrazok, nazov, DAY(datum) as den, MONTHNAME(datum) as mesiac, DATE_FORMAT(cas, '%H:%i') as cas, mesto, miesto");
        $this->db->from('udalost');
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
        $this->db->order_by("datum", "asc");
        $this->db->order_by("vaha", "desc");
        $this->db->order_by("udalost.timestamp", "desc");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function pocet_udalosti(){
        $this->db->select('nazov');
        $this->db->from('udalost');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return 0;
    }

    public function informacia_o_udalosti($idUdalost){
        $this->db->select('*');
        $this->db->from('udalost');
        $this->db->where("idUdalost", $idUdalost);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array()[0];
        }
        return null;
    }

    public function vsetky_udalosti(){
        $this->db->select('*');
        $this->db->from('udalost');
        $this->db->order_by("udalost.timestamp", "desc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }

    public function udalosti_podla_okresu(){
        $this->db->select('okres, COUNT(*) AS Pocet');
        $this->db->from('udalost');
        $this->db->group_by('okres');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return 0;
    }

    public function udalosti_podla_statu(){
        $this->db->select('stat, COUNT(*) AS Pocet');
        $this->db->from('udalost');
        $this->db->group_by('stat');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return 0;
    }

    public function pocet_udalosti_v_mesiaci(){
        $this->db->select('MONTHNAME(datum) AS Mesiac, COUNT(*) AS Pocet');
        $this->db->from('udalost');
        $this->db->order_by('MONTHNAME(datum)', 'desc');
        $this->db->group_by('MONTHNAME(datum)');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return 0;
    }
}
?>