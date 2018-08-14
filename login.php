<?php
  header("Access-Control-Allow-Origin:*");
  header("Content-Type:application/json; charset=UTF-8");
	
  require("conn.settings.php");
  require_once("core.php");

//if($_SERVER["REQUEST_METHOD"]="POST"){
 
//if(isset($_POST['email']) && isset($_POST['password']) ){
$email=filter_input(INPUT_POST,"email");
//"afrohub9ja@gmail.com";
//"aaaaaaaa";
//"chime92.immanuel@gmail.com";
//"mezie";
$password=filter_input(INPUT_POST,"password");


$log_data="";

$query="SELECT * FROM users WHERE email = '".$email."'";
$result=mysqli_query($mysqli,$query);
if($data=mysqli_fetch_array($result)){
    if(password_verify($password,$data['password'])){
        /////// do here 1
        //$user_id = $data['id'];
        $userid = $data['user_id'];
        $user_emailVerification = $data['email_confirmed'];
        $user_role = $data['role'];
        $firstName = $data['firstname'];
        $phone = $data['phone'];
        $lastName = $data['lastname'];
        
 
       if($user_emailVerification ==1){
              if(ProfileUpdated($mysqli,$userid,$user_role)){
                    $log_data='{'; // used to log catched data of user from msqldb
                    $log_data.= '"user_id": "' . preg_replace( "/\r|\n/", " ", $userid ). '", ';
                    $log_data.= '"email": "' . preg_replace( "/\r|\n/", " ", $email). '", ';
                    $log_data.= '"role": "' . preg_replace( "/\r|\n/", " ", $user_role). '", ';
                    $log_data.= '"profileUpdate": "1", ';

                    if($user_role=="Artisan"){
                        $artisanData=getArtisanData($mysqli,$userid);
                        $user_tradetype=$artisanData['tradetype'];
                        $avatar=$artisanData['avatar'];
                        $artisan_user_id=$artisanData['artisan_id'];

                        $queryJobAlert="SELECT * FROM users INNER JOIN clients ON users.user_id=clients.user_id WHERE clients.jobtype='".$user_tradetype."' AND clients.quote_invite='0' AND clients.status='Awaiting Quotes' ORDER BY clients.created_at DESC";
                        $resultJobAlert=mysqli_query($mysqli,$queryJobAlert);
                        $countJobAlert=mysqli_num_rows($resultJobAlert);

                        $queryJobList="SELECT * FROM clients INNER JOIN jobs_requests ON clients.job_id=jobs_requests.job_id WHERE jobs_requests.artisan_user_id='".$userid."' ORDER BY jobs_requests.created_at DESC";
                        $resultJobList=mysqli_query($mysqli,$queryJobList);
                        $countJobList=mysqli_num_rows($resultJobList);

                        $queryQuoteInvite="SELECT * FROM users INNER JOIN clients ON users.user_id=clients.user_id WHERE clients.jobtype='".$user_tradetype."' AND clients.quoting_artisan_id='".$artisan_user_id."' AND clients.quote_invite='1'";
                        $resultQuoteInvite=mysqli_query($mysqli,$queryQuoteInvite);
                        $countQuoteInvite=mysqli_num_rows($resultQuoteInvite);

                        $queryReviews="SELECT client_reviews.job_id,client_reviews.comments,client_reviews.created_at,users.firstname,clients.jobtitle FROM client_reviews INNER JOIN users ON client_reviews.client_id=users.user_id INNER JOIN clients ON client_reviews.job_id=clients.job_id WHERE client_reviews.artisan_user_id='".$artisan_user_id."'";
                        $resultReviews=mysqli_query($mysqli,$queryReviews);
                        $countReviews=mysqli_num_rows($resultReviews);

                        $log_data.= '"avatar": "' . preg_replace( "/\r|\n/", " ", $avatar). '", ';
                        $log_data.= '"tradeType": "' . preg_replace( "/\r|\n/", " ", $user_tradetype). '", ';
                        $log_data.= '"newJobCount": "' . preg_replace( "/\r|\n/", " ", $countJobAlert). '", ';
                        $log_data.= '"jobListCount": "' . preg_replace( "/\r|\n/", " ", $countJobList). '", ';
                        $log_data.= '"quoteInviteCount": "' . preg_replace( "/\r|\n/", " ", $countQuoteInvite). '", ';
                        $log_data.= '"ReviewsCount": "' . preg_replace( "/\r|\n/", " ", $countReviews). '", ';
                        $log_data.= '"JobPostingCheckId": "' . preg_replace( "/\r|\n/", " ", $artisan_user_id). '", ';
                    }
                    $log_data.= '"phone": "' . preg_replace( "/\r|\n/", " ", $phone).'", ';
                    $log_data.= '"firstname": "' . preg_replace( "/\r|\n/", " ", $firstName). '", ';
                    $log_data.= '"lastname": "' . preg_replace( "/\r|\n/", " ", $lastName). '", ';
                    $log_data.= '"response": "OK"';
                    $log_data.='}' ;
              }else{
                    $log_data='{'; // used to log catched data of user from msqldb
                    $log_data.= '"user_id": "' . preg_replace( "/\r|\n/", " ", $userid ). '", ';
                    $log_data.= '"email": "' . preg_replace( "/\r|\n/", " ", $email). '", ';
                    $log_data.= '"role": "' . preg_replace( "/\r|\n/", " ", $user_role). '", ';
                    $log_data.= '"profileUpdate": "0", ';
                    $log_data.= '"phone": "' . preg_replace( "/\r|\n/", " ", $phone).'", ';
                    $log_data.= '"firstname": "' . preg_replace( "/\r|\n/", " ", $firstName). '", ';
                    $log_data.= '"lastname": "' . preg_replace( "/\r|\n/", " ", $lastName). '", ';
                    $log_data.= '"response": "OK"';
                    $log_data.='}' ;
              }            
                        
             echo "{$log_data}";							
        
        }// end of email verified
        else if($user_emailVerification==0){
                    $log_data='{';
                    $log_data.= '"response": "emailNotVerified", ';
                    $log_data.= '"msg": "Dear user  you have not verified your email,  click on the link to verify your email"';
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