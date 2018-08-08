<?php
header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json; charset=UTF-8");
require_once("conn.settings.php");
require_once("core.php");

$log_data="";
$artisan_reviews_array="";

$artisan_id=filter_input(INPUT_POST,"artisan_id");

$query="SELECT * FROM artisans WHERE artisan_id='".$artisan_id."'";
$result=mysqli_query($mysqli,$query);
if($data=mysqli_fetch_array($result)){

    $query2="SELECT client_reviews.job_id,client_reviews.comments,client_reviews.created_at,users.firstname,clients.jobtitle FROM client_reviews INNER JOIN users ON client_reviews.client_id=users.user_id INNER JOIN clients ON client_reviews.job_id=clients.job_id WHERE client_reviews.artisan_user_id='".$artisan_id."'";
    $result2=mysqli_query($mysqli,$query2);
    $count=mysqli_num_rows($result2);

    if($count>=1){
        $i=0;
        while($data2=mysqli_fetch_array($result2)){
            $i++;
            $artisan_reviews_array.='{';
                $artisan_reviews_array.='"job_id":"'. preg_replace( "/\r|\n/", " ", $data2['job_id']). '", ';
                $artisan_reviews_array.='"jobTitle":"'. preg_replace( "/\r|\n/", " ", $data2['jobtitle']). '", ';
                $artisan_reviews_array.='"reviewMessage":"'. preg_replace( "/\r|\n/", " ", $data2['comments']). '", ';
                $artisan_reviews_array.='"reviewInfo":"'. preg_replace( "/\r|\n/", " ","Reviewed by ". $data2['firstname']." on ".$data2['created_at']). '"} ';
                if($i<$count){
                    $artisan_reviews_array.=',';
                }
            

        }
    }

    $logdata='{';
        $logdata.='"response":"OK",';
        $logdata.='"companyName":"'. preg_replace( "/\r|\n/", " ", $data['companyname']). '", ';
        $logdata.='"tradeType":"'. preg_replace( "/\r|\n/", " ", $data['tradetype']). '", ';
        $logdata.='"location":"'. preg_replace( "/\r|\n/", " ", $data['city']." ".$data['state']). '", ';
        $logdata.='"registered":"'. preg_replace( "/\r|\n/", " ","Registered Member since ". $data['created_at']). '", ';
        $logdata.='"about":"'. preg_replace( "/\r|\n/", " ", $data['description']). '", ';
        $logdata.='"image":"'. preg_replace( "/\r|\n/", " ", $data['avatar']). '", ';
        $logdata.='"skills":'. preg_replace( "/\r|\n/", " ", $data['othertradetypes']). ', ';
        $logdata.='"reviews":'."[{$artisan_reviews_array}]".'}'; 
        echo "{$logdata}";
}else{
    echo '{"response":"NO"}';
}




?>