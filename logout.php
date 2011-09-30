<?php
ob_start();
require_once 'init.php';

session_start_wrap();

/**
 * Logout
 *
 *
 */  
 
 
 logout();
  header("location: http://" . $_SERVER['SERVER_NAME']);
   
ob_end_flush();

?>