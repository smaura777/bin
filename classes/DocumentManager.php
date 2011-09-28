<?php

class DocumentManager {

 private $recentID;	

 
 function getRecentID(){
   return $this->recentID;	
 }
 
function create($display,$description=''){
  if (empty($display)){
   throw new Exception("Document name is empty");
  }
  
  if (!isset($_SESSION['user_object'])){
    throw new Exception("User is not logged in");
  }
  
  if (empty($_SESSION['user_object']->id)){
    throw new Exception("Missign user ID");
  }
  
  $rowmodel = new RowModel();
  $tablemodel = new TableModel();
  $tablemodel->tableName = "documents";
  $this->recentID = md5(''.mt_rand().''.time());  
  $rowmodel->set("docid","'". $this->recentID . "'");
  $rowmodel->set("docname","'" . $display . "'");
  $rowmodel->set("docdisplay","'" . $display . "'");
  $rowmodel->set("user_agent","'" . $_SERVER['HTTP_USER_AGENT'] . "'");
  $rowmodel->set("created_on","" . time() . "");
  $rowmodel->set("uid","'" . $_SESSION['user_object']->id . "'");
  $rowmodel->set("docdescription","'" . $description . "'");
  
  try {
  	$tablemodel->add($rowmodel);
  } catch(Exception $e){
  	die("<p> ". $e->getMessage() . "</p>");
  }
  
  /**
  
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
  **/   
}



function remove($docid){
  
	if (empty($docid)){
    throw new Exception("Missign doc ID");
  }
  
  if (!isset($_SESSION['user_object'])){
  	throw new Exception("You must be logged in");
  }
  
//  $this->_connection->query("DELETE from documents where docid = '".$docid."'  LIMIT 1");
   
  
}





}

?>