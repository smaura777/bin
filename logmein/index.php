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
 $r_val = processLoginRequest($user_label,$password_label);
 
 if ($r_val ==''){
    header("location: http://" . $_SERVER['SERVER_NAME']);
 }
 else {
   echo "<i>".$r_val."</i>";
 }
 
 /*********************************************************/
 
    
ob_end_flush();
?>