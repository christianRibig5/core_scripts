<?php


    header("Access-Control-Allow-Origin:*");
    header("Content-Type:application/json; charset=UTF-8");
    require("conn.settings.php");
    require_once("core.php");

    $log_data="";
    

    $email=filter_input(INPUT_POST,"email");

    if(EmailExist($mysqli,$email)){

        $log_data='{'; 
        $log_data.= '"response": "emailExist"';
        $log_data.= '"msg": "THIS EMAIL ALREADY EXISTS"';
        $log_data.='}' ;

        echo "{$log_data}";
    }else{

        $log_data='{'; 
        $log_data.= '"response": "OK"';
        $log_data.= '"msg": "THIS EMAIL DOES NOT EXIST"';
        $log_data.='}' ;
    
        echo "{$log_data}";
    }

    

?>