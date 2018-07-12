<?php
   
    header("Access-Control-Allow-Origin:*");
    header("Content-Type:application/json; charset=UTF-8");
    require_once("conn.settings.php");
    require_once("core.php");
    
    $log_data="";
    $email= filter_input(INPUT_POST,"email");// comes from sharedprefferences android
    // all data from users table
    $query1 = "SELECT user_id FROM users WHERE email='".$email."'";
    $result= mysqli_query($mysli,$query1);
    if($data=mysqli_fetch_array($result)){
        $user_id =$data['user_id'];
    }
    $artisan_id=password_hash(uniqid(),PASSWORD_DEFAULT);
    $status='unapproved';
    $companyName= filter_input(INPUT_POST,"companyname");
    $tradeType=filter_input(INPUT_POST,"tradetype");
    $otherTradeTypes=filter_input(INPUT_POST,"othertradetypes");
    $address=filter_input(INPUT_POST,"address");
    $city=filter_input(INPUT_POST,"city");
    $state=filter_input(INPUT_POST,"state");
    $country=filter_input(INPUT_POST,"country");
    $distanceToWork=filter_input(INPUT_POST,"distancetowork");
    $aboutBusiness=filter_input(INPUT_POST,"description");
    $textAlert=filter_input(INPUT_POST,"textalert");
    $alertViaMail=filter_input(INPUT_POST,"alertviamail");
    $newsLetter=filter_input(INPUT_POST,"newsletter");
    $profilePics=filter_input(INPUT_POST,"avartar");
    $paystaus=0;
    $webname='';
    $joindate='';//sam as created_at 
    $renewaldate='';//and updated_at


    $query2 ="INSERT INTO artisan(id,artisan_id,user_id,status,companyname,tradetype,
    othertradetypes,address,city,state,country,role,distancetowork,description,
    textalert,alertviamail,newsletter,avartar,created_at,updated_at) 
    VALUES ('0',$artisan_id,'$user_id','$status','$lastname','$companyName','$tradeType',
    '$otherTradeTypes','$address','$city','$state','$country',
    $distanceToWork,$aboutBusiness,$profilePics,$textAlert,$alertViaMail'
    $newsLetter,$paystaus,$webname,$joindate,$renewaldate,$created_at','$updated_at')";
    if(mysqli_query($mysli,$query2)){
        $log_data='{';
            $log_data.= '"response": "updateSuccess",';
            $log_data.= '"msg": "artisan Update successful"';
            $log_data.='}' ;
        echo "{$log_data}";
    }else{
        $log_data='{'; 
            $log_data.= '"response": "updateFailure",';
            $log_data.= '"msg": "artisan update unsuccesful"';
            $log_data.='}' ;
        echo "{$log_data}";
    }

    
          
?>