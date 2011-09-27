<?php
ob_start();
require_once '../init.php';
session_start_wrap();
//header('Content-type: text/json');
//header('Content-type: application/json');


$body = "note_body";
$tags  = "note_tags";
try {
$r_val = procesPost($body,$tags);
} catch (Exception $e){
 echo json_encode(array("message"=>"".$e->getMessage().""));	
}

echo json_encode($r_val);

ob_end_flush();

?>