<?php

class Vztah_model extends CI_model
{
    public function novy_mozny_vztah($prihlaseny_pouzivatel, $novy_mozny_priatel)
    {
        $novy_mozny_vztah = $this->db->insert('vztah', $this->zisti_mensie_id($prihlaseny_pouzivatel, $novy_mozny_priatel, CAKAJUCI, $prihlaseny_pouzivatel));
        if ($novy_mozny_vztah) {
            return $this->db->insert_id();
        } else {
            return -1;
        }
    }

    public function odstranenie_vztahov_z_dovodu_odstranenia_uctu($idPouzivatel)
    {
        $odstran = $this->db->delete('vztah', array('idPouzivatelAkcia' => $idPouzivatel, 'idPouzivatelOdpoved' => $idPouzivatel));
        return $odstran ? true : false;
    }

    public function odstranenie_vztahu($idPouzivatelA, $idPouzivatelB)
    {
        $odstran = $this->db->delete('vztah', array('idPouzivatelAkcia' => $idPouzivatelA, 'idPouzivatelOdpoved' => $idPouzivatelB));
        if (!$odstran) {
            $odstran = $this->db->delete('vztah', array('idPouzivatelAkcia' => $idPouzivatelB, 'idPouzivatelOdpoved' => $idPouzivatelA));
        }
        return $odstran ? true : false;
    }

    public function odpoved_na_ziadost($idVztah, $odpoved)
    {
        $this->db->where('idVztah', $idVztah);
        if ($this->db->update('vztah', array("status" => $odpoved))) {
            return true;
        } else {
            return false;
        }
    }

    public function spatna_odpoved_na_ziadost($id_vztah, $id_pouzivatel)
    {
        $select_prva_tabulka = "SELECT idPouzivatelOdpoved AS Pouzivatel FROM vztah WHERE idVztah = '" . $id_vztah . "' AND idPouzivatelAkcia = '" . $id_pouzivatel . "'";
        $union = "UNION ";
        $select_druha_tabulka = "SELECT idPouzivatelAkcia AS Pouzivatel FROM vztah WHERE idVztah = '" . $id_vztah . "' AND idPouzivatelOdpoved = '" . $id_pouzivatel . "'";
        $query = $this->db->query($select_prva_tabulka . $union . $select_druha_tabulka);
        $riadok = $query->row();
        return $riadok->Pouzivatel;
    }

    public function zoznam_vztahov_cakajuci_na_odpoved($id_pouzivatel, $od, $pocet)
    {
        $select_prva_tabulka = "SELECT vztah.idVztah, pouzivatel.meno, pouzivatel.obrazok ";
        $from_prva_tabulka = "FROM vztah ";
        $join_prva_tabulka = "JOIN pouzivatel ON pouzivatel.idPouzivatel = vztah.idPouzivatelOdpoved ";
        $where_prva_tabulka = "WHERE idPouzivatelAkcia =" . $id_pouzivatel . " AND status = '" . CAKAJUCI . "' AND akcia != '" . $id_pouzivatel . "'";

        $union = "UNION ";

        $select_druha_tabulka = "SELECT vztah.idVztah, pouzivatel.meno, pouzivatel.obrazok ";
        $from_druha_tabulka = "FROM vztah ";
        $join_druha_tabulka = "JOIN pouzivatel ON pouzivatel.idPouzivatel = vztah.idPouzivatelAkcia ";
        $where_druha_tabulka = "WHERE idPouzivatelOdpoved =" . $id_pouzivatel . " AND status = '" . CAKAJUCI . "' AND akcia != '" . $id_pouzivatel . "'";
        $limit = "LIMIT " . $od . ", " . $pocet;

        $query = $this->db->query($select_prva_tabulka . $from_prva_tabulka . $join_prva_tabulka . $where_prva_tabulka . $union . $select_druha_tabulka . $from_druha_tabulka . $join_druha_tabulka . $where_druha_tabulka . $limit);
        return $query->result_array();
    }

    public function zisi_priatelsvo($prihlaseny_pouzivatel, $mozny_priatel, $stav)
    {
        $this->db->select('idVztah');
        $this->db->from('vztah');

        if ($prihlaseny_pouzivatel < $mozny_priatel) {
            $this->db->where("idPouzivatelAkcia", $prihlaseny_pouzivatel);
            $this->db->where("idPouzivatelOdpoved", $mozny_priatel);
        } else {
            $this->db->where("idPouzivatelAkcia", $mozny_priatel);
            $this->db->where("idPouzivatelOdpoved", $prihlaseny_pouzivatel);
        }
        if ($stav) {
            $this->db->where("(status = " . PRIJATI);
            $this->db->or_where("status = " . CAKAJUCI);
            $this->db->or_where("status = " . ODMIETNUTY . ")");

        } else {
            $this->db->where("status", PRIJATI);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function zoznam_priatelov($id_pouzivatel, $od, $pocet)
    {
        $select_prva_tabulka = "SELECT idPouzivatel, pouzivatel.meno, obrazok ";
        $from_prva_tabulka = "FROM vztah ";
        $join_prva_tabulka = "JOIN pouzivatel ON pouzivatel.idPouzivatel = vztah.idPouzivatelOdpoved ";
        $where_prva_tabulka = "WHERE idPouzivatelAkcia =" . $id_pouzivatel . " AND status = '" . PRIJATI . "' ";

        $union = "UNION ";

        $select_druha_tabulka = "SELECT idPouzivatel, pouzivatel.meno, obrazok ";
        $from_druha_tabulka = "FROM vztah ";
        $join_druha_tabulka = "JOIN pouzivatel ON pouzivatel.idPouzivatel = vztah.idPouzivatelAkcia ";
        $where_druha_tabulka = "WHERE idPouzivatelOdpoved =" . $id_pouzivatel . " AND status = '" . PRIJATI . "' ";
        $order_by = "ORDER BY meno ASC ";
        $limit = "LIMIT " . $od . ", " . $pocet;

        $query = $this->db->query($select_prva_tabulka . $from_prva_tabulka . $join_prva_tabulka . $where_prva_tabulka . $union . $select_druha_tabulka . $from_druha_tabulka . $join_druha_tabulka . $where_druha_tabulka . $order_by . $limit);
        return $query->result_array();
    }

    private function zisti_mensie_id($prvy_pouzivatel, $druhy_pouzivatel, $status, $vykonal_akciu)
    {
        $vztah = array();
        if ($prvy_pouzivatel < $druhy_pouzivatel) {
            $vztah = array(
                "idPouzivatelAkcia" => $prvy_pouzivatel,
                "idPouzivatelOdpoved" => $druhy_pouzivatel,
                "status" => $status,
                "akcia" => $vykonal_akciu
            );
        } else {
            $vztah = array(
                "idPouzivatelAkcia" => $druhy_pouzivatel,
                "idPouzivatelOdpoved" => $prvy_pouzivatel,
                "status" => $status,
                "akcia" => $vykonal_akciu
            );
        }
        return $vztah;
    }
}

?>