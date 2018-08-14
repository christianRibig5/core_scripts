<?php
   
    header("Access-Control-Allow-Origin:*");
    header("Content-Type:application/json; charset=UTF-8");
    require_once("conn.settings.php");
    require_once("core.php");
    
    $log_data="";
    $artisan_id="G3rqSSfAz5Du8CP";// filter_input(INPUT_POST,"artisan_id");
    $companyName="Ribigs Photos";//filter_input(INPUT_POST,"companyname");
    $tradeType="Phography";//filter_input(INPUT_POST,"tradetype");
    $address="87 Ikeja road";//filter_input(INPUT_POST,"address");
    $city="Lagos";//filter_input(INPUT_POST,"city");
    $state="Lagos";//filter_input(INPUT_POST,"state");
    $query = "UPDATE artisans SET companyname ='".$companyName."',tradetype='".$tradeType."', address='".$address."',
     city='".$city."', state='".$state."' WHERE artisan_id='".$artisan_id."'";
    if($result= mysqli_query($mysqli,$query)){
        $log_data='{'; 
            $log_data.= '"response": "",';
            $log_data.= '"msg": "artisan update succesful"';
            $log_data.='}' ;
        echo "{$log_data}"; 
    }else{
        echo mysqli_error($mysqli);
    }

    
    
   
    
          
?>