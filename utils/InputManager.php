<?php

class InputManager {

static function Cleanup(){
  if (get_magic_quotes_gpc()){
  
   if (isset($_POST) && (count($_POST) > 0) ) { 
     foreach ($_POST as $key => $val ){
       $_POST[$key] =  Filter::SQLEscape(stripslashes(trim($val)));
     }
   }
    
   if (isset($_GET) && (count($_GET) > 0) ) {  
     foreach ($_GET as $key => $val ){
       $_GET[$key] =  Filter::SQLEscape(stripslashes(trim($val)));
     }
   }
   
  }
 
  
}



}
?>
