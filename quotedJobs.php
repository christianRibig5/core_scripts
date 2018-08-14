<?php
   
   header("Access-Control-Allow-Origin:*");
   header("Content-Type:application/json; charset=UTF-8");
   require_once("conn.settings.php");
   require_once("core.php");
   
   $log_data="";
   $quotedJobsArray="";
   

   $artisanId=filter_input(INPUT_POST,"artisanId");
   $artisanData=getArtisanData($mysqli,$artisanId);
   $artisan_user_id=$artisanData['artisan_id'];
  
   $query="SELECT * FROM clients 
            INNER JOIN users ON clients.user_id = users.user_id 
            WHERE clients.quoting_artisan_id='".$artisan_user_id."' AND clients.quote_invite='1' ORDER BY clients.id DESC";
          $result=mysqli_query($mysqli,$query);
          $count=mysqli_num_rows($result);
          if($count>=1){
            $i=0;
            while($data=mysqli_fetch_array($result)){
                $i++;
                $quotedJobsArray.='{';
                $quotedJobsArray.='"job_id":"'. preg_replace( "/\r|\n/", " ", $data['job_id']). '", ';
                $quotedJobsArray.='"job_title":"'. preg_replace( "/\r|\n/", " ", $data['jobtitle']). '", ';
                $quotedJobsArray.='"jobtype":"'. preg_replace( "/\r|\n/", " ", $data['jobtype']). '", ';
                $quotedJobsArray.='"job_budget":"'. preg_replace( "/\r|\n/", " ", $data['jobbudget']). '", ';
                $quotedJobsArray.='"job_posted":"'. preg_replace( "/\r|\n/", " ", $data['created_at']). '", ';
                $quotedJobsArray.='"intrest":"'. preg_replace( "/\r|\n/", " ", "1"). '", ';
                $quotedJobsArray.='"job_timing":"'. preg_replace( "/\r|\n/", " ", $data['jobtiming']). '", ';
                $quotedJobsArray.='"job_description":"'. preg_replace( "/\r|\n/", " ", $data['jobdescription']). '", ';
                $quotedJobsArray.='"job_location":"'. preg_replace( "/\r|\n/", " ",$data['jobaddress']). '"} ';
               
                if($i<$count){
                    $quotedJobsArray.=',';
                }
            }
        
            
            $logdata='{';
            $logdata.='"response":"OK",';
            $logdata.='"requestedQuotes":'."[{$quotedJobsArray}]".'}'; 
            echo "{$logdata}";
             
        }else{
            echo '{"response":"NO"}';
        }