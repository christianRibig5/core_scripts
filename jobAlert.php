<?php
   
   header("Access-Control-Allow-Origin:*");
   header("Content-Type:application/json; charset=UTF-8");
   require_once("conn.settings.php");
   require_once("core.php");
   
   $log_data="";

   $treadeType=filter_input(INPUT_POST,"tradetype");
   $query="SELECT * FROM clients INNER JOIN
          jobs_requests ON clients.job_id = jobs_requests.job_id WHERE clients.jobtype= $tradeType";
          $result=mysqli_query($mysqli,$query);
          $count=mysqli_num_rows($result);
          
          if($count>=1){
            $i=0;
            while($data=mysqli_fetch_array($result)){
                $i++;
                $jobsDetailaArray.='{';
                $JobsDetailArray.='"job_id":"'. preg_replace( "/\r|\n/", " ", $data['job_id']). '", ';
                $JobsDetailArray.='"user_id":"'. preg_replace( "/\r|\n/", " ", $data['jobtitle']). '", ';
                $JobsDetailArray.='"clients.status":"'. preg_replace( "/\r|\n/", " ", $data['jobtype']). '", ';
                $JobsDetailArray.='"jobtype":"'. preg_replace( "/\r|\n/", " ", $data['jobbudget']). '", ';
                $JobsDetailArray.='"jobdescription":"'. preg_replace( "/\r|\n/", " ", $data['created_at']). '", ';
                $JobsDetailArray.='"jobtiming":"'. preg_replace( "/\r|\n/", " ", $data['jobtiming']). '", ';
                $JobsDetailArray.='"jobaddress":"'. preg_replace( "/\r|\n/", " ", $data['jobdescription']). '", ';
                $JobsDetailArray.='"jobcity":"'. preg_replace( "/\r|\n/", " ",$data['jobaddress']). '"} ';
        
                if($i<$count){
                    $JobsDetailArray.=',';
                }
            }
        
            
            $logdata='{';
            $logdata.='"response":"OK",';
            $logdata.='"jobs":'."[{$JobsDetailArray}]".'}'; 
            echo "{$logdata}";
             
        }else{
            echo '{"response":"NO"}';
        }
     

?>