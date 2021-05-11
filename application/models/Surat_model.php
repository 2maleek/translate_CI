<?php

class Surat_model extends CI_model {

    public function getSurat(){
        return $this->db->get('t_surat_masuk')->row_array();
    }
}

?>