<?php

class mobile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('users_model');
        $this->load->model('Reservations_model');
        $this->load->model('inventory_model');
        $this->load->model('Users_model');

        $this->load->helper('html');
        $this->load->helper('url');
        $this->load->library('session');
    }

    // user should already be logged in
    public function getUsers() {

      $users = $this->users_model->getallusers();
        exit;
    }
    public function getReservations($itemid) {
      $reservationId = $this->Reservations_model->getReservationId($itemid);
      $reservedItems = $this->Reservations_model->getReservedItems($reservationId);
      echo ($reservedItems);


}
public function getItem($item_id) {
    $item = $this->inventory_model->getitem($item_id);
    echo json_encode($item);
    exit;
}
public function getAllUsers() {
    $users = $this->Users_model->getAllUsers();
    $output = json_encode(array('results' => $users));
print($output);
    exit;
}
public function checkOutItems($userId, $worker_checkout_id,$itemid,$reservationIdExist) {
    $users = $this->Reservations_model->checkOutItems($userId, $worker_checkout_id,$itemid,$reservationIdExist);
    echo json_encode($users);
    exit;
}
public function getReservedItems($itemid){
  $users = $this->Reservations_model->getReservedItems($itemid);

}
public function AllcheckIn($worker_checkin_id, $itemid) {
    $users = $this->Reservations_model->AllcheckIn($worker_checkin_id,$itemid);
    exit;
}
public function individualCheckin($worker_checkin_id, $itemid) {
    $users = $this->Reservations_model->individualCheckin($worker_checkin_id,$itemid);
    exit;
}
public function getItemsCheckin($itemid) {
    $users = $this->Reservations_model->getItemsCheckin($itemid);
    exit;
}



}
