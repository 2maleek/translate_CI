<?php

class Login_model extends CI_model {
    public function getInstansi(){
        return $this->db->get('tr_instansi')->row_array();
    }

    public function getAdmin(){
        return $this->db->get('t_admin');
    }
}

?>