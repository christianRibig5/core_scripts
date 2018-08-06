<?php

header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json; charset=UTF-8");
require_once("conn.settings.php");
require_once("core.php");

$log_data="";
$category_artisan_array="";

$cat_id=filter_input(INPUT_POST,"cat_id");

$query1="SELECT * FROM c_a__trade_types WHERE id='".$cat_id."'";
$result1=mysqli_query($mysqli,$query1);
$data1=mysqli_fetch_array($result1);
$count1=mysqli_num_rows($result1);


$query2="SELECT * FROM artisans INNER JOIN client_reviews ON artisans.artisan_id=client_reviews.artisan_user_id WHERE artisans.tradetype='".$data1["tradetype"]."'";
$result2=mysqli_query($mysqli,$query2);
$count=mysqli_num_rows($result2);



if($count1>=1){
    $i=0;
    while($data2=mysqli_fetch_array($result2)){
        $i++;
        $category_artisan_array.='{';
        $category_artisan_array.='"companyName":"'. preg_replace( "/\r|\n/", " ", $data2['companyname']). '", ';
        $category_artisan_array.='"artisan_id":"'. preg_replace( "/\r|\n/", " ", $data2['artisan_id']). '", ';
        $category_artisan_array.='"locationTrade":"'. preg_replace( "/\r|\n/", " ", $data2['tradetype']." in ".$data2['city']). '", ';
        $category_artisan_array.='"about":"'. preg_replace( "/\r|\n/", " ", $data2['description']). '", ';
        $category_artisan_array.='"city":"'. preg_replace( "/\r|\n/", " ", $data2['city']). '", ';
        $category_artisan_array.='"artisanImage":"'. preg_replace( "/\r|\n/", " ", $data2['avatar']). '"} ';

        if($i<$count){
            $category_artisan_array.=',';
        }
    }

    $logdata='{';
        $logdata.='"response":"OK",';
        $logdata.='"catTitle":"'. preg_replace( "/\r|\n/", " ", $data1['tradetype']). '", ';
        $logdata.='"cat_image":"'. preg_replace( "/\r|\n/", " ", $data1['src']). '", ';
        $logdata.='"artisans":'."[{$category_artisan_array}]".'}'; 
        echo "{$logdata}";
}else{
    echo '{"response":"NO"}';
}





?>