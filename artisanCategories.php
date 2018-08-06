<?php
header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json; charset=UTF-8");
require_once("conn.settings.php");
require_once("core.php");

$logdata='';
$catArray='';
$user=filter_input(INPUT_POST,"user");
if($user=="app"){
    $query="SELECT * FROM c_a__trade_types";
    $result=mysqli_query($mysqli,$query);
    $count=mysqli_num_rows($result);


    if($count>=1){
        $i=0;
        while($data=mysqli_fetch_array($result)){
            $i++;
            $catArray.='{';
            $catArray.='"id":"'. preg_replace( "/\r|\n/", " ", $data['id']). '", ';
            $catArray.='"title":"'. preg_replace( "/\r|\n/", " ", $data['trade']). '", ';
            $catArray.='"img":"'. preg_replace( "/\r|\n/", " ", $data['src']). '"} ';

            if($i<$count){
                $catArray.=',';
            }
        }

        $logdata='{';
            $logdata.='"response":"OK",';
            $logdata.='"categories":'."[{$catArray}]".'}'; 
            echo "{$logdata}";
    }else{
        echo '{"response":"NO"}';
    }
}






?>