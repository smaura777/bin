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
 header("location: http://localhost:8888/".APPNAME."/");
   
ob_end_flush();

?>