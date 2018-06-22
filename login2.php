<?php
    require("conn.settings.php");
    $email=filter_input(INPUT_POST,"email");
    $password=filter_input(INPUT_POST,"password");
    $query="SELECT * FROM staff 
            WHERE email LIKE '$email' AND password LIKE '$password'";
    $result= mysqli_query($con,$query);                
    if(mysqli_num_rows($result)>0){
        echo "login success";
    }else {
        echo "login failure";
    }
?>

<?php
// Reference of PDO login class if required.
    /* class Login{
        public function  login($email,$password){
            if(!empty($email) && !empty($password)){
                $db = new Database;
                $query =$db->query("SELECT * FROM staff 
                WHERE email LIKE '$email' AND password LIKE '$password'");
                 $count = $query->rowCount();
                 if($count>0){
                     echo 1;
                 }
                 else{
                    echo 0;
                 }

            }
        
        }
        /*public function encryptPassword($password){
            if(!empty($password)){
                return md5($password);
            }
        }
        public function clean($data){
            if(!empty($data)){
                $data=trim(strip_tags(stripslashes(mysql_real_escape_string($data))));
                return $data; 
            }
        }
    }*/
?>
