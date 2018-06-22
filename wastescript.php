

<?php
   require("conn.settings.php");
    
    $firstname= "chris";//filter_input(INPUT_POST,"firstname");
    $lastname="ony";//filter_input(INPUT_POST,"lastname");
    $email="g@gmail.com";//filter_input(INPUT_POST,"email");
    $phone="09866";//filter_input(INPUT_POST,"phone");
    $password="123";//filter_input(INPUT_POST,"password");
    $hashedpwd=password_hash($password,PASSWORD_DEFAULT);
  
    $query ="INSERT INTO users(firstname, lastname,email,phone,password)
            VALUES($firstname,$lastname,$email, $phone,$hashedpwd)";
    if(mysqli_query($mysqli,$query)){
        echo 'register success';
    }else{ 
        echo 'registeration failure';
    }
    

?>



<?php /*

        $email= filter_input(INPUT_POST,"email");
        $password=filter_input(INPUT_POST,"password");
        require("conn.settings.php");
        $query ="SELECT * FROM users 
                WHERE email ='".$email."'";
        $result=mysqli_query($mysqli,$query);
        if($data=mysqli_fetch_array($result)){
            if(password_verify($password,$data['password'])){
                echo 1;
            }  else{
                echo 0;
            } 
        }else{
           echo "invalid user id";   
        }
        
*/?>

