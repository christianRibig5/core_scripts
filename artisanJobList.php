<?php
   
   header("Access-Control-Allow-Origin:*");
   header("Content-Type:application/json; charset=UTF-8");
   require_once("conn.settings.php");
   require_once("core.php");
   
   $log_data="";
   $jobListArray='';
   

   $artisanId="5tyaa7FrNL20Jv2rzju1";//filter_input(INPUT_POST,"artisan_user_id");
   $query="SELECT clients.jobtitle,clients.status,clients.jobcity,clients.jobstate,clients.created_at FROM clients 
            INNER JOIN jobs_requests ON clients.job_id = jobs_requests.job_id 
            WHERE jobs_requests.artisan_user_id='".$artisanId."'";
          $result=mysqli_query($mysqli,$query);
          echo ''.mysqli_error($mysqli);
          $count=mysqli_num_rows($result);
          if($count>=1){
            $i=0;
            while($data=mysqli_fetch_array($result)){
                $i++;
                $jobListArray.='{';
                $jobListArray.='"jobtitle":"'. preg_replace( "/\r|\n/", " ", $data['jobtitle']). '", ';
                $jobListArray.='"artisanId":"'. preg_replace( "/\r|\n/", " ", $data['jobstate']). '", ';
                $jobListArray.='"location":"'. preg_replace( "/\r|\n/", " ", $data['jobcity'].' in '.$data['jobstate']). '", ';
                $jobListArray.='"posted":"'. preg_replace( "/\r|\n/", " ", $data['created_at']). '"} ';
               
                if($i<$count){
                    $jobListArray.=',';
                }
            }
        
            
            $logdata='{';
            $logdata.='"response":"OK",';
            $logdata.='"joblist":'."[{$jobListArray}]".'}'; 
            echo "{$logdata}";
             
        }else{
            echo '{"response":"NO"}';
        }
     