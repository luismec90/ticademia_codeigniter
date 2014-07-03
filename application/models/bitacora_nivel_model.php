<?php

class Bitacora_nivel_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function crear($data) {
        $this->db->insert('bitacora_nivel', $data);
    }

}
