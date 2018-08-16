<?php
   
    header("Access-Control-Allow-Origin:*");
    header("Content-Type:application/json; charset=UTF-8");
    require_once("conn.settings.php");
    require_once("core.php");
    
    $log_data="";
    $artisan_id="pEjIokEBMB5REEAi5omN";//filter_input(INPUT_POST,"artisan_id");
    
    $query="SELECT client_reviews.job_id,client_reviews.comments,client_reviews.created_at,users.firstname,clients.jobtitle
     FROM client_reviews INNER JOIN users ON client_reviews.client_id=users.user_id INNER JOIN clients ON client_reviews.job_id=clients.job_id
      WHERE client_reviews.artisan_user_id='".$artisan_id."'";
    $result=mysqli_query($mysqli,$query);
    $count=mysqli_num_rows($result);
    if($count>=1){
        $i=0;
        while($data=mysqli_fetch_array($result)){
            $i++;
            
            $artisan_clients_review_array.='{';
            $artisan_clients_review_array.='"companyName":"'. preg_replace( "/\r|\n/", " ", $data['companyname']). '", ';
            $artisan_clients_review_array.='"locationTrade":"'. preg_replace( "/\r|\n/", " ", $data['tradetype']." in ".$data2['city']). '", ';
            $artisan_clients_review_array.='"registered":"'. preg_replace( "/\r|\n/", " ","Registered Member since ". $data['created_at']). '", ';
            $artisan_clients_review_array.='"about":"'. preg_replace( "/\r|\n/", " ", $data['description']). '", ';
            $artisan_clients_review_array.='"image":"'. preg_replace( "/\r|\n/", " ", $data['avatar']). '", ';
            $artisan_clients_review_array.='"skills":"'. preg_replace( "/\r|\n/", " ", $data['othertradetypes']). '"} ';

            if($i<$count){
                $artisan_clients_review_array.=',';
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
            echo "No";
        }
        
        ?>