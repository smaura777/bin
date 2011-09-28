<?php

class PostManager {
   
   public function create($docid,$body){
   	  
      if (!isset($_SESSION['user_object'])){
      	throw new Exception("User is not logged in");
      }
      
      if (empty($_SESSION['user_object']->id)){
      	throw new Exception("Missign user ID");
      }
       
      $user_object = $_SESSION['user_object'];
      $unique = new UniqueIDFactory();
      $content_id = $unique->generateIDWithUnixTimestampComponent($user_object);
      if ($content_id == null){
      	throw new Exception("Could not generate unique ID");
      } 
          
      $rowmodel = new RowModel();
      $tablemodel = new TableModel();
      $tablemodel->tableName = "entry";
      $rowmodel->set("docid","'". $docid . "'");
      $rowmodel->set("entryid","'". $content_id . "'");
      $rowmodel->set("entryteaser","'" . $body . "'");
      $rowmodel->set("entrybody","'" . $body . "'");
      $rowmodel->set("user_agent","'" . $_SERVER['HTTP_USER_AGENT'] . "'");
      $rowmodel->set("created_on","" . time() . "");
      $rowmodel->set("uid","'" . $_SESSION['user_object']->id . "'");
      try {
      	$tablemodel->add($rowmodel);
      } catch(Exception $e){
      	die("<p> ". $e->getMessage() . "</p>");
      }
      
   }
  
    public function getNotes($docid){
      
    }
    
    
    
    
    
}


?>