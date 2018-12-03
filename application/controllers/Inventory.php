<?php

class Inventory extends JMC_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function add()
    {
        if (!$this->_isAuthorized()) {
            redirect('auth/login');
        }

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

    public function import()
    {
        if (!$this->_isAuthorized()) {
            redirect('auth/login');
        }

        $this->load->helper('form');
        $data['title'] = 'Import inventory items from CSV';
        $data['error'] = false;
        if (isset($_FILES['csvfile'])) {
            list($cnt, $errors) = $this->inventory_model->import($_FILES["csvfile"]["tmp_name"]);
            $err = count($errors);
            $data['msg'] = "$cnt item(s) imported successfully. $err error(s) occurred.";
        }
        $this->load->view('templates/header', $data);
        $this->load->view('inventory/import', $data);
        $this->load->view('templates/footer');
    }

    protected function _prepareCategories()
    {
        $categories = $this->inventory_model->getcategories();
        $cats = [''=>''];
        foreach ($categories as $cat) {
            $cats[$cat->id] = $cat->title;
        }
        return $cats;
    }

    public function edit($item_id)
    {
        if (!$this->_isAuthorized()) {
            redirect('auth/login');
        }

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

    public function check_serial($serial)
    {
        if ($this->input->post('item_id')) {
            $id = $this->input->post('item_id');
        } else {
            $id = '';
        }
        $result = $this->inventory_model->check_serial($id, $serial);
        if ($result == 0) {
            $response = true;
        } else {
            $this->form_validation->set_message('check_serial', 'Serial must be unique');
            $response = false;
        }
        return $response;
    }

    public function delete($item_id)
    {
        if (!$this->_isAuthorized()) {
            redirect('auth/login');
        }

        if ($this->inventory_model->delete($item_id)) {
            echo "item $item_id was deleted.";
        } else {
            echo "item $item_id was not deleted";
        }
    }

    public function valid_date($datedue) {
      if (!$datedue) {
        $this->form_validation->set_message('valid_date', 'The Date due field is required.');
        return false;
      }
      if (!(bool)strtotime($datedue)) {
        $this->form_validation->set_message('valid_date', 'The Date due field is not formatted correctly.');
        return false;
      }
      return true;
    }

    public function valid_student($user_id) {
      if (!$user_id) {
        $this->form_validation->set_message('valid_student', 'Please select a student from the list.');
        return false;
      }
      if (!$this->users_model->getuser($user_id)) {
        $this->form_validation->set_message('valid_student', 'The student entered does not exist in the system. Please have the student create an account first.');
        return false;
      }
      return true;
    }

    protected function _prepareUsers()
    {
        $allusers = $this->users_model->getallusers();
        $users = [];
        foreach ($allusers as $user) {
            $users[$user->id] = $user->email;
        }
        return $users;
    }


    // handle checkins and checkouts
    public function checkout($item_id)
    {
      // second step is getting signature - https://github.com/williammalone/Simple-HTML5-Drawing-App
      if (!$this->_isAuthorized()) {
          redirect('auth/login');
      }
      $data['item'] = $this->inventory_model->getitem($item_id);
      $data['users'] = $this->_prepareUsers();
      $data['title'] = 'Item checkout STEP 1';
      $data['error'] = false;
      $this->load->library('form_validation');
      $this->load->helper('form');
      $this->form_validation->set_rules('datedue', 'Date due', 'callback_valid_date');
      $this->form_validation->set_rules('user_id', 'Student email', 'callback_valid_student');
      if ($data['item']->accessories) {
        $i=0;
        foreach ($data['item']->accessories as $acc) {
          $this->form_validation->set_rules('accessories'.$i++, 'Accessories', 'required');
        }
      }
      if ($this->form_validation->run()) {
          //$success = $this->inventory_model->checkout();
          $success = true;
          if ($success) {
              $data['msg'] = "The item has been checked out. Please enter signature now.";
          } else {
              $data['msg'] = "An unexpected error occurred.";
          }
      } else {
          $data['item'] = $this->inventory_model->getitem($item_id);
      }
      $data['categories'] = $this->_prepareCategories();
      $this->load->view('templates/header', $data);
      $this->load->view('inventory/checkout', $data);
      $this->load->view('templates/footer');
    }

    public function qrcode($item_id, $qraction)
    {
        $this->load->library('QRcode');
        switch ($qraction):
           case 1: $url = "inventory/checkin/$item_id";
        endswitch;
        $data['qrdata'] = $url;
        $this->load->view('/inventory/qrcode', $data);
    }

}
