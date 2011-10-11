<?php
ob_start();
require_once '../init.php';
session_start_wrap();
//header('Content-type: text/json');
//header('Content-type: application/json');

switch ($_SERVER['REQUEST_METHOD']){
	case 'POST':
		
		switch($_POST['action']){
			case 'deletepost':
				if (isset($_POST['entryid']) && ($_POST['entryid'] !=  '') ){
					$r_val = deletePost($_POST['entryid']);
				    echo json_encode($r_val);
				}
				else {
					echo json_encode(array('status' => 'failure','message' => 'Missing ID'));
				}
				
			break;
			case 'updatepost':
		        if ( isset($_POST['entryid']) && ($_POST['entryid'] !=  '') && isset($_POST['note_body']) && ($_POST['note_body'] != '') ){
					
		        	$r_val = updatePost($_POST['entryid'],$_POST['note_body']);
				    echo json_encode($r_val);
				}
				else {
					echo json_encode(array('status' => 'failure','message' => 'Missing ID for update'));
				}	
			break;
			default:
				
				$body = "note_body";
				$tags  = "note_tags";
				$doc_name = "docname";
						
				try {
				$r_val = procesPost($doc_name,$body,$tags);
				} catch (Exception $e){
				echo json_encode(array('status' => 'failure',"message"=>"".$e->getMessage().""));
				die();
				}
				
				echo json_encode($r_val);					
		}
		
		
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