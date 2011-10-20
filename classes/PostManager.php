<?php

class PostManager {
   
   private $recent_entryid; 	
   private $postBody;
   
   public function  setPostBody($body){
   	 $this->postBody = $body;
   }
   
   public function postBody(){
   	return $this->postBody;
   }
   
   
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
   	
   	if (!isset($_SESSION['user_object'])){
   		throw new Exception("User is not logged in");
   	}
   	
   	if (empty($_SESSION['user_object']->id)){
   		throw new Exception("Missign user ID");
   	}
   	 
   	$user_object = $_SESSION['user_object'];
   	
   	$rowmodel = new RowModel();
   	$rowmodel->set('docid');
   	$rowmodel->set('entryid');
   	$rowmodel->set('entrybody');
   	$rowmodel->set('created_on');
   	$rowmodel->setConstraint("entryid","'" . $entryid  . "'");
   	$rowmodel->setConstraint("uid","'" . $user_object->id . "'");
   	$rowmodel->setConstraint("visibility","'visible'");
   	
   	$tablemodel = new TableModel();
   	$tablemodel->tableName = "entry";
   	
   	$custom_query = "SELECT dc.docid,dc.docdisplay,dc.docname,ent.entryid,ent.
   	   	entrybody,ent.uid,ent.created_on,group_concat(tg.tagname) as tag_cloud from entry ent 
   	   	inner join documents dc on dc.docid = ent.docid   inner join entry_tag_mapping tm on tm.entryid = ent.entryid inner join tags tg on tg.tagid = tm.tagid
   	    and ent.visibility ='visible' and ent.uid ='".$user_object->id."'  and ent.entryid ='".$entryid."'  group by ent.entryid  limit 1 ";
   	
   	
   	try {
   		//$result = $tablemodel->fetch($rowmodel);
   		$result = $tablemodel->fetchCustom($custom_query);
   	} catch(Exception $e){
   		throw $e;
   	}
   	
   	return $result;
   }
  
   public function getAllNotes($start=0,$limit = 50){
   	
   	if (!isset($_SESSION['user_object'])){
   		throw new Exception("User is not logged in");
   	}
   	
   	if (empty($_SESSION['user_object']->id)){
   		throw new Exception("Missign user ID");
   	}
   	
   	$user_object = $_SESSION['user_object'];
   	
   	$rowmodel = new RowModel();
   	$rowmodel->set('docid');
   	$rowmodel->set('entryid');
   	$rowmodel->set('entrybody');
   	$rowmodel->set('created_on');
   	$rowmodel->setConstraint("visibility","'visible'");
   
   	$tablemodel = new TableModel();
   	
   	$custom_query = "SELECT dc.docid,dc.docdisplay,dc.docname,ent.entryid,ent.
   	entrybody,ent.uid,ent.created_on,group_concat(tg.tagname) as tag_cloud from entry ent 
   	inner join documents dc on dc.docid = ent.docid  inner join entry_tag_mapping tm on tm.entryid = ent.entryid inner join tags tg on tg.tagid = tm.tagid 
    and ent.visibility ='visible' and ent.uid ='".$user_object->id."'  group by ent.entryid ";
   	
   	$tablemodel->tableName = "entry";
   
   	try {
   		//$result = $tablemodel->fetch($rowmodel,$limit);
   		$result = $tablemodel->fetchCustom($custom_query,0," ORDER BY ent.created_on desc limit {$start},{$limit} ");  // ORDER BY ent.created_on desc 
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
    
    
    public function deletePost($entryid){
      $tablemodel = new TableModel();
      $tablemodel->tableName = "entry";
      $rowmodel = new RowModel();
      $rowmodel->set('visibility',"'deletedbyuser'");
       $rowmodel->setConstraint('entryid',"'".$entryid."'");
      try {
      	//echo "About to";
      	$tablemodel->update($rowmodel);
      } catch(Exception $e){
      	throw $e;
      }	
    }
    
    public function updatePost($entryid,$body='',$tags=NULL){
      $rowmodel = new RowModel();
      $rowmodel->set('entrybody',"'".$body."'");
      $rowmodel->setConstraint('entryid',"'".$entryid."'");
      $tablemodel = new TableModel();
      $tablemodel->tableName = "entry";
      
      try {
        $tablemodel->update($rowmodel);
      } catch(Exception $e){
      	throw $e;
      }

      
    }
    
    
    
}


?>
