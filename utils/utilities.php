<?php

function Logger($msg){
 // echo "Logger called <br />"; 
  if (DEBUG_MODE){
    echo $msg;
  }
}

function issetAndNotEmpty($param){
  if (isset($param) && (!empty($param)) ){
    return true;
  }
  
  return false;
}



function PageStats(){
    //Logger("<br /> Request params count " . count($_REQUEST) . "<br />");
  foreach($_REQUEST as $key => $val){
   // Logger("key : " . $key . " value : " . $val . "<br />");
   }
}


/**
 *
 */
 
function logout(){
   $_SESSION = array();
   session_destroy();
} 
 
function processRegistrationRequest($user,$password,$first,$last){
  $err = '';
  $errorManager = new ErrorManager();
  
  $fname = null;
  $lname = null;
  //Missing
  if (!isset($_POST[$user])){
     $err = 'Missing user name';
     // Save error in db
     if (!$errorManager->save(100,$err)){
       echo $errorManager->lastErrorString;
     }
     return $err;
   }
   
  if (!isset($_POST[$password])){
     $err = 'Missing password';
     // Save error in db
     if (!$errorManager->save(100,$err)){
       echo $errorManager->lastErrorString;
     }
     return $err;
  }
  
   // Required
   if (trim($_POST[$user]) == ''){
      $err = 'Missing user name';
     // Save error in db
     if (!$errorManager->save(100,$err)){
       echo $errorManager->lastErrorString;
     }
     return $err;  
   }
   
   if (trim($_POST[$password]) == ''){
      $err = 'Missing password';
      // Save error in db
      if (!$errorManager->save(100,$err)){
        echo $errorManager->lastErrorString;
      }
     return $err;  
   }
   
  // Optional
  
  if (isset($_POST[$first]) && (trim($_POST[$first]) != '') ){
    $fname = $_POST[$first];
  }
 
   if (isset($_POST[$last]) && (trim($_POST[$last]) != '') ){
    $lname =$_POST[$last];
  }
 
  
  // Create if not exist
  $manager = new AccountManager();
  
  $response = $manager->create($_POST[$user],$_POST[$password],$fname,$lname);  
  
  if ($response != TRUE){
    $err = $manager->lastErrorString;
    if (!$errorManager->save(100,$err)){
      echo $errorManager->lastErrorString;
    }
  }
  
  return $err;  
}

function processLoginRequest($user,$password){
   $err ='';
   $errorManager = new ErrorManager();
   // Missing 
   if (!isset($_POST[$user])){
     $err = 'Missing user name';
     // Save error in db
    if (!$errorManager->save(100,$err)){
      echo $errorManager->lastErrorString;
    }
     return $err;
   }
   
   if (!isset($_POST[$password])){
     $err = 'Missing password';
     // Save error in db
     if (!$errorManager->save(100,$err)){
       echo $errorManager->lastErrorString;
     }
     return $err;
   }
   
   
   // Required
   if (trim($_POST[$user]) == ''){
      $err = 'Missing user name';
     // Save error in db
     if (!$errorManager->save(100,$err)){
      echo $errorManager->lastErrorString;
    }
     return $err;  
   }
   
   if (trim($_POST[$password]) == ''){
      $err = 'Missing password';
      // Save error in db
      if (!$errorManager->save(100,$err)){
        echo $errorManager->lastErrorString;
      }
     return $err;  
   }
   
   
   // Login 
   $manager = new AccountManager();
   $response = $manager->authenticate($_POST[$user],$_POST[$password]);
   if ($response ==  null || $response ==  false){
     $err = $manager->lastErrorString;
     // Save error in db
     if (!$errorManager->save(100,$err)){
       echo $errorManager->lastErrorString;
     }
     return $err;  
   }
   
   $user_object = $response;  
   session_regenerate_id();
   $_SESSION['initiated'] = TRUE;
   $_SESSION['user_object'] = $user_object;
   $_SESSION['isLoggedIn'] = true;
   
   return $err;
 }


function session_start_wrap(){
  session_start();
  if (!isset($_SESSION['initiated'])){
     session_regenerate_id();
     $_SESSION['initiated'] = TRUE;
  }
  
  if (isset($_SESSION['HTTP_USER_AGENT'])){
    if ($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT'])){
       header("Location: logout.php"); 
       exit;
    }
  }
  else {
    $_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']); 
  }
  
  
  // testing 
  if (isset($_SESSION['user_object'])){
    //echo "<div><p>User is logged in.</p></div>";
  }
  else {
     echo "<div><p>User is anonymous</p></div>";
  }
  
}


?>