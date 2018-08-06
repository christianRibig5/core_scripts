

<?php
   
   header("Access-Control-Allow-Origin:*");
   header("Content-Type:application/json; charset=UTF-8");
   require_once("conn.settings.php");
   require_once("core.php");
   
  // $log_data="";
   
   $verification_token=strip_tags(filter_input(INPUT_GET,"vtoken"));
   $firstname='';
   if($verification_token==""){
    echo "Not found";
   }else{
        $query="SELECT * FROM users WHERE verification_token='$verification_token'";
        $result=mysqli_query($mysqli,$query);
        if($data=mysqli_fetch_array($result)){
            $firstName = $data['firstname'];
            $firstname=$firstName;
        }
        $query2 = "UPDATE users SET verification_token='',email_confirmed =1 
        WHERE verification_token='$verification_token'";
        if($result=mysqli_query($mysqli,$query2)){
            echo $firstname." your email has been confirmed";
        }/*else{
           echo ''.mysqli_error($mysqli);
        } */ 
     
   }
   
   
?>
