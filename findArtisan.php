

<?php
   
   header("Access-Control-Allow-Origin:*");
   header("Content-Type:application/json; charset=UTF-8");
   require_once("conn.settings.php");
   require_once("core.php");
   
   $log_data="";
   
   
  // $theTrade="BUILDER";//strtoupper(filter_input(INPUT_POST,"tradetype"));
   $theCity="Umuahia";//ucfirst((filter_input(INPUT_POST,"city")));
    if(isset($theTrade)){
        $query="SELECT tradetype FROM c_a__trade_types WHERE trade='$theTrade'";
        $result=mysqli_query($mysqli,$query);
        while($data=mysqli_fetch_array($result)){
            $tradeType=$data['tradetype'];
            $log_data='{'; 
                $log_data.= '"trade": "' . preg_replace( "/\r|\n/", " ", $tradeType ). '", ';
                $log_data.='}' ;
                echo "{$log_data}";   
       }
    }else if(isset($theCity)){
        $query="SELECT tradetype FROM artisans WHERE city='$theCity'";
        $result=mysqli_query($mysqli,$query);
        while($data=mysqli_fetch_array($result)){
            $city=$data['city'];
            $log_data='{'; 
                $log_data.= '"city": "' . preg_replace( "/\r|\n/", " ", $city ). '", ';
                $log_data.='}' ;
                echo "{$log_data}";
       }
    }else{
     echo mysqli_error($mysqli);
   }
   
           
       
   
   
           
           
       
   
   
  
   

?>
