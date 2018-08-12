<?php

class Zaujem_model extends CI_model
{
    public function pouzivatel_bude_tam($zaujem = array())
    {
        $zaujem_o_udalost = $this->db->insert('zaujem', $zaujem);
        if ($zaujem_o_udalost) {
            return $this->db->insert_id();
        } else {
            return 0;
        }
    }

    public function pouzivatel_nebude_tam($id_zaujem)
    {
        $odstran = $this->db->delete('zaujem', array('idZaujem' => $id_zaujem));
        return $odstran ? true : false;
    }

    public function odstranenie_zaujmov_z_dovodu_odstranenia_uctu($id_pouzivatel)
    {
        $odstran = $this->db->delete('zaujem', array('idPouzivatel' => $id_pouzivatel));
        return $odstran ? true : false;
    }

    public function udalosti_o_ktorych_ma_pouzivatel_zaujem($id_pouzivatel, $od, $pocet)
    {
        $this->db->select('idZaujem, datum, nazov, mesto');
        $this->db->from('zaujem');
        $this->db->join("pouzivatel ", "zaujem.idPouzivatel=pouzivatel.idPouzivatel");
        $this->db->join("udalost", "zaujem.idUdalost=udalost.idUdalost");
        $this->db->where("datum >= CURDATE()");
        $this->db->where("pouzivatel.idPouzivatel", $id_pouzivatel);
        $this->db->order_by("datum", "asc");
        $this->db->limit($pocet, $od);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function pouzivatel_uz_nema_zaujem_o_udalost($id_zaujem)
    {
        $odstran = $this->db->delete('zaujem', array('idZaujem' => $id_zaujem));
        return $odstran ? true : false;
    }

    public function udalosti_kde_pouzivatel_bol($id_pouzivatel, $id_udalost, $od, $pocet)
    {
        $this->db->select('idZaujem, datum, nazov, mesto');
        $this->db->from('zaujem');
        $this->db->join("pouzivatel ", "zaujem.idPouzivatel=pouzivatel.idPouzivatel");
        $this->db->join("udalost", "zaujem.idUdalost=udalost.idUdalost");

        if ($id_udalost != null) {
            $this->db->where("udalost.idUdalost", $id_udalost);
        } else {
            $this->db->where("datum < CURDATE()");
        }

        $this->db->where("pouzivatel.idPouzivatel", $id_pouzivatel);

        $this->db->order_by("datum", "desc");
        $this->db->limit($pocet, $od);
        $query = $this->db->get();
        return $query->result_array();
    }
}

?>