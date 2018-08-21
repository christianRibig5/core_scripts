<?php
   
    header("Access-Control-Allow-Origin:*");
    header("Content-Type:application/json; charset=UTF-8");
    require_once("conn.settings.php");
    require_once("core.php");
    
    $log_data="";
    $client_user_id=filter_input(INPUT_POST,"client_user_id");
    $firstname=filter_input(INPUT_POST,"firstname");
    $lastname=filter_input(INPUT_POST,"lastname");
    $updated_at=date('Y-m-d H:i:s',time());
    $query = "UPDATE users SET firstname ='".$firstname."',lastname='".$lastname."',updated_at='".$updated_at."' WHERE user_id='".$client_user_id."'";
    if($result= mysqli_query($mysqli,$query)){
        $log_data='{'; 
            $log_data.= '"response": "OK",';
            $log_data.= '"msg": "client update succesful"';
            $log_data.='}' ;
        echo "{$log_data}"; 
    }else{
        $log_data='{'; 
            $log_data.= '"response": "NO",';
            $log_data.= '"msg": "Problem updating client profile"';
            $log_data.='}' ;
            echo "{$log_data}";
    }