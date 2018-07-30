<?php
header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json; charset=UTF-8");
require_once("conn.settings.php");
require_once("core.php");

$log_data="";

$job_id=filter_input(INPUT_POST,"job_id");
$artisan_id=filter_input(INPUT_POST,"artisan_id");
$client_id=filter_input(INPUT_POST,"client_id");
$quality_review=filter_input(INPUT_POST,"quality_review");
$reliability_review=filter_input(INPUT_POST,"reliability_review");
$value_review=filter_input(INPUT_POST,"value_review");
$comment=filter_input(INPUT_POST,"comment");

$regTime=date('Y-m-d H:i:s',time());
$created_at=$regTime;
$Updated_at=$regTime;

$query="INSERT INTO client_reviews (id,client_id,job_id,artisan_user_id,quality_review,reliability_review,value_review,comments,created_at,updated_at) VALUES ('0','$client_id','$job_id','$artisan_id','$quality_review','$reliability_review','$value_review','$comment','$created_at','$Updated_at')";
if(mysqli_query($mysqli,$query)){
    $log_data='{';
        $log_data.= '"response": "ReviewPostSuccess",';
        $log_data.= '"msg": "Client review posted successfully"';
        $log_data.='}' ;
    echo "{$log_data}";
}else{
    $log_data='{'; 
        $log_data.= '"response": "ReviewPostFailed",';
        $log_data.= '"msg": "Client review post unsuccesful"';
        $log_data.='}' ;
    echo "{$log_data}".mysqli_error($mysqli);
}



?>