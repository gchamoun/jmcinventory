<?php

class Reservations_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }



    public function getReservationId($itemid) {
        $query = $this->db->query("SELECT reservation_id FROM inventorydb.reservation_details where item_id = $itemid ORDER BY id DESC LIMIT 1");
        $ret = $query->row();
        return $ret->reservation_id;
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
      if(!$reservationIdExist){
      $dataReservation = array(
          'user_id' => $userId,
          'worker_checkout_id' => $worker_checkout_id
          );

  $this->db->insert('reservations', $dataReservation);
  $reservationId = getUsersLatestReservationId($userId);
  $dataReservationDetail = array(
      'item_id' => $itemid,
      'reservation_id' => $reservationId
      );

      $this->db->insert('reservations', $dataReservationDetail);
}
else{

  $this->db->insert('reservations', $dataReservation);
  $reservationId = getUsersLatestReservationId($userId);

  $dataReservationDetail = array(
      'item_id' => $itemid,
      'reservation_id' => $reservationId
      );

      $this->db->insert('reservations', $dataReservationDetail);
}

}

public function getItemsCheckin($userId, $worker_checkout_id,$itemid,$reservationIdExist) {

$reservationId =  getReservationId($itemid);


  $query = $this->db->query("SELECT item_id
FROM Reservations
INNER JOIN Reservation_details ON reservations.id=reservation_details.reservation_id
Inner Join Items On items.id=reservation_details.item_id
where reservations.id = $reservationId");

$items = $query->result_array();
return $items;

}
public function getUsersLatestReservationId($userId) {
    $query = $this->db->query("SELECT id FROM inventorydb.reservation where user_id = $userId ORDER BY id DESC LIMIT 1");
    $ret = $query->row();
    return $ret->id;
}

public function checkIn($userId, $worker_checkin_id, $itemid) {
  $reservationId =  getReservationId($itemid);

  $query = $this->db->query("SELECT id
FROM Reservations
INNER JOIN Reservation_details ON reservations.id=reservation_details.reservation_id
Inner Join Items On items.id=reservation_details.item_id
where reservations.id = $reservationId");
$ret = $query->row();
$resId = $ret->id;

$this->db->set('datecheckin');
$this->db->where('id', $resId);
$this->db->update('reservations'); // gives UPDATE `mytable` SET `field` = 'field+1' WHERE `id` = 2

}
}
