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
        $userID=$data['user_id'];
    }
    $artisanID='';
    
    $status='unapproved';
    $companyName= filter_input(INPUT_POST,"companyname");
    $tradeType=filter_input(INPUT_POST,"tradetype");
    $otherTradeTypes=filter_input(INPUT_POST,"othertradetypes");
    $phone=filter_input(INPUT_POST,"phone");
    $password=filter_input(INPUT_POST,"password");
    $token=filter_input(INPUT_POST,"code");
    
            
    
        
    
    
          
                    $query2 ="INSERT INTO
                    users(id,user_id,firstname,lastname,email,phone,password,email_confirmed,verification_token,
                    remember_token,role,created_at,updated_at) VALUES ('0','$user_id','$firstname','$lastname','$email','$phone',
                    '$hashedpwd','$email_confirmed','$verification_token','$remember_token','$role','$created_at','$updated_at')";
      
            ?>