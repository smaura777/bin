<?php
ob_start();
require_once '../init.php';
session_start_wrap();
//header('Content-type: text/json');
//header('Content-type: application/json');

switch ($_SERVER['REQUEST_METHOD']){
	case 'POST':
		
		$body = "note_body";
		$tags  = "note_tags";
		$doc_name = "docname";
		
		try {
			$r_val = procesPost($doc_name,$body,$tags);
		} catch (Exception $e){
			echo json_encode(array("message"=>"".$e->getMessage().""));
		}
		
		echo json_encode($r_val);
		
	break;
	case 'GET':
		// id,id2,id3
		if (isset($_GET['id']) && $_GET['id'] != ''){
			$id_list  = explode(',', $_GET['id']);
			$r_val = getNote($id_list);	
		}
		else {
			// In that case get up to 50
			$r_val = getNote(NULL);
		}
	    
		
	    
	    echo json_encode($r_val);
	    	
	break;
}




//echo $_SESSION['user_object']->id;

ob_end_flush();

?>