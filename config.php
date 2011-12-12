<?php 
// Get your own key here: http://api.centroidmedia.com/apply-for-an-api-key.html
$private_key = "xxx";
$public_key = "xxx";

function __autoload($class_name) {
    if(file_exists(dirname(__FILE__).'/class/'.$class_name . '.php')) {
        require_once(dirname(__FILE__).'/class/'.$class_name . '.php');
        return;
    }    
} 
?>