<?php

class Inventory extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('authit');
        $this->load->helper('authit');
        $this->config->load('authit');
        $this->load->model('inventory_model');
        $this->load->helper('html');
        $this->load->helper('url');
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
        $data['categories'] = $this->_prepareCategories();
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

    protected function _prepareCategories() {
        $categories = $this->inventory_model->getcategories();
        $cats = [''=>''];
        foreach ($categories as $cat) {
            $cats[$cat->id] = $cat->title;
        }
        return $cats;
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
        $data['categories'] = $this->_prepareCategories();
        $this->load->view('templates/header', $data);
        $this->load->view('inventory/add', $data);
        $this->load->view('templates/footer');
    }

    public function delete($item_id) {
        if($this->inventory_model->delete($item_id)) {
            echo "item $item_id was deleted.";
        } else {
            echo "item $item_id was not deleted";
        }
    }
    
    // handle checkins and checkouts
    public function checkin($item_id) {
        echo "implement checkin/checkout functionality. this one method does both. You need to look at the 'checkins' table to see if there is a currently checked out item with the matching item_id. If so, then the action to perform is to check in. If not, then the action to perform is to check out.";
    }

    public function qrcode($item_id,$qraction) {
        $this->load->library('QRcode');
        switch($qraction):
           case 1: $url = "inventory/checkin/$item_id";
        endswitch;
        $data['qrdata'] = $url;
        $this->load->view('/inventory/qrcode', $data);
    }

    public function mobile_getitems() {
        $items = $this->inventory_model->getallitems();
        echo json_encode($items);
        exit;
    }

    // http://localhost/inventory/mobile_checkin/3
    public function mobile_checkin($item_id) {
        
    }

    public function mobile_checkout($item_id) {
        
    }

}
