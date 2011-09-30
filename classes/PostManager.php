<?php

class PostManager {
   
   private $recent_entryid; 	
	
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
      
      $this->recent_entryid = $content_id;
          
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
  
    
  public function recentEntryID(){
  	if ($this->recent_entryid){
  		return $this->recent_entryid;
  	}
  	else {
  		throw new Exception("No recent entry ids");
  	}
  } 
  
  
   public function getNote($entryid){
   	$rowmodel = new RowModel();
   	$rowmodel->set('docid');
   	$rowmodel->set('entryid');
   	$rowmodel->set('entrybody');
   	$rowmodel->set('created_on');
   	$rowmodel->setConstraint("entryid","'" . $entryid  . "'");
   	
   	$tablemodel = new TableModel();
   	$tablemodel->tableName = "entry";
   	
   	try {
   		$result = $tablemodel->fetch($rowmodel);
   	} catch(Exception $e){
   		throw $e;
   	}
   	
   	return $result;
   }
  
   
   
   
    public function getRecentNotes($limit=50){
      $rowmodel = new RowModel();
      $rowmodel->set('docid');
      $rowmodel->set('entryid');
      $rowmodel->set('entrybody');
      $rowmodel->set('created_on');
      
      $tablemodel = new TableModel();
      $tablemodel->tableName = "entry";
      
      try {
      	$result = $tablemodel->fetch($rowmodel,$limit," ORDER by created_on desc ");
      } catch(Exception $e){
      	throw $e;
      }
      
      return $result;
    }
    
    
    
    
    
}


?>