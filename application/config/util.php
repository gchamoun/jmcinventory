<?php

function debug($obj,$exit=false) {
    echo "<pre>";
    print_r($obj);
    echo "</pre>";
    if($exit) exit;
}