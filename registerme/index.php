<?php
ob_start();
require_once '../init.php';
session_start_wrap();

/**
 * LogMeIn
 *
 *
 */  
 $user_label ='username';
 $password_label = 'password';
 $fname_label = 'fname';
 $lname_label = 'lname';
 
 $r_val = processRegistrationRequest($user_label,$password_label,$fname_label,$lname_label);
 
 if ($r_val ==''){
   header("location: http://localhost:8888/".APPNAME."/");
 }
 else {
   echo "<i>".$r_val."</i>";
 }
 
 /*********************************************************/
 
 
    
ob_end_flush();
?>