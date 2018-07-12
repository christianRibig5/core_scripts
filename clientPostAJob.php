<?php
   
    header("Access-Control-Allow-Origin:*");
    header("Content-Type:application/json; charset=UTF-8");
    require_once("conn.settings.php");
    require_once("core.php");
    
    $log_data="";
    $user_id= filter_input(INPUT_POST,"user_id");//comes from sharedpreferences android

    $job_id=password_hash(uniqid(),PASSWORD_DEFAULT);
    $jobTitle=filter_input(INPUT_POST,"jobtitle");
    $jobDescription= filter_input(INPUT_POST,"jobdescription");
    $jobTiming=filter_input(INPUT_POST,"jobTiming");
    $jobBudget=filter_input(INPUT_POST,"jobbudget");
    $jobAddress=filter_input(INPUT_POST,"jobaddress");
    $jobCity=filter_input(INPUT_POST,"jobcity");
    $jobState=filter_input(INPUT_POST,"jobstate");
    $jobCountry=filter_input(INPUT_POST,"jobcountry");
    $avartar=filter_input(INPUT_POST,"avartar");
   

    $query2 ="INSERT INTO client(id,job_id,user_id,jobtitle,jobdescription,jobtiming,
    jobbudgeting,jobaddress,jobcity,jobstate,jobcountry,avartar,created_at,updated_at) 
    VALUES ('0',$job_id,'$user_id','$jobTitle','$jobDescription','$jobTiming','$jobBudget',
    '$jobAddress','$jobCity','$jobState','$jobCountry','$avartar',$created_at','$updated_at')";
    if(mysqli_query($mysli,$query2)){
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
        echo "{$log_data}";
    }

    
          
?>