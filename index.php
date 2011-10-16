<?php
ob_start();
require_once 'init.php';
session_start_wrap();
  
?>
<!DOCTYPE html>
<html>
<head>
  <title><?php echo APPNAME; ?></title>
  <link rel="stylesheet" type="text/css" media="screen" href="style/style.css">
  <link rel="stylesheet" type="text/css" media="screen" href="style/modal.css">
  <script type="text/javascript" src="http://cdn.jquerytools.org/1.2.5/jquery.tools.min.js"></script>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
  
  <!--
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/prototype/1.7.0.0/prototype.js"></script> 
  
   <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/scriptaculous/1.9.0/scriptaculous.js"></script>
   <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/webfont/1.0.22/webfont.js"></script>
   <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/yui/3.3.0/build/yui/yui-min.js"></script>
   -->
   
   <script type="text/javascript" src="js/test.js"></script>
   
      <script type="text/javascript" src="js/json2.js"></script>
      <script type="text/javascript" src="js/form.js"></script>
      <script type="text/javascript" src="js/menu.js"></script>
      <script type="text/javascript" src="js/page.js"></script>
      <script type="text/javascript" src="js/action.js"></script>
   <!--
   <script type="text/javascript" src=""></script>
   --> 
</head>
<body>

 



<?php

if (isset($_SESSION['isLoggedIn']) && ($_SESSION['isLoggedIn'] == TRUE) ){
   $status = "logged in";
   include_once "templates/page.php"; 
   //var_dump($_SESSION['user_object']);
   
   
}
else {
  include_once 'login.php';
  echo time()."</br>";
  echo $_SERVER['REMOTE_ADDR']."</br>";
   echo $_SERVER['SERVER_ADDR']."</br>";
    echo $_SERVER['SERVER_ADDR']."</br>";
     echo $_SERVER['HTTP_USER_AGENT']."</br>";
     echo $_SERVER['DOCUMENT_ROOT']."</br>";
     echo dirname(__FILE__)."</br>";
     echo "<div><a href=\"register.php\">Register</a></div>";   
       echo "<div>Session_id : ".session_id()."</div>"; 
}

?>
<!-- modal wrapper start -->
<div id="modal_wrapper">
 
</div>
<!-- modal wrapper end -->
 <!-- dialog start  -->
  <div id="dialog" class="create_note">
    <div id="dialog_menu_wrap">
      <div id="dialog_menu">
        <ul>
          <li class="selected"><div class="menu_item">Note</div></li>
          <!-- 
          <li><div class="menu_item">Tag</div></li>
          <li><div class="menu_item">Group</div></li>
          <li><div class="menu_item">People</div></li>
          <li><div class="menu_item">Sharing</div></li>
          -->
        </ul>  
      </div>  
    </div>
    <!-- frm wrapper start -->
    <div class="frm_wrapper">
      <form id="createnote_frm" name="create_note" enctype="application/x-www-form-urlencoded" method="POST" action="notes/?q=add">
      <div class="frm_input">
       <input type="text" id="note_docname"  name="docname" value="" placeholder="Enter title here">
       <input type="hidden"  name="action" value="">
        <input type="hidden"  name="entid" value="">
      </div>
      <div class="frm_input">
        <textarea class="note_body" id="note_body" rows='11' cols='80' name="note_body"  placeholder="Enter notes here"  required autofocus></textarea>
      </div>
      <div class="frm_input frm_textarea">  
        <textarea class="note_tags" rows='4' cols='80' id="note_tags" name="note_tags" value="asksak saks"  placeholder="Enter tags here"></textarea>
      </div>  
      
      <div class="frm_input frm_select">  
      
        <select>
          <option value ="">Visibility</option>
          <option value ="saab">Public</option>
          <option value ="opel">Private</option>
          <option value ="audi">Friends</option>
        </select>
        
      </div> 
      
      </form>
    </div>
    <!-- frm wrapper end -->
    <div class="frm_button">
      <button  id="postclear_bt" class="left_b">clear</button> <button id="postsave_bt" data-actiontype='new' class="right_b">save</button>
    </div>  
  </div>
  <!-- dialog end -->
  

  
<script type="text/javascript">
  $(function(){
   // testing.hideModal('dialog');
   // testing.hideModal('modal_wrapper');
  });

  
</script>  
</body>
</html>

<?php
 ob_end_flush();
?>
