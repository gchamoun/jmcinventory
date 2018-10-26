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
        if (!logged_in())
            redirect('auth/login');

        $this->load->library('form_validation');
        $this->load->helper('form');
        $data['title'] = 'Add inventory item manually';
        $data['error'] = false;
        $this->form_validation->set_rules('serial', 'Serial', 'required|is_unique[items.serial]');
        if ($this->form_validation->run()) {
            if ($this->inventory_model->add()) {
                $data['msg'] = "The item was added successfully.";
            } else {
                $data['msg'] = "An unexpected error occurred";
            }
        }
        $this->load->view('templates/header', $data);
        $this->load->view('inventory/add', $data);
        $this->load->view('templates/footer');
    }

    public function check_serial($serial) {
        if ($this->input->post('item_id'))
            $id = $this->input->post('item_id');
        else
            $id = '';
        $result = $this->inventory_model->check_serial($id, $serial);
        if ($result == 0)
            $response = true;
        else {
            $this->form_validation->set_message('check_serial', 'Serial must be unique');
            $response = false;
        }
        return $response;
    }

    public function edit($item_id) {
        $data['title'] = 'Edit inventory item';
        $data['error'] = false;
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->form_validation->set_rules('serial', 'Serial', 'required|callback_check_serial[items.serial]');
        if ($this->form_validation->run()) {
            $success = $this->inventory_model->edit();
            $data['item'] = $this->inventory_model->getitem($item_id);
            if ($success) {
                $data['msg'] = "Your changes have been saved.";
            } else {
                $data['msg'] = "An unexpected error occurred.";
            }
        } else {
            $data['item'] = $this->inventory_model->getitem($item_id);
        }
        $categories = $this->inventory_model->getcategories();
        $cats = [''=>''];
        foreach ($categories as $cat) {
            $cats[$cat->id] = $cat->title;
        }
        $data['categories'] = $cats;
        $this->load->view('templates/header', $data);
        $this->load->view('inventory/add', $data);
        $this->load->view('templates/footer');
    }

    public function delete($item_id) {
        
    }

    public function qrcode($item_id) {
        $this->load->library('QRcode');
        $data['qrdata'] = $item_id;
        $this->load->view('/inventory/qrcode', $data);
    }

    // http://localhost/inventory/mobile_checkin/3
    public function mobile_checkin($item_id) {
        
    }

    public function mobile_checkout($item_id) {
        
    }

}
