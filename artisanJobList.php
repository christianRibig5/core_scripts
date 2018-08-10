<?php
   
   header("Access-Control-Allow-Origin:*");
   header("Content-Type:application/json; charset=UTF-8");
   require_once("conn.settings.php");
   require_once("core.php");
   
   $log_data="";
   $jobListArray='';
   

   $artisanId=filter_input(INPUT_POST,"artisan_user_id");
   $query="SELECT clients.jobtitle,clients.status,clients.jobcity,clients.jobstate,clients.created_at,
   clients.job_id,clients.jobtype,clients.jobdescription,clients.jobtiming,clients.jobbudget,
   clients.jobaddress,clients.jobcountry,jobs_requests.artisan_user_id FROM clients INNER JOIN jobs_requests ON clients.job_id = jobs_requests.job_id WHERE jobs_requests.artisan_user_id='".$artisanId."'";
          $result=mysqli_query($mysqli,$query);
          echo ''.mysqli_error($mysqli);
          $count=mysqli_num_rows($result);
          if($count>=1){
            $i=0;
            while($data=mysqli_fetch_array($result)){
                $i++;
                $jobListArray.='{';
                $jobListArray.='"jobtitle":"'. preg_replace( "/\r|\n/", " ", $data['jobtitle']). '", ';
                $jobListArray.='"job_id":"'. preg_replace( "/\r|\n/", " ", $data['job_id']). '", ';
                $jobListArray.='"jobtype":"'. preg_replace( "/\r|\n/", " ", $data['jobtype']). '", ';
                $jobListArray.='"budget":"'. preg_replace( "/\r|\n/", " ", $data['jobbudget']). '", ';
                $jobListArray.='"timing":"'. preg_replace( "/\r|\n/", " ", $data['jobtiming']). '", ';
                $jobListArray.='"description":"'. preg_replace( "/\r|\n/", " ", $data['jobdescription']). '", ';
                $jobListArray.='"address":"'. preg_replace( "/\r|\n/", " ", $data['jobaddress']). '", ';
                if($data['status']=="Job Completed"){
                    $query3="SELECT * FROM client_reviews INNER JOIN artisans ON 
                    client_reviews.artisan_user_id=artisans.artisan_id WHERE 
                    client_reviews.job_id='".$data['job_id']."'";
                    $result3=mysqli_query($mysqli,$query3);
                    $data3=mysqli_fetch_array($result3);
                    $jobListArray.='"artisanId":"'. preg_replace( "/\r|\n/", " ", $data3['user_id']). '", ';
                }else{
                    $jobListArray.='"artisanId":"1", ';
                }
                $jobListArray.='"location":"'. preg_replace( "/\r|\n/", " ", $data['jobcity'].' in '.$data['jobstate']). '", ';
                $jobListArray.='"status":"'. preg_replace( "/\r|\n/", " ", $data['status']). '", ';
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
     