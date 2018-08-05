<?php
   
   header("Access-Control-Allow-Origin:*");
   header("Content-Type:application/json; charset=UTF-8");
   require_once("conn.settings.php");
   require_once("core.php");
   
   $log_data="";

   $artisanId=filter_input(INPUT_POST,"artisan_user_id");
   $query="SELECT * FROM clients INNER JOIN
          jobs_review ON clients.job_id = client_review.job_id WHERE client_review.artisan_id= $artisanId";
          $result=mysqli_query($mysqli,$query);
          $count=mysqli_num_rows($result);