<?php
ob_start();
require_once '../init.php';
session_start_wrap();
//header('Content-type: text/json');
//header('Content-type: application/json');


$body = "note_body";
$tags  = "note_tags";
$doc_name = "docname";

try {
$r_val = procesPost($doc_name,$body,$tags);
} catch (Exception $e){
 echo json_encode(array("message"=>"".$e->getMessage().""));	
}

echo json_encode($r_val);


//echo $_SESSION['user_object']->id;

ob_end_flush();

?>