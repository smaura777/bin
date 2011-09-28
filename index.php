<?php
ob_start();
require_once 'init.php';
session_start_wrap();
  
?>
<!DOCTYPE html>
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
   
  //echo "<div><h3>Welcome</h3></div>";
  // echo "<div><a href=\"logout.php\">logout</a></div>";  
  // echo "<div>Session_id : ".session_id()."</div>"; 
  var_dump($_SESSION['user_object']);
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
          <li><div class="menu_item">Tag</div></li>
          <li><div class="menu_item">Group</div></li>
          <li><div class="menu_item">People</div></li>
          <li><div class="menu_item">Sharing</div></li>
        </ul>  
      </div>  
    </div>
    <!-- frm wrapper start -->
    <div class="frm_wrapper">
      <form id="createnote_frm" name="create_note" enctype="application/x-www-form-urlencoded" method="POST" action="notes/?q=add">
      <div class="frm_input">
       <input type="text" size="80" name="docname" value="">
      </div>
      <div class="frm_input">
        <textarea class="note_body" id="note_body" rows='10' cols='80' name="note_body" placeholder="Enter a note here" required autofocus></textarea>
      </div>
      <div class="frm_input frm_textarea">  
        <textarea class="note_tags" rows='2' cols='80' id="note_tags" name="note_tags" placeholder="Enter tags here"></textarea>
      </div>  
      
      <div class="frm_input frm_select">  
        <div><label>Groups</label></div>
        <select>
          <option value ="volvo">Volvo</option>
          <option value ="saab">Saab</option>
          <option value ="opel">Opel</option>
          <option value ="audi">Audi</option>
        </select>
        <span>Create a group</span>
      </div> 
      
      </form>
    </div>
    <!-- frm wrapper end -->
    <div class="frm_button">
      <button  id="postclear_bt" class="left_b">clear</button> <button id="postsave_bt" class="right_b">save</button>
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
