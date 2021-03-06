<?php
   
    header("Access-Control-Allow-Origin:*");
    header("Content-Type:application/json; charset=UTF-8");
    require_once("conn.settings.php");
    require_once("core.php");
    
    $log_data="";
    $user_id= filter_input(INPUT_POST,"user_id");//comes from sharedpreferences android

    $job_id=str_random(10);
    //substr(password_hash(uniqid(),PASSWORD_DEFAULT),13);
    $jobTitle=filter_input(INPUT_POST,"jobtitle");
    $jobtype=filter_input(INPUT_POST,"jobtype");
    $jobDescription= filter_input(INPUT_POST,"jobdescription");
    $jobTiming=filter_input(INPUT_POST,"jobTiming");
    $jobBudget=filter_input(INPUT_POST,"jobbudget");
    $jobAddress=filter_input(INPUT_POST,"jobaddress");
    $jobCity=filter_input(INPUT_POST,"jobcity");
    $jobState=filter_input(INPUT_POST,"jobstate");
    $jobCountry=filter_input(INPUT_POST,"jobcountry");
    $status='Awaiting Quotes';
    $regTime=date('Y-m-d H:i:s',time());
    $created_at= $regTime;
    $updated_at = $regTime;
    $quote_invite=0;
    //$quoting_artisan_id='';
    $avartar='';//filter_input(INPUT_POST,"avartar");
    if(isset($_POST['requestedArtisanId'])){
        $requested_Artisan_Id=filter_input(INPUT_POST,"requestedArtisanId");
        $quote_invite=1;

        $query2 ="INSERT INTO clients (id,job_id,user_id,status,jobtitle,jobtype,jobdescription,jobtiming,
    jobbudget,jobaddress,jobcity,jobstate,jobcountry,quote_invite,quoting_artisan_id,created_at,updated_at) 
    VALUES ('0','$job_id','$user_id','$status','$jobTitle','$jobtype','$jobDescription','$jobTiming','$jobBudget',
    '$jobAddress','$jobCity','$jobState','$jobCountry','$quote_invite','$requested_Artisan_Id','$created_at','$updated_at')";
    }else{
        $query2 ="INSERT INTO clients (id,job_id,user_id,status,jobtitle,jobtype,jobdescription,jobtiming,
    jobbudget,jobaddress,jobcity,jobstate,jobcountry,quote_invite,created_at,updated_at) 
    VALUES ('0','$job_id','$user_id','$status','$jobTitle','$jobtype','$jobDescription','$jobTiming','$jobBudget',
    '$jobAddress','$jobCity','$jobState','$jobCountry','$quote_invite','$created_at','$updated_at')";
    }

    
    if(mysqli_query($mysqli,$query2)){
        $log_data='{';
            $log_data.= '"response": "jobPostSuccess",';
            $log_data.= '"msg": "Client job posted successfully"';
            $log_data.='}' ;
        echo "{$log_data}";
    }else{
        $log_data='{'; 
            $log_data.= '"response": "jobPostFailed",';
            $log_data.= '"msg": "Client job post unsuccesful"';
            $log_data.='}' ;
        echo "{$log_data}".mysqli_error($mysqli);
    }

    
          
?>