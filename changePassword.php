<?php

header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json; charset=UTF-8");
require_once("conn.settings.php");
require_once("core.php");

$log_data="";


$user_id=filter_input(INPUT_POST,"user_id");
$old_password=filter_input(INPUT_POST,"old_password");
$new_password=filter_input(INPUT_POST,"new_password");
$hashedpwd=password_hash($new_password,PASSWORD_DEFAULT);
$updated_at=date('Y-m-d H:i:s',time());

$query="SELECT password FROM users WHERE user_id = '".$user_id."'";
$result=mysqli_query($mysqli,$query);
$data=mysqli_fetch_array($result);

if(password_verify($old_password,$data['password'])){
    $query2="UPDATE users SET password = '".$hashedpwd."', updated_at='".$updated_at."' WHERE user_id = '".$user_id."'";

    if(mysqli_query($mysqli,$query2)){
        $log_data='{'; 
            $log_data.= '"response": "OK",';
            $log_data.= '"newPassword": "'. preg_replace( "/\r|\n/", " ", $new_password). '"';
            $log_data.='}' ;
            echo "{$log_data}";
    }

}else{
    $log_data='{'; 
        $log_data.= '"response": "NO",';
        $log_data.= '"msg": "This password does not match"';
        $log_data.='}' ;
        echo "{$log_data}";
}




?>