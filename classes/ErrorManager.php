<?php

class ErrorManager {
  private $_connection;
  public $lastErrorString = "";

  function __construct(){
     $this->_connection = DatabaseConnection::Connect();
     if ($this->_connection->error){
       die("Connect error" . $this->_connection->error);
     }
  } 
  
  function save($code,$msg=""){
    if (!empty($code)){
      $user_id = isset($_SESSION['user_object']) ? ''.$_SESSION['user_object']->id .'' :'anonymous';
      
      $this->_connection->query("INSERT INTO app_errors(created_on,uid,message,code,user_agent,session_id) values (".time().",'".$user_id."','".$msg."',".$code.",'".$_SERVER['HTTP_USER_AGENT']."','".session_id()."') ");      
      if ($this->_connection->error){
        $this->lastErrorString = "Insert Error on line ".__LINE__ . " "; 
        return false;
      }
      else {
        return true;
      }
    }
    else {
       $this->lastErrorString = "Code parameter is required ".__LINE__." "; 
      return false;
    }
  }
  
  
  
  
}

 

?>