<?php

header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json; charset=UTF-8");
require_once("conn.settings.php");
require_once("core.php");

$logdata='';
$jobsArray='';
$user_id=filter_input(INPUT_POST,"user_id");//'$2y$10$B4O9pBGqz/aXlIMYurb6aemuPsOxvt4ShRlhhUaBG5iaZU.ilO6Ya';

$query="SELECT * FROM clients WHERE user_id = '".$user_id."' ORDER BY id DESC";
$result=mysqli_query($mysqli,$query);
$count=mysqli_num_rows($result);

if($count>=1){
    $i=0;
    while($data=mysqli_fetch_array($result)){
        $i++;
        $jobsArray.='{';
        $jobsArray.='"job_id":"'. preg_replace( "/\r|\n/", " ", $data['job_id']). '", ';
        $jobsArray.='"title":"'. preg_replace( "/\r|\n/", " ", $data['jobtitle']). '", ';
        $jobsArray.='"jobtype":"'. preg_replace( "/\r|\n/", " ", $data['jobtype']). '", ';
        $jobsArray.='"budget":"'. preg_replace( "/\r|\n/", " ", $data['jobbudget']). '", ';
        $jobsArray.='"posted":"'. preg_replace( "/\r|\n/", " ", $data['created_at']). '"} ';

        if($i<$count){
            $jobsArray.=',';
        }
    }

    
    $logdata='{';
    $logdata.='"response":"OK",';
    $logdata.='"jobs":'."[{$jobsArray}]".'}'; 
    echo "{$logdata}";
     
}else{
    echo '{"response":"NO"}';
}

?>