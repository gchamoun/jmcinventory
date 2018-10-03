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
        if(!logged_in()) redirect('auth/login');

        $this->load->library('form_validation');
        $this->load->helper('form');
        $data['title'] = 'Add inventory item manually';
        $data['error'] = false;
        $this->form_validation->set_rules('serial', 'Serial', 'required|is_unique[' . 'items.serial]');
        if ($this->form_validation->run()) {
            if ($this->inventory_model->add()) {
                $data['msg'] = "The item was added successfully.";
            } else {
                $data['msg'] = "An unexpected error occurred";
            }
        }
        $this->load->view('templates/header',$data);
        $this->load->view('inventory/add',$data);
        $this->load->view('templates/footer');
    }
    
}
