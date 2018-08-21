<?php
   
    header("Access-Control-Allow-Origin:*");
    header("Content-Type:application/json; charset=UTF-8");
    require_once("conn.settings.php");
    require_once("core.php");
    
    $log_data="";
    $artisan_id=sanitizeVar(filter_input(INPUT_POST,"artisan_id"));
    $companyName=sanitizeVar(filter_input(INPUT_POST,"companyname"));
    $address=sanitizeVar(filter_input(INPUT_POST,"address"));
    $city=sanitizeVar(filter_input(INPUT_POST,"city"));
    $state=sanitizeVar(filter_input(INPUT_POST,"state"));
    $updated_at=date('Y-m-d H:i:s',time());
    $query="UPDATE artisans SET companyname='".$companyName."', address='".$address."', city='".$city."', state='".$state."', updated_at='".$updated_at."' WHERE user_id='".$artisan_id."'";
    if(mysqli_query($mysqli,$query)){
        $log_data='{'; 
            $log_data.= '"response": "OK",';
            $log_data.= '"msg": "artisan update succesful"';
            $log_data.='}' ;
        echo "{$log_data}"; 
    }else{
        $log_data='{'; 
            $log_data.= '"response": "NO",';
            $log_data.= '"msg": "Problem updating artisan profile"';
            $log_data.='}' ;
            echo mysqli_error($mysqli)."{$log_data}";
    }

    
    
   
    
          
?>