<?php
   
    header("Access-Control-Allow-Origin:*");
    header("Content-Type:application/json; charset=UTF-8");
    require_once("conn.settings.php");
    require_once("core.php");
    
    $log_data="";
    $client_user_id="pEjIokEBMB5REEAi5omN";// filter_input(INPUT_POST,"client_user_id");
    $firstname="Christian";//filter_input(INPUT_POST,"firstname");
    $lastname="Onyeukwu";//filter_input(INPUT_POST,"lastname");
    $query = "UPDATE users SET firstname ='".$firstname."',lastname='".$lastname."' WHERE user_id='".$client_user_id."'";
    if($result= mysqli_query($mysqli,$query)){
        $log_data='{'; 
            $log_data.= '"response": "",';
            $log_data.= '"msg": "client update succesful"';
            $log_data.='}' ;
        echo "{$log_data}"; 
    }else{
        echo mysqli_error($mysqli);
    }