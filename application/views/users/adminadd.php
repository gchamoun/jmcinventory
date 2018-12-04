<?php
    if ($error) {
        echo '<p class="error">'. $error .'</p>';
    }
    echo form_open(isset($user)?'users/adminedit/'.$item->id:'users/adminadd');
    echo form_input(array('type'=>'hidden','name' => 'user_id', 'value' => isset($user)?$user->id:set_value('user_id')));
    echo form_label('Role', 'role_id') .'<br />';
    echo form_dropdown(array('name' => 'role_id', 'options' => $roles, 'selected'=>isset($user)?$user->role_id:set_value('role_id'))) .'<br />';
    echo form_label('Email', 'email') .'<br />';
    echo form_input(array('name' => 'email', 'value' => isset($user)?$user->email:set_value('email'))) .'<br />';
    echo form_error('email');
    echo form_label('Password (if editing an existing user, leave blank to keep same password)', 'password') .'<br />';
    echo form_password(array('name' => 'password', 'value' => set_value('password'))) .'<br />';
    echo form_error('password');
    echo form_label('Confirm Password', 'password_conf') .'<br />';
    echo form_password(array('name' => 'password_conf', 'value' => set_value('password_conf'))) .'<br />';
    echo form_error('password_conf');
    echo form_submit(array('type' => 'submit', 'value' => isset($user)?'Save':'Add'));
    echo form_close();
