<?php
   
   header("Access-Control-Allow-Origin:*");
   header("Content-Type:application/json; charset=UTF-8");
   require_once("conn.settings.php");
   require_once("core.php");
   
   $log_data="";
   

   $artisanId=filter_input(INPUT_POST,"artisan_user_id");
   $artisanTradeType=filter_input(INPUT_POST,"tradetype");
   $query="SELECT clients.jobtitle,clients.jobcity,clients.jobstate,client.created_at FROM clients 
            INNER JOIN users ON clients.user_id = users.user_id 
            WHERE clients.quoting_artisan_id='".$artisanId."' AND clients.quote_invite=1";
          $result=mysqli_query($mysqli,$query);
          $count=mysqli_num_rows($result);