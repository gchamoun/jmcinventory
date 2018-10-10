<?php

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('authit');
        $this->load->helper('authit');
        $this->config->load('authit');
        $this->load->model('users_model');
        $this->load->model('inventory_model');
        $this->load->helper('html_helper');
        $this->load->helper('url_helper');
        $this->load->library('session');
    }

    public function dashboard() {
        if(!logged_in()) redirect('auth/login');
        switch (user('role_id')) {
            case Users_model::DEFAULT_USER:
                $data['reservations'] = $this->users_model->getreservations(user('id'));
                $data['title'] = "User dashboard";
                $this->load->view("templates/header",$data);
                $this->load->view("users/userdashboard",$data);
                $this->load->view("templates/footer");
                break;
            case Users_model::WORKER_USER:
                $data['reservations'] = $this->users_model->getallreservations();
                $data['title'] = "Worker dashboard";
                $this->load->view("templates/header",$data);
                $this->load->view("users/workerdashboard",$data);
                $this->load->view("templates/footer");
                break;
            case Users_model::ADMIN_USER:
                $data['reservations'] = $this->users_model->getallreservations();
                $data['items'] = $this->inventory_model->getallitems();
                $data['users'] = $this->users_model->getallusers();
                $data['title'] = "Admin dashboard";
                $this->load->view("templates/header",$data);
                $this->load->view("users/admindashboard",$data);
                $this->load->view("templates/footer");
                break;
        }
        
    }
    
    // user should already be logged in
    public function mobile_getreservations() {
        $reservations = $this->users->getreservations(user('id'));
        echo json_encode($reservations);
        exit;
    }
    
}
