<?php

class TagManager {


function create($display,$description=''){
 if (!isset($_SESSION['user_object'])){
      	throw new Exception("User is not logged in");
  }
      
 if (empty($_SESSION['user_object']->id)){
      	throw new Exception("Missing user ID");
 }

 $rowmodel = new RowModel();
 $tablemodel = new TableModel();
 $tablemodel->tableName = "tags";
 $rowmodel->set("tagid","'". md5(''.mt_rand().''.time()) . "'");
 $rowmodel->set("tagname","'" . $display . "'");
 $rowmodel->set("tagdisplay","'" . $display . "'");
 //$rowmodel->set("user_agent","'" . $_SERVER['HTTP_USER_AGENT'] . "'");
 $rowmodel->set("created_on","" . time() . "");
 $rowmodel->set("uid","'" . $_SESSION['user_object']->id . "'");
 $rowmodel->set("tagdescription","'" . $description . "'");
 
 try {
 	$tablemodel->add($rowmodel);
 } catch(Exception $e){
 	die("<p> ". $e->getMessage() . "</p>");
 }
 
 
 
 /**
    $this->_connection->query("INSERT INTO tags (tagid,tagname,tagdisplay,user_agent,created_on,uid,tagdescription) values
     ('".md5(''.mt_rand().''.time())."','".$display."','".$display."','".$_SERVER['HTTP_USER_AGENT']."',".time().", '".$_SESSION['user_object']->id."','".$description."')");
  
  **/

}


}


?>