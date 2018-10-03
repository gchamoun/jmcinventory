<?php 
    if($error) echo '<p class="error">'. $error .'</p>';
    echo form_open(); 
    echo form_label('Serial', 'serial') .'<br />';
    echo form_input(array('name' => 'serial', 'value' => set_value('serial'))) .'<br />';
    echo form_error('serial');
    echo form_label('Description', 'description') .'<br />';
    echo form_textarea(array('name' => 'description')) .'<br />';
    echo form_error('description');
    echo form_label('Accessories', 'accessories') .'<br />';
    echo form_textarea(array('name' => 'accessories')) .'<br />';
    echo form_error('accessories');
    echo form_submit(array('type' => 'submit', 'value' => 'Add'));
    echo form_close();
