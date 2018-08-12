<?php

class Rola_pouzivatela_model extends CI_model
{
    public function nova_rola_pouzivatela($id_pouzivatel, $id_roli)
    {
        if ($id_pouzivatel == 0 || $id_roli == 0) {
            return false;
        } else {
            $priradenie_roli = array(
                "idPouzivatel" => $id_pouzivatel,
                "idRola" => $id_roli
            );
            $novy_zaznam = $this->db->insert('rola_pouzivatela', $priradenie_roli);
            if ($novy_zaznam) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function aktualizuj_rolu_pouzivatela($id_pouzivatel, $aktualizacne_udaje)
    {
        if (!empty($aktualizacne_udaje)) {
            $this->db->where('idPouzivatel', $id_pouzivatel);
            $this->db->update('rola_pouzivatela', $aktualizacne_udaje);
            return true;
        } else {
            return false;
        }
    }

    public function odstranenie_roli_pouzivatela_z_dovodu_odstranenia_uctu($id_pouzivatel)
    {
        $odstran = $this->db->delete('rola_pouzivatela', array('idPouzivatel' => $id_pouzivatel));
        return $odstran ? true : false;
    }

    public function prihlasuj_podla_roli($prihlasovacie_udaje)
    {
        $this->db->select('nazov');
        $this->db->from('rola_pouzivatela');
        $this->db->join('pouzivatel', 'pouzivatel.idPouzivatel = rola_pouzivatela.idPouzivatel');
        $this->db->join('rola', 'rola.idRola = rola_pouzivatela.idRola');
        $this->db->where('email', $prihlasovacie_udaje['email']);
        $this->db->where('heslo', $prihlasovacie_udaje['heslo']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $riadok = $query->row();
            return (strcmp("admin", $riadok->nazov) == 0) ? true : false;
        } else {
            return false;
        }
    }

    public function zoznam_pouzivatelov($email, $idPouzivatel, $od, $pocet)
    {
        $this->db->select('pouzivatel.idPouzivatel, meno, obrazok');
        $this->db->from('rola_pouzivatela');
        $this->db->join('pouzivatel', 'pouzivatel.idPouzivatel = rola_pouzivatela.idPouzivatel');
        $this->db->join('rola', 'rola.idRola = rola_pouzivatela.idRola');
        $this->db->join("(
         SELECT idPouzivatel FROM vztah JOIN pouzivatel ON pouzivatel.idPouzivatel = vztah.idPouzivatelOdpoved 
         WHERE idPouzivatelAkcia = '" . $idPouzivatel . "' AND (status = '" . CAKAJUCI . "' OR status = '" . PRIJATI . "' OR status = '" . ODMIETNUTY . "')
         UNION
         SELECT `idPouzivatel` FROM `vztah` JOIN pouzivatel ON pouzivatel.idPouzivatel = vztah.idPouzivatelAkcia 
         WHERE idPouzivatelOdpoved = '" . $idPouzivatel . "' AND (status = '" . CAKAJUCI . "' OR status = '" . PRIJATI . "' OR status = '" . ODMIETNUTY . "')) AS pouzivatelia", "pouzivatelia.idPouzivatel = pouzivatel.idPouzivatel", "left");
        $this->db->where('nazov', "pouzivatel");
        $this->db->where('email <>', $email);
        $this->db->where('pouzivatelia.idPouzivatel IS NULL');
        $this->db->order_by("meno", "asc");
        $this->db->limit($pocet, $od);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function vyhladavanie_pouzivatelov($meno)
    {
        $this->db->select('pouzivatel.idPouzivatel, meno,obrazok');
        $this->db->from('rola_pouzivatela');
        $this->db->join('rola', 'rola.idRola = rola_pouzivatela.idRola');
        $this->db->join('pouzivatel', 'pouzivatel.idPouzivatel = rola_pouzivatela.idPouzivatel');
        $this->db->where('nazov', "pouzivatel");
        $this->db->like("meno", $meno);
        $this->db->order_by("meno", "asc");
        $query = $this->db->get();
        return $query->result_array();
    }
}

?>