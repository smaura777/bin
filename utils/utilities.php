<?php

function Logger($msg){
 // echo "Logger called <br />"; 
  if (DEBUG_MODE){
    echo $msg;
  }
}

function issetAndNotEmpty($param){
  if (isset($param) && (!empty($param)) ){
    return true;
  }
  
  return false;
}



function PageStats(){
    //Logger("<br /> Request params count " . count($_REQUEST) . "<br />");
  foreach($_REQUEST as $key => $val){
   // Logger("key : " . $key . " value : " . $val . "<br />");
   }
}


/**
 *
 */
 
function logout(){
   $_SESSION = array();
   session_destroy();
} 




function procesPost($doc_name,$body,$tags) {
	$tag_included = FALSE;

	if (!isset($_POST[$doc_name]) ){
		throw new Exception("Document name not set");
	}
	
	if (empty($_POST[$doc_name])){
		throw new Exception("Document name is empty");
	}
	
	if (!isset($_POST[$body]) ){
  	   throw new Exception("Post body not set");
     }
     
    if (empty($_POST[$body])){
     	throw new Exception("Post body is empty");
    }
     
     $doc_val = trim($_POST[$doc_name]);
     $body_val = trim($_POST[$body]);

     
     if (isset($_POST[$tags]) ){
       if (!empty($_POST[$tags]) ){
       	$tag_included = TRUE;
       	$tag_val = explode(",",strtolower(trim($_POST[$tags])));
       	// Array dup removal
        $tag_filter = array();	
       	foreach ($tag_val as $element){
       	  $tag_filter['"'.$element .'"'] = $element;	
       	}
       	
       	$tag_val = array_values($tag_filter);
       }
     }
     
     $documentManager = new DocumentManager();
     try {
     $documentManager->create($doc_val);
     } catch(Exception $e){
       return array('status' => 'failure','message'=> "".$e->getMessage()."" );	
     }
     
     // Adding note
     
     $postManager = new PostManager();
     try {
       $postManager->create($documentManager->getRecentID(), $body_val);
     } catch(Exception $e){
     	return array('status' => 'failure','message'=> "".$e->getMessage()."" );
     }
     
     if ($tag_included == TRUE){
     	// Recent entry ID
     	$recentEntryID =  $postManager->recentEntryID();
     	$tagManager = new TagManager();
     	//try {
     	  foreach ($tag_val as $element) {	
     	  	try {
     	    $tagManager->create($element,'',$recentEntryID);
     	  	} catch (Exception $e){
     	  	  if ($e->getCode()  != 1062 ){
     	  	  	   return  array('status' => 'failure','message'=>"".$e->getMessage()." code =  " . $e->getCode() . "  "   . __LINE__ );	
     	  	  }	
     	  	}
     	   
     	  }
     	
     }
     
   try {  
   $last_entry_id = $postManager->recentEntryID();
   } catch(Exception $e){
   	  return array('status' => 'failure', 'message'=>"".$e->getMessage()." ". __LINE__);
   }
   
   return array('status'=> 'success','entry_id' => "".$last_entry_id."");     
}


function  getNote($entry_id){
	$postManager = new PostManager();
	if ( !(is_null($entry_id)) &&  is_array($entry_id) ) {
		$entries = array();
        foreach ($entry_id as $item){
        	try {
        		$last_entry = $postManager->getNote($item);
        	} catch(Exception $e) {
        		return array('status'=>"failure",'message' => "".$e->getMessage() ."");
        	}
        	
        	$entries[] = array('docid' => "".$last_entry[0]->get('docid')->value."",
        	        'docdisplay' => "".$last_entry[0]->get('docdisplay')->value."",
        	        'tagcloud' => "".$last_entry[0]->get('tag_cloud')->value."",
	                'entryid' => "".$last_entry[0]->get('entryid')->value."",
	                'entrybody' => "".$last_entry[0]->get('entrybody')->value."",
	                'created_on' => "".date($last_entry[0]->get('created_on')->value)."");
        }
        $res = array("status" => "success", "entries" => $entries);		
	}
	else {
	
	    try {
		   $last_entry = $postManager->getAllNotes();
	    } catch(Exception $e) {
		  return array('status'=>"failure",'message' => "".$e->getMessage() ."");
	    }
        $entries = array();

	    foreach ($last_entry as $item){
	    	$entries[] =  array('docid' => "".$item->get('docid')->value."",
	    	'docdisplay' => "".$item->get('docdisplay')->value."",
	    	'tagcloud'  =>  "".$item->get('tag_cloud')->value."",
	           'entryid' => "".$item->get('entryid')->value."",
	           'entrybody' => "".substr_replace(trim($item->get('entrybody')->value),'...',160)."",
	           'created_on' => "".date('r',$item->get('created_on')->value)."");
	    }
	    
	    $res = array( "status" => "success", "entries" => $entries);
	}
	
	return $res;
}


 
function processRegistrationRequest($user,$password,$first,$last){
  $err = '';
  $errorManager = new ErrorManager();
  
  $fname = null;
  $lname = null;
  //Missing
  if (!isset($_POST[$user])){
     $err = 'Missing user name';
     // Save error in db
     if (!$errorManager->save(100,$err)){
       echo $errorManager->lastErrorString;
     }
     return $err;
   }
   
  if (!isset($_POST[$password])){
     $err = 'Missing password';
     // Save error in db
     if (!$errorManager->save(100,$err)){
       echo $errorManager->lastErrorString;
     }
     return $err;
  }
  
   // Required
   if (trim($_POST[$user]) == ''){
      $err = 'Missing user name';
     // Save error in db
     if (!$errorManager->save(100,$err)){
       echo $errorManager->lastErrorString;
     }
     return $err;  
   }
   
   if (trim($_POST[$password]) == ''){
      $err = 'Missing password';
      // Save error in db
      if (!$errorManager->save(100,$err)){
        echo $errorManager->lastErrorString;
      }
     return $err;  
   }
   
  // Optional
  
  if (isset($_POST[$first]) && (trim($_POST[$first]) != '') ){
    $fname = $_POST[$first];
  }
 
   if (isset($_POST[$last]) && (trim($_POST[$last]) != '') ){
    $lname =$_POST[$last];
  }
 
  
  // Create if not exist
  $manager = new AccountManager();
  try {
  $response = $manager->create($_POST[$user],$_POST[$password],$fname,$lname);  
  }catch (Exception $e){
  	die($e->getMessage());
  }
  
  if ($response != TRUE){
    $err = $manager->lastErrorString;
    if (!$errorManager->save(100,$err)){
      echo $errorManager->lastErrorString;
    }
  }
  
  return $err;  
}

function processLoginRequest($user,$password){
   $err ='';
   $errorManager = new ErrorManager();
   // Missing 
   if (!isset($_POST[$user])){
     $err = 'Missing user name';
     // Save error in db
    if (!$errorManager->save(100,$err)){
      echo $errorManager->lastErrorString;
    }
     return $err;
   }
   
   if (!isset($_POST[$password])){
     $err = 'Missing password';
     // Save error in db
     if (!$errorManager->save(100,$err)){
       echo $errorManager->lastErrorString;
     }
     return $err;
   }
   
   
   // Required
   if (trim($_POST[$user]) == ''){
      $err = 'Missing user name';
     // Save error in db
     if (!$errorManager->save(100,$err)){
      echo $errorManager->lastErrorString;
    }
     return $err;  
   }
   
   if (trim($_POST[$password]) == ''){
      $err = 'Missing password';
      // Save error in db
      if (!$errorManager->save(100,$err)){
        echo $errorManager->lastErrorString;
      }
     return $err;  
   }
   
   
   // Login 
   $manager = new AccountManager();
   try {
   $response = $manager->authenticate($_POST[$user],$_POST[$password]);
   } catch(Exception $e){
   	   die("<p>".$e->getMessage() ."</p>");
   }
   if ($response ==  null || $response ==  false){
     $err = $manager->lastErrorString;
     // Save error in db
     if (!$errorManager->save(100,$err)){
       echo $errorManager->lastErrorString;
     }
     return $err;  
   }
   
   $user_object = $response;  
   session_regenerate_id();
   $_SESSION['initiated'] = TRUE;
   $_SESSION['user_object'] = $user_object;
   $_SESSION['isLoggedIn'] = true;
   
   return $err;
 }

 
function deletePost($entryid){
	$postManager = new PostManager();
	try {
		$postManager->deletePost(trim($entryid));
	} catch(Exception $e){
		return array('status' => 'failure','message'=> "".$e->getMessage()."" );
	} 

	return array('status' => 'success','message' => 'Post deleted');
}
 
function updatePost($entryid,$body,$tags=''){
	$postManager = new PostManager();
	try {
		$postManager->updatePost(trim($entryid),trim($body));
	} catch(Exception $e){
		return array('status' => 'failure','message'=> "".$e->getMessage()."" );
	}
	
	if ($tags != ''){
		$tag_val = explode(",",strtolower(trim($tags)));
       	// Array dup removal
        $tag_filter = array();	
       	foreach ($tag_val as $element){
       	  $tag_filter['"'. $element .'"'] = $element;	
       	}
       	
       	$tag_val = array_values($tag_filter);
		// Get ID of the updated entry
		$recentEntryID =  $postManager->recentEntryID();
		
	    $tagManager = new TagManager();
     	foreach ($tag_val as $element) {	
     	  try {
     	      $tagManager->create($element,'',$recentEntryID);
     	  	} catch (Exception $e){
     	  	  if ($e->getCode()  != 1062 ){
     	  	  	   return  array('status' => 'failure','message'=>"".$e->getMessage()." code =  " . $e->getCode() . "  "   . __LINE__ );	
     	  	  }	
     	  	}   
     	}
		
	}
	
	
    return array('status' => 'success','message'=> "Post updated");
	
} 

function session_start_wrap(){
  session_start();
  if (!isset($_SESSION['initiated'])){
     session_regenerate_id();
     $_SESSION['initiated'] = TRUE;
  }
  
  if (isset($_SESSION['HTTP_USER_AGENT'])){
    if ($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT'])){
       header("Location: logout.php"); 
       exit;
    }
  }
  else {
    $_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']); 
  }
  
  
  // testing 
  if (isset($_SESSION['user_object'])){
    //echo "<div><p>User is logged in.</p></div>";
  }
  else {
     echo "<div><p>User is anonymous</p></div>";
  }
  
}


?>
