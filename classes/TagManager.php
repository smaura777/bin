<?php

class TagManager {

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
  

    $this->_connection->query("INSERT INTO tags (tagid,tagname,tagdisplay,user_agent,created_on,uid,tagdescription) values
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


function update($tagid,$display,$description){

   if (empty($display)){
    $this->lastErrorString = "display parameter is required ".__LINE__." "; 
    return false;
  }
  
  if (empty($tagid)){
    $this->lastErrorString = "Missing tag id ".__LINE__." "; 
    return false;   
  }
  
  if (!isset($_SESSION['user_object'])){
    $this->lastErrorString = "You must be logged in to update a tag ".__LINE__." "; 
    return false;
  }
  
  $this->_connection->query("UPDATE tags set tagdisplay = '".$display."',tagdescription='".$description."' where tagid = '".$tagid."' ");
  if ($this->_connection->error){
        $this->lastErrorString = "update Error on line ".__LINE__ . " "; 
        return false;
  }
  else {
        return true;
  }

}


functiuon remove($tagid){
   if (empty($tagid)){
    $this->lastErrorString = "Missing  id ".__LINE__." "; 
    return false;   
  }
  
  if (!isset($_SESSION['user_object'])){
    $this->lastErrorString = "You must be logged in to delete a document ".__LINE__." "; 
    return false;
  }
  
   $this->_connection->query("DELETE from tags where tagid = '".$tagid."'  LIMIT 1");
  
  if ($this->_connection->error){
        $this->lastErrorString = "delete Error on line ".__LINE__ . " "; 
        return false;
  }
  else {
        return true;
  } 

}

function getTagsForDocument($docid){
   if (empty($docid)){
    $this->lastErrorString = "Missing  id ".__LINE__." "; 
    return false;   
  }
  
  if (!isset($_SESSION['user_object'])){
    $this->lastErrorString = "You must be logged in to delete a document ".__LINE__." "; 
    return false;
  }
  
  $result = $this->_connection->query("SELECT tagid,tagname,tagdisplay,created_on,uid,lng,lat  from tags tg inner join document_tag_mapping dm on tg.tagid = dm.tagid and dm.docid = '".$docid."'   where docid = '".$docid."' ");
  if ($this->_connection->error){
        $this->lastErrorString = "delete Error on line ".__LINE__ . " "; 
        return false;
  }
  
  if ($result->num_rows <= 0){
    $this->lastErrorString = "0 results on line ".__LINE__ . " "; 
    return false;
  }
  
  $result_array = array();
  while (($row =  $result->fetch_assoc())){
    $result_array[] = $row;    
  }
  
  return $result_array;   
}


function getTagsForEntry($entryid){
   if (empty($entrycid)){
    $this->lastErrorString = "Missing  id ".__LINE__." "; 
    return false;   
  }
  
  if (!isset($_SESSION['user_object'])){
    $this->lastErrorString = "You must be logged in to delete a document ".__LINE__." "; 
    return false;
  }
  
  $result = $this->_connection->query("SELECT tagid,tagname,tagdisplay,created_on,uid,lng,lat  from tags tg inner join entry_tag_mapping em on tg.tagid = em.tagid and em.entryid = '".$entryid."'   where docid = '".$docid."' ");
  if ($this->_connection->error){
        $this->lastErrorString = "delete Error on line ".__LINE__ . " "; 
        return false;
  }
  
  if ($result->num_rows <= 0){
    $this->lastErrorString = "0 results on line ".__LINE__ . " "; 
    return false;
  }
  
  $result_array = array();
  while (($row =  $result->fetch_assoc())){
    $result_array[] = $row;    
  }
  
  return $result_array;   
}



}


?>