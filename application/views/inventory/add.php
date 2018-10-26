<?php 
    if($error) echo '<p class="error">'. $error .'</p>';
    echo form_open(isset($item)?'inventory/edit/'.$item->id:'inventory/add'); 
    echo form_input(array('type'=>'hidden','name' => 'item_id', 'value' => isset($item)?$item->id:set_value('item_id')));
    echo form_label('Category', 'category_id') .'<br />';
    echo form_dropdown(array('name' => 'category_id', 'options' => $categories, 'selected'=>isset($item)?$item->category_id:set_value('category_id'))) .'<br />';
    echo form_label('Serial', 'serial') .'<br />';
    echo form_input(array('name' => 'serial', 'value' => isset($item)?$item->serial:set_value('serial'))) .'<br />';
    echo form_error('serial');
    echo form_label('Item Title', 'description') .'<br />';
    echo form_input(array('name' => 'description', 'value'=>isset($item)?$item->description:set_value('description'))) .'<br />';
    echo form_label('Accessories (one accessory per line, blank lines will be ignored)', 'accessories') .'<br />';
    for($i=0;$i<9;$i++) {
        echo form_input(array('name' => 'accessories[]','value'=>(isset($item) && $i<count($item->accessories))?$item->accessories[$i]:"")) .'<br />';
    }
    echo form_submit(array('type' => 'submit', 'value' => isset($item)?'Save':'Add'));
    echo form_close();
