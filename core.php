<?php

    //Ensure that the table name is "users" and 
    //Email field in the database table is named "email"


    function str_random($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
        return $randomString;
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
        if($user_role="Artisan"){
            $query="SELECT id FROM artisans WHERE user_id = '".$user_id."'";
        }else if($user_role="Client"){
            $query="SELECT id FROM clients WHERE user_id = '".$user_id."'";
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
             if ($json_data) {
                 $response = $this->doPostRequest($url, $json_data, array('Content-Type: application/json'));
                  $result = json_decode($response);
                 //return $response;
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