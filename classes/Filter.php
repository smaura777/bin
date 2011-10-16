<?php

class Filter  {
  static function SQLEscape($in){
    return mysql_real_escape_string($in);
  }
  
  static function Strip($in){
    if (get_magic_quotes_gpc()){
      return stripslashes($in);
    }
    return $in;
  }
  
  static function StripAndEscape($in){
  	if (get_magic_quotes_gpc()){
  		$out = mysql_real_escape_string(stripslashes( strip_tags($in,"<a>") ));
  	}
  	else {
  		$out = mysql_real_escape_string(strip_tags($in,"<a>"));
  	}
  	return $out;
  }
  
}

?>