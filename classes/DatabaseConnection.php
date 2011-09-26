<?php


class DatabaseConnection {
  //DB connection
  private  $_connection = null;
  public static $instance_count = 0;
  
  private function __construct(){
   $this->_connection = new mysqli(HOST,USER,PASS,DB);
   if ($this->_connection->connect_error){
     die('connect error (' . $this->_connection->connect_errno . ') ' . $this->_connection->connect_error);
   }
  }
  
  public static function Connect(){
    static $instance = null;
    $className = __CLASS__;
    if ($instance == null){
     // Instantiate object
     $instance = new $className;
     self::$instance_count++; 
    }
    return $instance->getConnection();
  }
  
  private function getConnection(){
     return $this->_connection;
  }

}








?>