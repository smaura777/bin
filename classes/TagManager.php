<?php

class TagManager {


function create($display,$description='',$entryid= ''){
 if (!isset($_SESSION['user_object'])){
      	throw new Exception("User is not logged in");
  }
      
 if (empty($_SESSION['user_object']->id)){
      	throw new Exception("Missing user ID");
 }

 $rowmodel = new RowModel();
 $tablemodel = new TableModel();
 $tablemodel->tableName = "tags";
 
 //$custom_id = md5(''.mt_rand().''.time());
 $custom_id = md5($display);
 $rowmodel->set("tagid","'". $custom_id . "'");
 $rowmodel->set("tagname","'" . $display . "'");
 $rowmodel->set("tagdisplay","'" . $display . "'");
 //$rowmodel->set("user_agent","'" . $_SERVER['HTTP_USER_AGENT'] . "'");
 $rowmodel->set("created_on","" . time() . "");
 $rowmodel->set("uid","'" . $_SESSION['user_object']->id . "'");
 $rowmodel->set("tagdescription","'" . $description . "'");
 
 try {
 	$tablemodel->add($rowmodel);
 } catch(Exception $e){
 	// Ignore dup key errors
 	echo "ERR Code  " . $e->getCode();
 	if ($e->getCode() != 1062){
 	  die("<p> ". $e->getMessage() . "</p>");
 	}
 }
 
 // Adding tag entry mapping
 
 //unset($tablemodel);
 //$tablemodel = new TableModel();
 $tablemodel->tableName = "entry_tag_mapping";
 $tagRowModel = new RowModel();
 $tagRowModel->set('tagid',"'".$custom_id."'");
 $tagRowModel->set('entryid',"'".$entryid."'");
 $tagRowModel->set('created_on',"".time()."");
 
 try {
   $tablemodel->add($tagRowModel);  	
 } catch (Exception $e){
 	// Ignore dup key errors
 	echo "ERR Code 2 " . $e->getCode();
 	if ($e->getCode() != 1062){
 	  die("{$e->getMessage()}");
 	}
 }
 
 
 
 
 
 /**
    $this->_connection->query("INSERT INTO tags (tagid,tagname,tagdisplay,user_agent,created_on,uid,tagdescription) values
     ('".md5(''.mt_rand().''.time())."','".$display."','".$display."','".$_SERVER['HTTP_USER_AGENT']."',".time().", '".$_SESSION['user_object']->id."','".$description."')");
  
  **/

}


}


?>