<?php
   
    header("Access-Control-Allow-Origin:*");
    header("Content-Type:application/json; charset=UTF-8");
    require_once("conn.settings.php");
    require_once("core.php");
    
    $log_data="";
    $email= filter_input(INPUT_POST,"email");
    // all data from users table
    $query1 = "SELECT * FROM users WHERE email='".$email."'";
    $result= mysqli_query($mysli,$query1);
    if($data=mysqli_fetch_array($result)){
        $userId =$data['user_id'];
    }
    $artisanId='';
    
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

    $query = "UPDATE artisan SET 
             user_id = '$userId', 
             status = '$status',
             companyname ='$companyName',


             WHERE email = $email";
             $result=mysqli_query($mysli,$query);
          
                    

                   
      
            ?>