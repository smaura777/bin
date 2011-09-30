<?php

class EntryManager {

  private $_connection;
  public $lastErrorString = "";

 function __construct(){
     $this->_connection = DatabaseConnection::Connect();
     if ($this->_connection->error){
       die("Connect error" . $this->_connection->error);
     }
 } 


function create($docid,$entryid,$entryteaser,$entrybody){
  if (empty($docid)){
    $this->lastErrorString = "id is required ".__LINE__." "; 
    return false;
  }
  if (empty($entryid)){
    $this->lastErrorString = "id is required ".__LINE__." "; 
    return false;
  }
  
  if (empty($entryteaser)){
    $this->lastErrorString = "teaser is required ".__LINE__." "; 
    return false;
  }
  
  if (empty($entrybody)){
    $this->lastErrorString = "body is required ".__LINE__." "; 
    return false;
  }
  
  
  if (!isset($_SESSION['user_object'])){
    $this->lastErrorString = "You must be logged in to create a document ".__LINE__." "; 
    return false;
  }
  
  if (empty($_SESSION['user_object']->id)){
    $this->lastErrorString = "Missing user id ".__LINE__." "; 
    return false;
  }
  

  $this->_connection->query("INSERT INTO entry (entryid,docid,entryteaser,entrybody,user_agent,created_on,uid) values
     ('".md5(''.mt_rand().''.time())."','".$docid."','".$entryteaser."','".$entrybody."','".$_SERVER['HTTP_USER_AGENT']."',".time().", '".$_SESSION['user_object']->id."')");
  
  if ($this->_connection->error){
        $this->lastErrorString = "Insert Error on line ".__LINE__ . " "; 
        return false;
  }
  else {
        return true;
  } 
   
  return false;   
}


function update($entryid,$entryteaser,$entrybody){

 if (empty($entryid)){
    $this->lastErrorString = "id is required ".__LINE__." "; 
    return false;
  }
  
  if (empty($entryteaser)){
    $this->lastErrorString = "teaser is required ".__LINE__." "; 
    return false;
  }
  
  if (empty($entrybody)){
    $this->lastErrorString = "body is required ".__LINE__." "; 
    return false;
  }
  
  if (!isset($_SESSION['user_object'])){
    $this->lastErrorString = "You must be logged in to update a tag ".__LINE__." "; 
    return false;
  }
  
  $this->_connection->query("UPDATE entry set entryteaser = '".$entryteaser."',entrybody='".$entrybody."' where entryid = '".$entryid."' ");
  if ($this->_connection->error){
        $this->lastErrorString = "update Error on line ".__LINE__ . " "; 
        return false;
  }
  else {
        return true;
  }

}


function remove($entryid){
  if (empty($entryid)){
    $this->lastErrorString = "Missing  id ".__LINE__." "; 
    return false;   
  }
  
  if (!isset($_SESSION['user_object'])){
    $this->lastErrorString = "You must be logged in to delete a document ".__LINE__." "; 
    return false;
  }
  
   $this->_connection->query("DELETE from entry where entryid = '".$entryid."'  LIMIT 1");
  
  if ($this->_connection->error){
        $this->lastErrorString = "delete Error on line ".__LINE__ . " "; 
        return false;
  }
  else {
        return true;
  } 

}




}


?>