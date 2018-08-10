<?php
   
   header("Access-Control-Allow-Origin:*");
   header("Content-Type:application/json; charset=UTF-8");
   require_once("conn.settings.php");
   require_once("core.php");
   
   $log_data="";
   

   $artisanId="pEjIokEBMB5REEAi5omN";//filter_input(INPUT_POST,"artisan_user_id");
  
   $query="SELECT * FROM clients 
            INNER JOIN users ON clients.user_id = users.user_id 
            WHERE clients.quoting_artisan_id='".$artisanId."' AND clients.quote_invite=1";
          $result=mysqli_query($mysqli,$query);
          $count=mysqli_num_rows($result);
          if($count>=1){
            $i=0;
            while($data=mysqli_fetch_array($result)){
                $i++;
                $quotedJobsArray.='{';
                $quotedJobsArray.='"jobtitle":"'. preg_replace( "/\r|\n/", " ", $data['jobtitle']). '", ';
                $quotedJobsArray.='"artisanId":"'. preg_replace( "/\r|\n/", " ", $data['jobstate']). '", ';
                $quotedJobsArray.='"location":"'. preg_replace( "/\r|\n/", " ", $data['jobcity'].' in '.$data['jobstate']). '", ';
                $quotedJobsArray.='"posted":"'. preg_replace( "/\r|\n/", " ", $data['created_at']). '"} ';
               
                if($i<$count){
                    $quotedJobsArray.=',';
                }
            }
        
            
            $logdata='{';
            $logdata.='"response":"OK",';
            $logdata.='"joblist":'."[{$quotedJobsArray}]".'}'; 
            echo "{$logdata}";
             
        }else{
            echo '{"response":"NO"}';
        }