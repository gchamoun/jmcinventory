<?php

class Inventory_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function add() {
        // process the incoming accessories data and put into appropriate format
        $accessories = $this->input->post('accessories');
        if(is_array($accessories)) {
            // iterate through the accessories getting rid of any empty blanks, plus get rid of leading/trailing spaces - a common typo
            $noblanks = [];
            foreach ($accessories as $acc) {
                $trimmed = trim($acc);
                if($trimmed) {
                    $noblanks[] = $trimmed;
                }
            }
            $accessoriesformatted = json_encode($noblanks);
        } else {
            $accessoriesformatted = $accessories;
        }
        $now = date("Y-m-d H:i:s");
        
        $data = array(
            'serial' => $this->input->post('serial'),
            'description' => $this->input->post('description'),
            'accessories' => $accessoriesformatted,
            'datemodified' => $now,
            'dateadded' => $now
        );

        return $this->db->insert('items', $data);
    }

    public function getallitems() {
        $this->db->order_by('serial','asc');
        $query = $this->db->get_where('items');
        return $query->result();
    }
    
    public function delete_news($slug) {
        if (!$slug) {
            return false;
        }
        return $this->db->delete('news', array('slug' => $slug));
    }
    

}
