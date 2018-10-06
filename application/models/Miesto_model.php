<?php

class Miesto_model extends CI_model
{
    public function vytvorit($miesto = array())
    {
        $udaj = $this->db->insert('miesto', $miesto);
        if ($udaj) {
            return $this->db->insert_id();
        } else {
            return 0;
        }
    }

    public function aktualizuj($id_miesto, $udaj)
    {
        if (!empty($udaj)) {
            $this->db->where('idMiesto', $id_miesto);
            $this->db->update('miesto', $udaj);
            return true;
        } else {
            return false;
        }
    }

    public function odstran($id_miesto)
    {
        $odstran = $this->db->delete('miesto', array('idMiesto' => $id_miesto));
        return $odstran ? true : false;
    }

    public function zoznam()
    {
        
    }
}

?>