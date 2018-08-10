<?php
   
   header("Access-Control-Allow-Origin:*");
   header("Content-Type:application/json; charset=UTF-8");
   require_once("conn.settings.php");
   require_once("core.php");
   
   $log_data="";
   $jobAlertArray="";

   $tradeType=filter_input(INPUT_POST,"tradetype");
   $query="SELECT * FROM users INNER JOIN clients ON users.user_id=clients.user_id
    WHERE clients.jobtype='".$tradeType."' AND clients.quote_invite='0' AND 
    clients.status='Awaiting Quotes' ORDER BY clients.created_at DESC";
          $result=mysqli_query($mysqli,$query);
          $count=mysqli_num_rows($result);
          
          if($count>=1){
            $i=0;
            while($data=mysqli_fetch_array($result)){
                $i++;

                $query2="SELECT id FROM jobs_requests WHERE job_id='".$data['job_id']."'";
                $result2=mysqli_query($mysqli,$query2);
                $count2=mysqli_num_rows($result2);
                //check if upto three artisans have shown intrest and skip the job if true
                if($count2==3){
                    continue;
                }

                $jobAlertArray.='{';
                    $jobAlertArray.='"job_id":"'. preg_replace( "/\r|\n/", " ", $data['job_id']). '", ';
                    $jobAlertArray.='"job_title":"'. preg_replace( "/\r|\n/", " ", $data['jobtitle']). '", ';
                    $jobAlertArray.='"jobtype":"'. preg_replace( "/\r|\n/", " ", $data['jobtype']). '", ';
                    $jobAlertArray.='"job_budget":"'. preg_replace( "/\r|\n/", " ", $data['jobbudget']). '", ';
                    $jobAlertArray.='"job_posted":"'. preg_replace( "/\r|\n/", " ", $data['created_at']). '", ';
                    $jobAlertArray.='"count":"'. preg_replace( "/\r|\n/", " ", $count2). '", ';
                    $jobAlertArray.='"job_timing":"'. preg_replace( "/\r|\n/", " ", $data['jobtiming']). '", ';
                    $jobAlertArray.='"job_description":"'. preg_replace( "/\r|\n/", " ", $data['jobdescription']). '", ';
                    $jobAlertArray.='"job_location":"'. preg_replace( "/\r|\n/", " ",$data['jobaddress']). '"} ';
        
                if($i<$count){
                    $jobAlertArray.=',';
                }
            }
        
            
            $logdata='{';
            $logdata.='"response":"OK",';
            $logdata.='"jobAlert":'."[{$jobAlertArray}]".'}'; 
            echo "{$logdata}";
             
        }else{
            echo '{"response":"NO"}';
        }
     

?>