<?php

class Reservations_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }




    public function getReservedItems($reservationId) {
         $query = $this->db->query("SELECT *
FROM Reservations
INNER JOIN Reservation_details ON reservations.id=reservation_details.reservation_id
Inner Join Items On items.id=reservation_details.item_id
where reservations.id = $reservationId");

return json_encode($query->result_array());


    }

    public function checkOutItems($userId, $worker_checkout_id,$itemid,$reservationIdExist) {
      if($reservationIdExist == 0){

      $dataReservation = array(
          'user_id' => $userId,
          'worker_checkout_id' => $worker_checkout_id
          );

  $this->db->insert('reservations', $dataReservation);
  $query = $this->db->query("SELECT id FROM inventorydb.reservations where user_id = $userId ORDER BY id DESC LIMIT 1");
  $ret = $query->row();
  $reservationId = $ret->id;
  print_r("Created Reservation id " . $reservationId);

  $dataReservationDetail = array(
      'item_id' => $itemid,
      'reservation_id' => $reservationId
      );
      print_r("Creating new Reservation id " . $reservationId);

      $this->db->insert('reservation_details', $dataReservationDetail);
}
else{
  $query = $this->db->query("SELECT id FROM inventorydb.reservations where user_id = $userId ORDER BY id DESC LIMIT 1");
  $ret = $query->row();
  $reservationId = $ret->id;
print_r("Adding to current Reservation id " . $reservationId);
  $dataReservationDetail = array(
      'item_id' => $itemid,
      'reservation_id' => $reservationId
      );

      $this->db->insert('reservation_details', $dataReservationDetail);
}

}
public function getUsersLatestReservationId($userId) {
    $query = $this->db->query("SELECT id FROM inventorydb.reservations where user_id = $userId ORDER BY id DESC LIMIT 1");
    $ret = $query->row();
    return $ret->id;
}


public function getItemsCheckin($itemid) {

$query = $this->db->query("SELECT reservation_id FROM inventorydb.reservation_details where item_id = $itemid ORDER BY id DESC LIMIT 1");
$ret = $query->row();
$reservationId =$ret->reservation_id;

  $query = $this->db->query("SELECT item_id
FROM Reservations
INNER JOIN Reservation_details ON reservations.id=reservation_details.reservation_id
Inner Join Items On items.id=reservation_details.item_id
where reservations.id = $reservationId");

$items = $query->result_array();
print_r($items);
return $items;


}
public function getReservationId($itemid) {
    $query = $this->db->query("SELECT reservation_id FROM inventorydb.reservation_details where item_id = $itemid ORDER BY id DESC LIMIT 1");
    $ret = $query->row();
    return $ret->reservation_id;
}



public function checkIn($worker_checkin_id, $itemid) {
  $query = $this->db->query("SELECT reservation_id FROM inventorydb.reservation_details where item_id = $itemid ORDER BY id DESC LIMIT 1");
  $ret = $query->row();
  $reservationId = $ret->reservation_id;
print_r ($reservationId);
  $query = $this->db->query("SELECT reservations.id
FROM Reservations
INNER JOIN Reservation_details ON reservations.id=reservation_details.reservation_id
Inner Join Items On items.id=reservation_details.item_id
where reservations.id = $reservationId");
$ret = $query->row();
$resId = $ret->id;

$this->db->set('datecheckin', 'NOW()', FALSE);
$this->db->where('id', $resId);
$this->db->update('reservations'); // gives UPDATE `mytable` SET `field` = 'field+1' WHERE `id` = 2

}


}
