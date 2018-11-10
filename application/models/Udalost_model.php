<?php

class Udalost_model extends CI_model
{
    public function vytvorit($udalost = array())
    {
        $udaj = $this->db->insert('udalost', $udalost);
        if ($udaj) {
            return $this->db->insert_id();
        } else {
            return 0;
        }
    }

    public function aktualizuj($id_udalost, $udaj)
    {
        if (!empty($udaj)) {
            $this->db->where('idUdalost', $id_udalost);
            $this->db->update('udalost', $udaj);
            return true;
        } else {
            return false;
        }
    }

    public function odstran($id_udalost)
    {
        $odstran = $this->db->delete('udalost', array('idUdalost' => $id_udalost));
        return $odstran ? true : false;
    }

    public function zoznam_udalosti($stat, $email)
    {
        $this->db->select("udalost.idUdalost, obrazok, nazov, DATE_FORMAT(datum,'%m') as den, MONTHNAME(datum) as mesiac, DATE_FORMAT(cas, '%H:%i') as cas, mesto, ulica, vstupenka, COUNT(zaujem.idUdalost) as zaujemcovia, IF(SUM(pouzivatel.email = '" . $email . "') > 0, 1, 0) as zaujem");
        $this->db->from('zaujem');
        $this->db->join('udalost', 'udalost.idUdalost = zaujem.idUdalost', 'right');
        $this->db->join('pouzivatel', 'pouzivatel.idPouzivatel = zaujem.idPouzivatel', 'left');
        $this->db->join('cennik', 'udalost.idCennik = cennik.idCennik');
        $this->db->join('miesto', 'udalost.idMiesto = miesto.idMiesto');
        if ($stat != null) {
            $this->db->where("stat", $stat);
        }
        $this->db->where("datum >= CURDATE()");
        $this->db->where("stav", PRIJATE);
        $this->db->group_by("udalost.idUdalost");
        $this->db->order_by("datum", "asc");
        $this->db->order_by("vaha", "desc");
        $this->db->order_by("udalost.timestamp", "desc");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function zoznam_udalosti_v_okoli($stat, $email, $okres, $mesto)
    {
        $this->db->select("udalost.idUdalost, obrazok, nazov, DATE_FORMAT(datum,'%m') as den, MONTHNAME(datum) as mesiac, DATE_FORMAT(cas, '%H:%i') as cas, mesto, ulica, vstupenka, COUNT(zaujem.idUdalost) as zaujemcovia, IF(SUM(pouzivatel.email = '" . $email . "') > 0, 1, 0) as zaujem");
        $this->db->from('zaujem');
        $this->db->join('udalost', 'udalost.idUdalost = zaujem.idUdalost', 'right');
        $this->db->join('pouzivatel', 'pouzivatel.idPouzivatel = zaujem.idPouzivatel', 'left');
        $this->db->join('cennik', 'udalost.idCennik = cennik.idCennik');
        $this->db->join('miesto', 'udalost.idMiesto = miesto.idMiesto');
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
            $this->db->or_where("mesto ='" . $mesto . "')");
        }
        $this->db->where("(datum >= CURDATE())");
        $this->db->where("stav", PRIJATE);
        $this->db->group_by("udalost.idUdalost");
        $this->db->order_by("datum", "asc");
        $this->db->order_by("vaha", "desc");
        $this->db->order_by("udalost.timestamp", "desc");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function pocet_udalosti()
    {
        $this->db->select('nazov');
        $this->db->from('udalost');
        $this->db->where("stav", PRIJATE);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return 0;
    }

    public function pocet_udalosti_v_mesiaci()
    {
        $this->db->select('MONTHNAME(datum) AS Mesiac, COUNT(*) AS Pocet');
        $this->db->from('udalost');
        $this->db->where("stav", PRIJATE);
        $this->db->order_by('datum');
        $this->db->group_by('MONTHNAME(datum)');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return 0;
    }

    public function pocet_sprav()
    {
        $this->db->select('COUNT(*) AS Pocet, idUdalost AS idOznamy');
        $this->db->from('udalost');
        $this->db->where("stav", NEPRECITANE);

        $udalosti = $this->db->get_compiled_select();

        $this->db->select('COUNT(*) AS Pocet, pouzivatel.idPouzivatel as idOznamy');
        $this->db->from('rola_pouzivatela');
        $this->db->join('pouzivatel', 'pouzivatel.idPouzivatel = rola_pouzivatela.idPouzivatel');
        $this->db->join('rola', 'rola.idRola = rola_pouzivatela.idRola');
        $this->db->where('nazov', ORGANIZATOR);
        $this->db->where("stav", NEPRECITANE);

        $pouzivatelia = $this->db->get_compiled_select();

        $this->db->select('Pocet, idOznamy');
        $this->db->from("($udalosti UNION $pouzivatelia) as oznamy");

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return 0;
    }

    public function informacia($id_udalost)
    {
        $this->db->select('*');
        $this->db->from('udalost');
        $this->db->join('miesto', 'udalost.idMiesto = miesto.idMiesto');
        $this->db->where("idUdalost", $id_udalost);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array()[0];
        }
        return null;
    }

    public function udalosti_podla_okresu()
    {
        $this->db->select('okres, COUNT(*) AS Pocet');
        $this->db->from('udalost');
        $this->db->join('miesto', 'udalost.idMiesto = miesto.idMiesto');
        $this->db->where("stav", PRIJATE);
        $this->db->group_by('okres');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return 0;
    }

    public function udalosti_podla_statu()
    {
        $this->db->select('stat, COUNT(*) AS Pocet');
        $this->db->from('udalost');
        $this->db->join('miesto', 'udalost.idMiesto = miesto.idMiesto');
        $this->db->where("stav", PRIJATE);
        $this->db->group_by('stat');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return 0;
    }
}

?>