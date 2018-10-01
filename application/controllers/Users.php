<?php

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('authit');
        $this->load->helper('authit');
        $this->config->load('authit');
        $this->load->model('users_model');
        $this->load->helper('html_helper');
        $this->load->helper('url_helper');
        $this->load->library('session');
    }

    public function dashboard() {
        if(!logged_in()) redirect('auth/login');
        $data['reservations'] = $this->users->getreservations(user('id'));
        echo "Welcome back " . user('id');
        echo "<br />Your role is " . user('role_id');
        exit;
    }
    
    // user should already be logged in
    public function mobile_getreservations() {
        $reservations = $this->users->getreservations(user('id'));
        echo json_encode($reservations);
        exit;
    }
    
}
