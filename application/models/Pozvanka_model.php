<?php

class Pozvanka_model extends CI_model
{
    public function nova_pozvanka($pozvanka = array())
    {
        $nova_pozvanka = $this->db->insert('pozvanka', $pozvanka);
        if ($nova_pozvanka) {
            return $this->db->insert_id();
        } else {
            return 0;
        }
    }

    public function odstranenie_pozvanok_z_dovodu_odstranenia_uctu($id_pouzivatel)
    {
        $odstran = $this->db->delete('pozvanka', array('idPouzivatelAkcia' => $id_pouzivatel, 'idPouzivatelOdpoved' => $id_pouzivatel));
        return $odstran ? true : false;
    }

    public function zoznam_oznameni($idPouzivatel, $od, $pocet)
    {
        $this->db->select('udalost.idUdalost, precitana ,udalost.nazov, udalost.mesto, pouzivatel.meno, pouzivatel.obrazok');
        $this->db->from('pozvanka');
        $this->db->join('pouzivatel', 'pouzivatel.idPouzivatel = pozvanka.idPouzivatelAkcia');
        $this->db->join('udalost', 'udalost.idUdalost = pozvanka.idUdalost');
        $this->db->where("pozvanka.idPouzivatelOdpoved", $idPouzivatel);
        $this->db->order_by("pozvanka.timestamp", "desc");
        $this->db->limit($pocet, $od);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function precitaj_oznamenie($id_pouzivatel)
    {
        if ($id_pouzivatel != null) {
            $this->db->where('idPouzivatelOdpoved', $id_pouzivatel);
            $this->db->update('pozvanka', array("precitana" => true));
            return true;
        } else {
            return false;
        }
    }
}

?>