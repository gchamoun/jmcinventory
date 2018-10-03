<?php

class Inventory_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function add() {
        // process the incoming accessories data and put into appropriate format
        $accessories = $this->input->post('accessories');
        $now = date("Y-m-d H:i:s");
        
        $data = array(
            'serial' => $this->input->post('serial'),
            'description' => $this->input->post('description'),
            'accessories' => $accessories,
            'datemodified' => $now,
            'datecreated' => $now
        );

        return $this->db->insert('items', $data);
    }

    public function delete_news($slug) {
        if (!$slug) {
            return false;
        }
        return $this->db->delete('news', array('slug' => $slug));
    }
    

}
