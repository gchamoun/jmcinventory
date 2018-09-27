<?php

class Users_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function getreservations($user_id) {
        
    }

// old examples from news tutorial    
    public function set_news() {
        $this->load->helper('url');

        $slug = url_title($this->input->post('title'), 'dash', TRUE);

        $data = array(
            'title' => $this->input->post('title'),
            'slug' => $slug,
            'text' => $this->input->post('text')
        );

        return $this->db->insert('news', $data);
    }

    public function delete_news($slug) {
        if (!$slug) {
            return false;
        }
        return $this->db->delete('news', array('slug' => $slug));
    }
    

}
