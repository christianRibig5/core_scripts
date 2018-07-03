<?php

require_once("core.php");

$userPhoneNumber=filter_input(INPUT_POST,"phone");
$log_data='';
$SMS=new OTP($userPhoneNumber);



if($SMS->sendOTP()){
    $code=$SMS->getCode();
    $result=$SMS->getResult();

    $log_data='{'; // used to log catched data of user from msqldb
        $log_data.= '"code": "' . preg_replace( "/\r|\n/", " ", $code ). '", ';
        $log_data.= '"response": "OK"';
        $log_data.='}' ;
        echo "{$log_data}";	
}



?>