


<?php
  header("Access-Control-Allow-Origin:*");
	header("Content-Type:application/json; charset=UTF-8");
	
	require("conn.settings.php");

//if($_SERVER["REQUEST_METHOD"]="POST"){
		
 
//if(isset($_POST['email']) && isset($_POST['password']) ){
$email=filter_input(INPUT_POST,"email");
$password=filter_input(INPUT_POST,"password");
$log_data="";


$result=mysqli_query($mysqli,$query);
if($data=mysqli_fetch_array($result)){
    if(password_verify($password,$data['password'])){
        /////// do here 1
        $user_id = $data['id'];
        $user_emailVerification = $data['email_confirmed'];
        $user_role = $data['role'];
        $firstName = $data['firstname'];
        $lastName = $data['lastname'];
 
       if($user_emailVerification ==1){
        
                    $log_data='{'; // used to log catched data of user from msqldb
                    $log_data.= '"id": "' . preg_replace( "/\r|\n/", " ", $user_id ). '", ';
                    $log_data.= '"email": "' . preg_replace( "/\r|\n/", " ", $email). '", ';
                    $log_data.= '"password": "' . preg_replace( "/\r|\n/", " ", $password). '", ';
                    $log_data.= '"response": "OK"';
                    $log_data.='}' ;
                            
                            
                        
                echo "{$log_data}";							
        
        }// end of email verified
        else if($user_emailVerification==0){
                    $log_data='{';
                    $log_data.= '"response": "emailNotVerified", ';
                    $log_data.= '"link": "https://checkartisan.com/email/form.html", ';
                    $log_data.= '"msg": "DEAR USER  YOU HAVE NOT VERIFIED YOUR EMAIL,  CLICK ON THE LINK TO VERIFY YOUR EMAIL!!!"';
                    $log_data.='}' ;
                                            echo "{$log_data}";
                            
        }// end email not vrified     
    } // end passwordverify 
    else{
        $log_data='{';
            $log_data.= '"response": "NO"';
            $log_data.='}';
             echo "{$log_data}";
        }//ends password not exist

} //end result
else{
    $log_data='{';
        $log_data.= '"response": "NO"';
        $log_data.='}';
         echo "{$log_data}";
}

					    
				


?>