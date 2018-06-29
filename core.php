<?php

    //Ensure that the table name is "users" and 
    //Email field in the database table is named "email"
    function EmailExist($conn,$email){
        $query="SELECT email FROM users WHERE email = '".$email."'";
        $result=mysqli_query($conn,$query);
        $count=mysqli_num_rows($result);
        
        if($count>=1){
            //The Email exist in the table
            return true;
        }else{
            //The Email does not exist in the table
            return false;
        }

    }

    function generatePIN($digits){
        $i = 0; //counter
        $pin = ""; //our default pin is blank.
        while($i < $digits){
            //generate a random number between 0 and 9.
            $pin .= mt_rand(0, 9);
            $i++;
        }
        return $pin;
    }
 


?>