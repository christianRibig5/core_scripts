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


?>