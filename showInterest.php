

<?php
   /*
    ShowInterest.php module is used to hold all job the artisan has indicated interest.
   */
   header("Access-Control-Allow-Origin:*");
   header("Content-Type:application/json; charset=UTF-8");
   require_once("conn.settings.php");
   require_once("core.php");
   
   $log_data="";
   
   //TODO: test for validity of the script
   $job_id="VpbOU8C7yy";// filter_input(INPUT_POST,"job_id");
   $artisan_user_id="5tyaa7FrNL20Jv2rzju1";// filter_input(INPUT_POST,"artisan_user_id");
   $job_status="Awaiting Approval";
   $regTime=date('Y-m-d H:i:s',time());
    $created_at= $regTime;
    $updated_at = $regTime;
   

   
        $query ="INSERT INTO jobs_requests(id,job_id,artisan_user_id,job_status,created_at,updated_at)
                 VALUES ('0','$job_id','$artisan_user_id','$job_status','$created_at','$updated_at')";
        if(mysqli_query($mysqli,$query)){
            $log_data='{'; 
             $log_data.= '"response": "OK",';
             $log_data.= '"msg": "Artisan Interested recorded"';
             $log_data.='}' ;
             echo "{$log_data}";
                   
           }else{
               //just for error checking during testing
             //  echo mysqli_error($mysqli);
           }
       
   
   
  
   

?>
