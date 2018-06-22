

<?php
   
   header("Access-Control-Allow-Origin:*");
    header("Content-Type:application/json; charset=UTF-8");
    require("conn.settings.php");
    
    $log_data="";
    
    
    $firstname= 'Chisom';//filter_input(INPUT_POST,"firstname");
    $lastname='Onyeukwu';//filter_input(INPUT_POST,"lastname");
    $email='faitheze855@gmail.com';//filter_input(INPUT_POST,"email");
    $phone='07031293778';//filter_input(INPUT_POST,"phone");
    $password='aaaaaaaa';//filter_input(INPUT_POST,"password");
    $hashedpwd=password_hash($password,PASSWORD_DEFAULT);
    $role ='Artisan';//filter_input(INPUT_POST,"artisan");
    $user_id =password_hash(uniqid(),PASSWORD_DEFAULT);
    $email_confirmed=0;
    $verification_token=rand();
    $remember_token='';
    $regTime=date('Y-m-d H:i:s',time());
    $created_at= $regTime;
    $updated_at = $regTime;
    

    $query1="SELECT email FROM users WHERE email = '".$email."'";
    $result1=mysqli_query($mysqli,$query1);
    $data1=mysqli_fetch_array($result1);
    $count=mysqli_num_rows($result1);
    
        if($count>=1){
            $log_data='{'; 
                $log_data.= '"response": "emailExist"';
                $log_data.= '"msg": "THIS EMAIL ALREADY EXISTS"';
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
                        $log_data.= '"response": "OK"';
                        $log_data.= '"msg": "REGISTRATION SUCCESSFUL"';
                        $log_data.='}' ;
                    echo "{$log_data}";
                }else{ 
                    $log_data='{'; 
                        $log_data.= '"response": "NO"';
                        $log_data.= '"msg": "REGISTRATION UNSUCCESSFUL"';
                        $log_data.='}' ;
                    echo "{$log_data}";
                }
        }
    
    
   
    

?>
