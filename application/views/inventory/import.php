<br /><br />
<?php
    if($error) echo '<p class="error">'. $error .'</p>';
    echo form_open_multipart('inventory/import');
    echo form_label('CSV File ', 'csvfile') .'<br />';
    echo form_input(array('type'=>'file','name' => 'csvfile')) .'<br />';
    echo form_error('csvfile');
    echo form_submit(array('type' => 'submit', 'value' => 'Import'));
    echo form_close();
