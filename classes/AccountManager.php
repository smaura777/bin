<?php



class AccountManager {
  private $_connection;
  public $lastErrorString = "No errors";
  
  function create($name,$pass,$fname=NULL,$lname=NULL){
    if ($this->userExist($name)){
      $this->lastErrorString = "Username taken already - pick another one"; 
      return false;
    }

    $hasher = new PasswordHash(8, FALSE);
    $hash = $hasher->HashPassword($pass);
    $rowmodel = new RowModel();
    $tablemodel = new TableModel();
    $tablemodel->tableName = "accounts";
    if (($fname != null) && ($lname != null)){
      $rowmodel->set("uid","UUID()");
      $rowmodel->set("user","'".$name."'");
      $rowmodel->set("pass", "'".$hash."'");
      $rowmodel->set("created_on","".time()."");
      $rowmodel->set("last_modified","".time()."");
      $rowmodel->set("status","'active'");
      $rowmodel->set("fname","'".$fname."'");
      $rowmodel->set("lname","'".$lname."'");
      echo "<p> ".$rowmodel->toColumnList()."</p>";
      echo "<p> ".$rowmodel->toValues()."</p>";
    //  die("Debug test");
      
      try {
      	$tablemodel->add($rowmodel);
      } catch(Exception $e){
        die("<p> ". $e->getMessage() . "</p>");
      }
    //   $this->_connection->query("INSERT INTO accounts (uid,user,pass,created_on,last_modified,status,fname,lname) values(UUID(),'".$name."','".$hash."',".time().",".time().",'active','".$fname."','".$lname."' )");
    }
    else {
    	$rowmodel->set("uid","UUID()");
    	$rowmodel->set("user","'".$name."'");
    	$rowmodel->set("pass", "'".$hash."'");
    	$rowmodel->set("created_on","".time()."");
    	$rowmodel->set("last_modified","".time()."");
    	$rowmodel->set("status","'active'");
    	echo "<p> ".$rowmodel->toColumnList()."</p>";
    	echo "<p> ".$rowmodel->toValues()."</p>";
    	//die("Debug test");
    	
    	try {
    		$tablemodel->add($rowmodel);
    	} catch(Exception $e){
    		die("<p> ". $e->getMessage() . "</p>");
    	}    	    	
      //$this->_connection->query("INSERT INTO accounts (uid,user,pass,created_on,last_modified,status) values(UUID(),'".$name."','".$hash."',".time().",".time().",'active')");
    }

  }
  
  
  function authenticate($name,$pass){
     $hasher = new PasswordHash(8, FALSE);
     $result = $this->_connection->query("SELECT uid,pass,user from accounts WHERE user = '".$name."' ");  
      
     if ($result == null){
       $this->lastErrorString = __CLASS__. " : ".__LINE__ . " : Invalid query " . $this->_connection->error . ''; 
       return null;
     }
     
     if ($result->num_rows <= 0){
       $this->lastErrorString = __CLASS__. " : ".__LINE__ . " : invalid Username or Password "; 
       return null;
     }
    
     $row = $result->fetch_object();
     if (!$hasher->CheckPassword($pass,$row->pass)){
       $this->lastErrorString = __CLASS__. " : ".__LINE__ . " : invalid Username or Password "; 
       return false;
     }
     
     $user_object = new User();
     $user_object->name = $row->user;
     $user_object->id = $row->uid;
     return $user_object;
  }
  
  function read($id){
   //return  account object 
  }
  
  function update($id,$update_array){
  
  }
  
  function delete(){
    // disable accounts
  }
  
  
  function userExist($name){
  	$result = 0;
  	$rowmodel = new RowModel();
  	$tablemodel = new TableModel();
  	$rowmodel->setConstraint("user","'" . $name . "'");
  	//echo $rowmodel->toColumns() ."<br/>";
  	//echo $rowmodel->toConstraints()."<br/>";
  	$tablemodel->tableName = "accounts";
  	try {
  	//echo "<br/> count = ". $tablemodel->fetchCount($rowmodel)."<br/>";
  	  $result = $tablemodel->fetchCount($rowmodel);
  	} catch(Exception $e){
  		echo $e->getMessage();
  	}
    //$result = $this->_connection->query("SELECT * from accounts WHERE user ='".$name."'");
    if ($result > 0){
        return true;
    }
    
    return false;
  }
  
}  

?>
