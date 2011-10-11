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
 

 $custom_id = md5($display);
 $rowmodel->set("tagid","'". $custom_id . "'");
 $rowmodel->set("tagname","'" . $display . "'");
 $rowmodel->set("tagdisplay","'" . $display . "'");
 $rowmodel->set("created_on","" . time() . "");
 $rowmodel->set("tagdescription","'" . $description . "'");
 
 try {
 	$tablemodel->add($rowmodel);
 } catch(Exception $e){
 	// Ignore dup key errors
 	//echo "ERR Code  " . $e->getCode();
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
 	//echo "ERR Code 2 " . $e->getCode();
 	if ($e->getCode() != 1062){
 	  die("{$e->getMessage()}");
 	}
 }
 
 
 // Adding tag to account mapping
 $tablemodel2 = new TableModel();
 $tablemodel2->tableName = "account_tag_mapping";
 
 $aRowModel = new RowModel();
 $aRowModel->set('tagid',"'".$custom_id."'");
 $aRowModel->set("uid","'" . $_SESSION['user_object']->id . "'");
 $aRowModel->set('created_on',"".time()."");
 
 try {
   $tablemodel2->add($aRowModel);  	
 } catch (Exception $e){
 	// Ignore dup key errors
 	//echo "ERR Code 3 " . $e->getCode();
 	if ($e->getCode() != 1062){
 	  die("{$e->getMessage()}");
 	}
 	
 }
 
 
 


}


}


?>