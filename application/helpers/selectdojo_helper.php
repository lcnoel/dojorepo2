<?php

/**
 *
 *
 *
 */

    function hcheck_PA(){
        //$this->load->database();

        /*$query = $this->db->select('codmiembro')
                            ->like('codmiembro', 'ABPAPA', 'after')
                            ->order_by('codmiembro', 'DESC')
                            ->limit(1)
                            ->get('miembros');*/
        $query = "desde helper";
        return $query;

            //$this->db->get('miembros');
            //$this->db->like('codmiembro', 'ABPAPA', 'after');
            //$this->db->order_by('codmiembro', 'DESC');
            //$this->db->limit(1);
        //$query = $this->db->select('codmiembro');
        //$query = $this->db->query("SELECT codmiembro FROM miembros WHERE codmiembro LIKE 'ABPAPA%' ORDER BY codmiembro DESC LIMIT 1 ");
        //return $query;
    }

    function check_CH(){
        $query = $this->db->query("SELECT codmiembro FROM miembros WHERE codmiembro LIKE 'ABPACH%' ORDER BY codmiembro DESC LIMIT 1 ");
        return $query;
    }

    function check_CA(){
        $query = $this->db->query("SELECT codmiembro FROM miembros WHERE codmiembro LIKE 'ABPACA%' ORDER BY codmiembro DESC LIMIT 1 ");
        return $query;
    }

