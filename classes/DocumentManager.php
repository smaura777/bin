<?php

class DocumentManager {
  private $_connection;
  public $lastErrorString = "";

 function __construct(){
     $this->_connection = DatabaseConnection::Connect();
     if ($this->_connection->error){
       die("Connect error" . $this->_connection->error);
     }
 } 


function create($display,$description=''){
  if (empty($display)){
    $this->lastErrorString = "display parameter is required ".__LINE__." "; 
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
  

    $this->_connection->query("INSERT INTO documents (docid,docname,docdisplay,user_agent,created_on,uid,docdescription) values
     ('".md5(''.mt_rand().''.time())."','".$display."','".$display."','".$_SERVER['HTTP_USER_AGENT']."',".time().", '".$_SESSION['user_object']->id."','".$description."')");

  if ($this->_connection->error){
        $this->lastErrorString = "Insert Error on line ".__LINE__ . " "; 
        return false;
  }
  else {
        return true;
  } 
   
  return false;   
}



functiuon remove($docid){
  if (empty($docid)){
    $this->lastErrorString = "Missing  id ".__LINE__." "; 
    return false;   
  }
  
  if (!isset($_SESSION['user_object'])){
    $this->lastErrorString = "You must be logged in to delete a document ".__LINE__." "; 
    return false;
  }
  
  $this->_connection->query("DELETE from documents where docid = '".$docid."'  LIMIT 1");
  
  if ($this->_connection->error){
        $this->lastErrorString = "delete Error on line ".__LINE__ . " "; 
        return false;
  }
  else {
        return true;
  } 
  
  
}

function update($docid,$display,$description){
  
   if (empty($display)){
    $this->lastErrorString = "display parameter is required ".__LINE__." "; 
    return false;
  }
  
  if (empty($docid)){
    $this->lastErrorString = "Missing document id ".__LINE__." "; 
    return false;   
  }
  
  if (!isset($_SESSION['user_object'])){
    $this->lastErrorString = "You must be logged in to update a document ".__LINE__." "; 
    return false;
  }
  
  $this->_connection->query("UPDATE documents set docdisplay = '".$display."',docdescription='".$description."' where docid = '".$docid."' ");
  if ($this->_connection->error){
        $this->lastErrorString = "update Error on line ".__LINE__ . " "; 
        return false;
  }
  else {
        return true;
  }
  
   
}

function entry_count($docid){
  if (empty($docid)){
    $this->lastErrorString = "Missing document id ".__LINE__." "; 
    return false;   
  }
   
  if (!isset($_SESSION['user_object'])){
    $this->lastErrorString = "You must be logged in to delete a document ".__LINE__." "; 
    return false;
  }
  
  $result = $this->_connection->query("SELECT count(*) as total from entry where docid = '".$docid."' ");
  $row = $result->fetch_object();
  return $row->total; 
}





}

?>