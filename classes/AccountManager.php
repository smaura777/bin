<?php



class AccountManager {
  private $_connection;
  public $lastErrorString = "No errors";
  
  function create($name,$pass,$fname=NULL,$lname=NULL){
    if ($this->userExist($name)){
      $this->lastErrorString = "Username taken already - pick another one"; 
      throw new Exception("Username taken already - pick another one");
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
     // echo "<p> ".$rowmodel->toColumnList()."</p>";
    //  echo "<p> ".$rowmodel->toValues()."</p>";
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
    	//echo "<p> ".$rowmodel->toColumnList()."</p>";
    	//echo "<p> ".$rowmodel->toValues()."</p>";
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
     $rowmodel = new RowModel();
     $tablemodel = new TableModel();
     $tablemodel->tableName = "accounts";
     $rowmodel->set("uid","'".$name."'");
     $rowmodel->set("pass","");
     $rowmodel->set("user","");
     $rowmodel->setConstraint("user","'".$name."'");
     
     try {
      $result = $tablemodel->fetch($rowmodel);	
      // $result = $this->_connection->query("SELECT uid,pass,user from accounts WHERE user = '".$name."' ");  
     } catch(Exception $e){
     	die("{$e->getMessage()}");
     }
     
     if ($tablemodel->count() <= 0){
       throw new Exception("invalid Username or Password");
     }
    
     //echo "<p> pass = "  . $result[0]->get("pass")->value .  "</p>";
     if (!$hasher->CheckPassword($pass,$result[0]->get("pass")->value )){
     	throw new Exception("invalid Username or Password 552");
     }
     
     
     
     $user_object = new User();
     $user_object->name = $result[0]->get("user")->value;
     $user_object->id = $result[0]->get("uid")->value;
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
  	  die($e->getMessage());
  	}
    //$result = $this->_connection->query("SELECT * from accounts WHERE user ='".$name."'");
    if ($result > 0){
        return true;
    }
    
    return false;
  }
  
}  

?>
