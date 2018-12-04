<?php
    if($error) echo '<p class="error">'. $error .'</p>';
    echo form_open('inventory/checkout/'.$item->id);
    echo "<h2>Please enter the date the items are due.</h2>";
    echo form_label('Date due (e.g., 2018-12-03 17:00)', 'datedue') .'<br />';
    echo form_input(array('name' => 'datedue', 'value' => set_value('datedue'))) .'<br />';
    echo form_error('datedue');
    echo "<h2>Please select the student/user who is receiving the items.</h2>";
    echo form_dropdown(array('name' => 'user_id', 'options' => $users, set_value('user_id'))) .'<br />';
    echo form_error('user_id');
    echo "<h2>Accessories - please place a checkmark next to each item as you hand to student.</h2>";
    // start here - checkboxes for student worker ... PLUS ITEM NOTES!!!
    if (!$item->accessories) {
      echo "No accessories.";
    } else {
      for($i=0;$i<count($item->accessories);$i++) {
          echo form_input(array('type'=>'checkbox','name' => 'accessories'.$i, 'value'=>1)) . $item->accessories[$i] . '<br />';
          echo form_error('accessories'.$i);
      }
    }
    echo "<h2>Item notes. Please check these notes associated with the requested item.</h2>";
    // start here - checkboxes for student worker ... PLUS ITEM NOTES!!!
    echo form_submit(array('type' => 'submit', 'value' => 'Next'));
    echo form_close();
