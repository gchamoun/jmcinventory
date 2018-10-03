<?php

class Inventory extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('authit');
        $this->load->helper('authit');
        $this->config->load('authit');
        $this->load->model('inventory_model');
        $this->load->helper('html_helper');
        $this->load->helper('url_helper');
        $this->load->library('session');
    }
    
    public function add() {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $data['title'] = 'Add inventory item manually';
        $data['error'] = false;
        $this->load->view('templates/header',$data);
        $this->load->view('inventory/add',$data);
        $this->load->view('templates/footer');
    }
    
}
