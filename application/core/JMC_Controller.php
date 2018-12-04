<?php
class JMC_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->config->load('authit');
        $this->load->library('authit');
        $this->load->model('users_model');
        $this->load->model('inventory_model');
        $this->load->helper('authit');
        $this->load->helper('html');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    // returns true only if user is logged in and has one of the designated roles in $allowedroles
    protected function _isAuthorized($allowedroles=[Users_model::WORKER_USER,Users_model::ADMIN_USER])
    {
        return logged_in() && in_array(user('role_id'), $allowedroles);
    }
}
