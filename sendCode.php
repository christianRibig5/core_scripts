<?php
header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json; charset=UTF-8");
require_once("conn.settings.php");

require_once("core.php");

$userPhoneNumber=trim(filter_input(INPUT_POST,"phone"));
$email=trim(filter_input(INPUT_POST,"email"));

$log_data='';
$SMS=new OTP($userPhoneNumber);


if(EmailExist($mysqli,$email)){
    $log_data='{'; 
    $log_data.= '"response": "emailExist",';
    $log_data.= '"msg": "This email already exist"';
    $log_data.='}' ;
    echo "{$log_data}";
}else{

    if($SMS->sendOTP()){
        $code=$SMS->getCode();
        //$result=$SMS->getResult();

        $log_data='{'; // used to log catched data of user from msqldb
            $log_data.= '"code": "' . preg_replace( "/\r|\n/", " ", $code ). '", ';
            $log_data.= '"response": "tokenSuccess"';
            $log_data.='}' ;
            echo "{$log_data}";	
    }
}



?>