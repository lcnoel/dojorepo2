<?php

class Dojo_model extends Grocery_crud_model  {

    /*private  $query_str = '';
    function __construct() {
        parent::__construct();
    }*/

    function listar() {
        $query = $this->db->select('codmiembro')
                            ->like('codmiembro', 'ABPAPA', 'after')
                            ->order_by('codmiembro', 'DESC')
                            ->limit(1)
                            ->get('miembros');

        //$query=$this->db->query("SELECT codmiembro FROM miembros WHERE codmiembro LIKE 'ABPAPA%' ORDER BY codmiembro DESC LIMIT 1 ");
        //$query = "desde dojo model";
        $results_array=$query->result();
        return $results_array;
        //return $query;
    }

    function get_sec_dojo($id_dojo){

        $query = $this->db->select_max('sec_dojo')->where('id_dojo', $id_dojo)->get('miembros');
        $results_array=$query->result();
        return ($results_array[0]->sec_dojo)+1;

    }

    function get_cod_dojo($id_dojo){

        $query = $this->db->select('codigo')->where('id', $id_dojo)->get('dojos');
        $results_array=$query->result();
        return$results_array[0]->codigo;

    }

    /*public function set_query_str($query_str) {
        $this->query_str = $query_str;
    }*/

}