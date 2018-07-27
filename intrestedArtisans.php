<?php

header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json; charset=UTF-8");
require_once("conn.settings.php");
require_once("core.php");

$logdata='';
$artisansArray='';


$job_id=filter_input(INPUT_POST,"job_id");


$query1="SELECT * FROM artisans INNER JOIN  jobs_requests ON artisans.user_id=jobs_requests.user_id INNER JOIN users ON artisans.user_id=users.user_id WHERE jobs_requests.job_id='".$job_id."' ORDER BY jobs_requests.id DESC";

$result=mysqli_query($mysqli,$query1);
$count=mysqli_num_rows($result);
//echo ' '.mysqli_error($mysqli);
if($count>=1){
    $i=0;
    while($data=mysqli_fetch_array($result)){
        $i++;
        $artisansArray.='{';
            $artisansArray.='"user_id":"'. preg_replace( "/\r|\n/", " ", $data['user_id']). '", ';
            $artisansArray.='"companyname":"'. preg_replace( "/\r|\n/", " ", $data['companyname']). '", ';
            $artisansArray.='"firstname":"'. preg_replace( "/\r|\n/", " ", $data['firstname']). '", ';
            $artisansArray.='"lastname":"'. preg_replace( "/\r|\n/", " ", $data['lastname']). '", ';
            $artisansArray.='"email":"'. preg_replace( "/\r|\n/", " ", $data['email']). '", ';
            $artisansArray.='"phone":"'. preg_replace( "/\r|\n/", " ", $data['phone']). '"} ';
    
            if($i<$count){
                $artisansArray.=',';
            }
        

    }

    $logdata='{';
        $logdata.='"response":"OK",';
        $logdata.='"artisans":'."[{$artisansArray}]".'}'; 
        echo "{$logdata}";
}else{
    echo '{"response":"NO"}';
}


?>