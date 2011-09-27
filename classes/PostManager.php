<?php

class PostManager {
    private $_connection;
    public $lastErrorString = "No errors";
   
  
   
   public function create($title,$teaser,$body){
    if (issetAndNotEmpty($_SESSION['user_object'])){
      $user_object =  $_SESSION['user_object'];
      if (!isset($user_object->id)){
        $this->lastErrorString = "User ID not found"; 
        return false;
      }
      
      $unique = new UniqueIDFactory();
      $content_id = $unique->generateIDWithUnixTimestampComponent($user_object);
      if ($content_id == null){
           $this->lastErrorString = $unique->lastErrorString;  
        return false;
      } 
          
      //echo $content_id;
      
      $this->_connection->query("INSERT INTO post (tid,owner,content_type,status) values('".$content_id."','".$user_object->id."','post','PUBLIC')");
      if ($this->_connection->error){
        return false;
      }
      
      $this->_connection->query("INSERT INTO post_data (tid,created_on,post_title,post_teaser,post_data) values('".$content_id."','".time()."','".$title."','".$teaser."','".$body."')");
      if ($this->_connection->error){
        return false;
      }
      
      return true;  
    }
    else {
      $this->lastErrorString = "User is not logged in";
    }
   
   }
  
    public function display(){
      $result = $this->_connection->query("select post_data.tid,post_data.vid,post_data.created_on,post_data.post_title,post_data.post_teaser from post_data,post  where post.tid = post_data.tid and post.status = 'PUBLIC'");
      if ($this->_connection->error){
        return false;
      }
      
      $result_array = array(); 
      while ($row = $result->fetch_assoc()){
         $result_array[] = $row;
      }
      
      return $result_array;    
    }
    
    
    public function  displayPostDetails($post_id){
      $result = $this->_connection->query("select post_data.tid,post_data.vid,post_data.created_on,post_data.post_title,post_data.post_data from post_data where post_data.tid = '".$post_id."' and post.status = 'PUBLIC'");
      if ($this->_connection->error){
        return false;
      }
      
      return $result->fetch_assoc(); 
    }
    
    
}


?>