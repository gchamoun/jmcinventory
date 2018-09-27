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
        echo "Weclome back " . user('id');
        exit;
    }
    
}
