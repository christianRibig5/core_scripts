

<?php
   
    header("Access-Control-Allow-Origin:*");
    header("Content-Type:application/json; charset=UTF-8");
    require_once("conn.settings.php");
    require_once("core.php");
    
    $log_data="";
    
    
    $firstname= filter_input(INPUT_POST,"firstname");
    $lastname=filter_input(INPUT_POST,"lastname");
    $email=filter_input(INPUT_POST,"email");
    $phone=filter_input(INPUT_POST,"phone");
    $password=filter_input(INPUT_POST,"password");
    
            $hashedpwd=password_hash($password,PASSWORD_DEFAULT);
            $role ='Artisan';//filter_input(INPUT_POST,"artisan");
            $user_id =password_hash(uniqid(),PASSWORD_DEFAULT);
            $email_confirmed=0;
            $verification_token=generatePIN(4);
            $remember_token='';
            $regTime=date('Y-m-d H:i:s',time());
            $created_at= $regTime;
            $updated_at = $regTime;
    
        
    
    
            if(EmailExist($mysqli,$email)){
                $log_data='{'; 
                $log_data.= '"response": "emailExist",';
                $log_data.= '"msg": "This email already exist"';
                $log_data.='}' ;
                echo "{$log_data}";
            }else{
                    $query2 ="INSERT INTO
                    users(id,user_id,firstname,lastname,email,phone,password,email_confirmed,verification_token,
                    remember_token,role,created_at,updated_at) VALUES ('0','$user_id','$firstname','$lastname','$email','$phone',
                    '$hashedpwd','$email_confirmed','$verification_token','$remember_token','$role','$created_at','$updated_at')";
                    if(mysqli_query($mysqli,$query2)){
                        // send an otp code comes here
                        $log_data='{'; 
                            $log_data.= '"response": "regSuccess",';
                            $log_data.= '"msg": "Registration successful"';
                            $log_data.='}' ;
                        echo "{$log_data}";
                    }else{ 
                        $log_data='{'; 
                            $log_data.= '"response": "regFailure",';
                            $log_data.= '"msg": "Registration unsuccesful"';
                            $log_data.='}' ;
                        echo "{$log_data}";
                    }
            }
        
    
    
   
    

?>
