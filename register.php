<?php
  ob_start();
?>
<!DOCTYPE html>
<head>
  <title>Memento</title>
</head>
<body>

<div id="form_wrap">
  <div>Registration</div>  
  <form action="registerme/" method="post">
  <!-- Input line start  -->
  <div class="text_input_line">
    <div class="label">Username</div>
    <div class="input_box">
      <input type="text" name="username">
    </div>
  </div>
  <!-- Input line end  -->
   
  <!-- Input line start  -->
  <div class="text_input_line">
    <div class="label">Password</div>
    <div class="input_box">
      <input type="password" name="password">
    </div>
  </div>
  <!-- Input line end  -->
   
  <!-- Input line start  -->
  <div class="text_input_line">
    <div class="label">firstname</div>
    <div class="input_box">
      <input type="text" name="fname">
    </div>
  </div>
  <!-- Input line end  -->
   
  <!-- Input line start  -->
  <div class="text_input_line">
    <div class="label">lastname</div>
    <div class="input_box">
      <input type="text" name="lname">
    </div>
  </div>
  <!-- Input line end  --> 
   
   
  <!-- Input line start  -->
  <div class="submit_line">
    <div class="submit_box">
      <input type="submit" name="submit">
    </div>
  </div>
  <!-- Input line end  -->
    
  </form>
</div>


</body>
</html>

<?php
 ob_end_flush();
?>