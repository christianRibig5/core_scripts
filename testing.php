<?php
header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json; charset=UTF-8");
require_once("conn.settings.php");
require_once("core.php");

$log_data="";

$new_password='aaa';
$hashedpwd=password_hash($new_password,PASSWORD_DEFAULT);
$updated_at=date('Y-m-d H:i:s',time());


$query2="UPDATE users SET password = '".$hashedpwd."', updated_at='".$updated_at."'";

if(mysqli_query($mysqli,$query2)){
    $log_data='{'; 
        $log_data.= '"response": "OK",';
        $log_data.= '"newPassword": "'. preg_replace( "/\r|\n/", " ", $new_password). '"';
        $log_data.='}' ;
        echo "{$log_data}";
}






?>