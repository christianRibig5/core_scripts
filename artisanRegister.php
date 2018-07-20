

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
    $token=filter_input(INPUT_POST,"code");
    
            $hashedpwd=password_hash($password,PASSWORD_DEFAULT);
            $role ='Artisan';//filter_input(INPUT_POST,"artisan");
            $user_id =substr(password_hash(uniqid(),PASSWORD_DEFAULT),14);
            $email_confirmed=0;//true because he was confiremed before storing data in db

            $token=filter_input(INPUT_POST,"code");
            $verification_token=password_hash($token,PASSWORD_DEFAULT);
            $remember_token='';
            $remember_token=$token;
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
                       // send mail

                        $log_data='{';
                            $log_data.= '"token": "' . preg_replace( "/\r|\n/", " ", $verification_token ). '", ';
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
