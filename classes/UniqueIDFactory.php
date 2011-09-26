<?php

/**
 * Generates different type of ID's on demand
 * Content ID
 * User ID
 * Asset ID
 *
 */

  class UniqueIDFactory {
     public $lastErrorString = null;
     
     static function generateIDWithUnixTimestampComponent($arg){
       // unixtimestamp - last 2 letters of user name - random numbers
       if (!($arg instanceof User)){
         $lastErrorString = "".__CLASS__.": Wrong parameter type used in method ".__METHOD__." ";
         return null;  
       }
       
      return "".time()."-".substr($arg->name,strlen($arg->name) -2)."-".mt_rand(100000,999999);
     }
       
    // End of class    
  }
  
  
  
?>
