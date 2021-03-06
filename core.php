<?php

    //Ensure that the table name is "users" and 
    //Email field in the database table is named "email"
    //ADDED ANOTHER COMMENT


    function str_random($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    // function to get all clientjobcount
    function getClientPostedJobCount($conn,$id){
        $query="SELECT * FROM clients WHERE user_id = '".$id."' ORDER BY id DESC";
        $result=mysqli_query($conn,$query);
        $count=mysqli_num_rows($result);
        return $count;
        
    }

    function sanitizeVar($input){
       return htmlspecialchars(addslashes(trim($input)));
    }



    function CountJobAlert($conn,$tradeType,$artisan_id){
        $query="SELECT * FROM users INNER JOIN clients ON users.user_id=clients.user_id
    WHERE clients.jobtype='".$tradeType."' AND clients.quote_invite='0' AND 
    clients.status='Awaiting Quotes' AND clients.user_id!='".$artisan_id."' ORDER BY clients.created_at DESC";
          $result=mysqli_query($conn,$query);
          $count=mysqli_num_rows($result);
          
          if($count>=1){
            $i=0;
            while($data=mysqli_fetch_array($result)){
                

                $query2="SELECT artisan_user_id FROM jobs_requests WHERE job_id='".$data['job_id']."'";
                $result2=mysqli_query($conn,$query2);
                $count2=mysqli_num_rows($result2);
                $artisanHaveShowInterest=0;
                if($count2>=1){
                    while($data2=mysqli_fetch_array($result2)){
                        if($data2['artisan_user_id']==$artisan_id){
                            $artisanHaveShowInterest=1;
                            break;
                        }
                    }
                }
                
                //check if upto three artisans have shown intrest and skip the job if true
                if($count2==3 || $artisanHaveShowInterest==1){
                    continue;
                }

                $i++;
            }

            return $i;
             
        }else{
            return 0;
        }
    }


    function UpdateJobQuoteStatus($mysqli,$job_id){
        $query="UPDATE clients SET quote_status='Accepted' WHERE job_id='".$job_id."'";
        mysqli_query($mysqli,$query);
    }


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


    function validateBase64ImageString($string){
        $data = explode(',', $string);
        if(count($data) >= 2)
        {
        $format = explode('/', $data[0]);
        if($format[0] == 'data:image')
        {
        return true;
        }
        }
        return false;
    }

    function ProfileUpdated($conn,$user_id,$user_role){
        if($user_role=="Artisan"){
            $query="SELECT id FROM artisans WHERE user_id = '".$user_id."'";
        }else if($user_role=="Client"){
            $query="SELECT id FROM clients WHERE user_id = '".$user_id."'";
        }else{
            $query="SELECT id FROM artisans WHERE user_id = '".$user_id."'"; 
        }
        
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

    function getArtisanData($conn,$userid){
        $queryArtisanDetail="SELECT * FROM artisans WHERE user_id='".$userid."'";
        $resultArtisanDetail=mysqli_query($conn,$queryArtisanDetail);
        $artisanData=mysqli_fetch_array($resultArtisanDetail);

        return $artisanData;
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


    class OTP{

        // var $phonenumebr;
         var $code="";
         var $json_url = "http://api.ebulksms.com:8080/sendsms.json";
         var $username = 'abara5000@gmail.com';
         var $apikey = 'fcbae20a8d03d96178820be4f6c044988d79a793';  
         var $sendername ='CA';
         var $recipients; //= '07031293784,';
         var $flash = 0;
         var $message = 'CheckArtisan code: ';
         var $result='NO';
 
         public function __construct($phone){
             $this->recipients=$phone.',';
             $this->code=$this->generatePIN(4);
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
    
         private function useJSON($url, $username, $apikey, $flash, $sendername, $messagetext, $recipients) {
             $gsm = array();
             $country_code = '234';
             $arr_recipient = explode(',', $recipients);
             foreach ($arr_recipient as $recipient) {
                 $mobilenumber = trim($recipient);
                 if (substr($mobilenumber, 0, 1) == '0'){
                     $mobilenumber = $country_code . substr($mobilenumber, 1);
                 }
                 elseif (substr($mobilenumber, 0, 1) == '+'){
                     $mobilenumber = substr($mobilenumber, 1);
                 }
                 $generated_id = uniqid('int_', false);
                 $generated_id = substr($generated_id, 0, 30);
                 $gsm['gsm'][] = array('msidn' => $mobilenumber, 'msgid' => $generated_id);
             }
             $message = array(
                 'sender' => $sendername,
                 'messagetext' => $messagetext,
                 'flash' => "{$flash}",
             );
          
             $request = array('SMS' => array(
                     'auth' => array(
                         'username' => $username,
                         'apikey' => $apikey
                     ),
                     'message' => $message,
                     'recipients' => $gsm
             ));
             $json_data = json_encode($request);
             $response = $this->doPostRequest($url, $json_data, array('Content-Type: application/json'));
             $result = json_decode($response);
             if ($result) {  
                 //return $response;
                 //echo $result->response;
                return $result->response->status;
             } else {
                 return false;
             }
         }
 
 
         //Function to connect to SMS sending server using HTTP POST
         private function doPostRequest($url, $arr_params, $headers = array('Content-Type: application/x-www-form-urlencoded')) {
             $response = array();
             $final_url_data = $arr_params;
             if (is_array($arr_params)) {
                 $final_url_data = http_build_query($arr_params, '', '&');
             }
             $ch = curl_init();
             curl_setopt($ch, CURLOPT_URL, $url);
             curl_setopt($ch, CURLOPT_POSTFIELDS, $final_url_data);
             curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
             curl_setopt($ch, CURLOPT_POST, 1);
             curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
             curl_setopt($ch, CURLOPT_VERBOSE, 1);
             curl_setopt($ch, CURLOPT_TIMEOUT, 30);
             $response['body'] = curl_exec($ch);
             $response['code'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
             curl_close($ch);
             return $response['body'];
         }
 
 
         public function sendOTP(){
 
             $this->message.=$this->code;
             $this->result=$this->useJSON($this->json_url, $this->username, $this->apikey, 
             $this->flash, $this->sendername, $this->message, $this->recipients);
             if($this->result=="SUCCESS"){
                 return true;
             }else{
                 //Message sending was not successful
                 //May be CREDIT UNIT FINISHED
                 //we need to send an email to admin here to notify him that sms credit is exhausted 
                 return false;
             }
         }
 
         public function getCode(){
             return $this->code;
         }

         public function getResult(){
            return $this->result;
         }
 
 
 
 
 
     }
 
 
 


?>