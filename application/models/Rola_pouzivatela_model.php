<?php

class Rola_pouzivatela_model extends CI_model
{
    public function rola_pouzivatela($id_pouzivatel, $id_rola)
    {
        if ($id_pouzivatel == 0 || $id_rola == 0) {
            return false;
        } else {
            $priradenie_roli = array(
                "idPouzivatel" => $id_pouzivatel,
                "idRola" => $id_rola
            );
            $novy_zaznam = $this->db->insert('rola_pouzivatela', $priradenie_roli);
            if ($novy_zaznam) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function aktualizuj_rolu_pouzivatela($id_pouzivatel, $udaj)
    {
        if (!empty($udaj)) {
            $this->db->where('idPouzivatel', $id_pouzivatel);
            $this->db->update('rola_pouzivatela', $udaj);
            return true;
        } else {
            return false;
        }
    }

    public function odstran_rolu_pouzivatela($id_pouzivatel)
    {
        $odstran = $this->db->delete('rola_pouzivatela', array('idPouzivatel' => $id_pouzivatel));
        return $odstran ? true : false;
    }

    public function prihlas_pouzivatela($prihlasovacie_udaje)
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

    public function pocet_pouzivatelov($typ_roli){
        $this->db->select('meno');
        $this->db->from('rola_pouzivatela');
        $this->db->join('pouzivatel', 'pouzivatel.idPouzivatel = rola_pouzivatela.idPouzivatel');
        $this->db->join('rola', 'rola.idRola = rola_pouzivatela.idRola');
        $this->db->where('nazov', $typ_roli);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return 0;
    }

    public function informacia_o_pouzivatelovi($id_pouzivatel)
    {
        $this->db->select('meno, email, nazov');
        $this->db->from('rola_pouzivatela');
        $this->db->join('pouzivatel', 'pouzivatel.idPouzivatel = rola_pouzivatela.idPouzivatel');
        $this->db->join('rola', 'rola.idRola = rola_pouzivatela.idRola');
        $this->db->where("pouzivatel.idPouzivatel", $id_pouzivatel);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array()[0];
        }
        return null;
    }

    public function zoznam_pouzivatelov(){
        $this->db->select('*');
        $this->db->from('rola_pouzivatela');
        $this->db->join('pouzivatel', 'pouzivatel.idPouzivatel = rola_pouzivatela.idPouzivatel');
        $this->db->join('rola', 'rola.idRola = rola_pouzivatela.idRola');
        $this->db->order_by("pouzivatel.timestamp", "desc");
        $this->db->where('nazov', 'pouzivatel');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }

    public function zoznam_administratorov($email){
        $this->db->select('*');
        $this->db->from('rola_pouzivatela');
        $this->db->join('pouzivatel', 'pouzivatel.idPouzivatel = rola_pouzivatela.idPouzivatel');
        $this->db->join('rola', 'rola.idRola = rola_pouzivatela.idRola');
        $this->db->order_by("pouzivatel.timestamp", "desc");
        $this->db->where('nazov', 'admin');
        $this->db->where('email <>', $email);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }
}
?>