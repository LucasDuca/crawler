<?php

class emailModel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getLastEmails() {
        $query = $this->db->select('email')
                        ->from('emails')
                        ->order_by('id', 'desc')
                        ->limit(10)->get();
        return $query->result_array();
    }

    function countEmails() {
        $query = $this->db->select('count(*) as total')
                ->from('emails')
                ->get();
        return $query->row_array();
    }

}
