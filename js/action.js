/**
 * Actions
 *
 */
 
 // Menu actions

 $(function(){
   
   // Menu events
   $(".add_entry").click(function(){
     Menu.toggleModal('modal_wrapper');
     if (Form.clearForm('create_note') == -1){
		   alert('Could not clear form ');
	 }
     
   });
   
   // Dismiss actions 
   $("#modal_wrapper").click(function(){
       Menu.toggleModal('modal_wrapper');
   });
   
   
   // Create/Update Note form save action
   $("#postsave_bt").click(function(){
	  // alert($(this).data('actiontype'));
	   if (document.create_note.note_body.value == ''){
		   alert('Body cannot be empty!');
		   return;
	   }
	   
	   if ( $(this).data('actiontype') == 'new' && document.create_note.docname.value == ''){
		   alert('Docname cannot be empty!');
		   return;
	   }
	   
	   
	   
	   param_obj = {};
	   param_obj.action = '';
	   
	   param_obj.note_body = document.create_note.note_body.value;
	   param_obj.note_tags = document.create_note.note_tags.value;
	   
	  
	   param_obj.docname = document.create_note.docname.value;
	   
	   if (document.create_note.entid.value){
		 param_obj.entryid =   document.create_note.entid.value;
		 //alert("sending id " + document.create_note.entid.value );
	   }
	   
	   if (document.create_note.action.value){
		  //alert("sending  action " + document.create_note.action.value ); 
		  param_obj.action =   document.create_note.action.value;
	   }
	   
	   
	   //alert("Saving ...." + param_obj.note_body);
	   //$("#createnote_frm").submit();
	   try {
	   $.post("notes/?q=add",param_obj,function(data){
		   //alert(data);
		   if (data == null){
			   return;
		   }
		   
		   json_obj = JSON.parse(data);
		   if (typeof json_obj === 'object' && json_obj.status !== null && json_obj.status !== undefined){ 
		      if (json_obj.status == 'success'){
			    param_obj = {};
			    param_obj.id = '1317349621-xp-958954';
			    //$.get('notes/?q=get',function(data){alert(data)}); 
			    Menu.toggleModal('modal_wrapper');
			    Post.updateEntries();
		      }
		      else {
		        alert(" post failute  " +json_obj.status);
		      }
		   }
		   else {
			  alert('Non Object returned!');  
		   }
		   
		   
		   });
	   } catch(err){
		   alert("Post error "+ err.description);
	   }
   });
    
   // Clear form 
   $("#postclear_bt").click(function(){
	   //alert("Clear");
	   if (Form.clearForm('create_note') == -1){
		   alert('Could not clear form ');
	   }
   });
   
   Post.updateEntries();
   
  
   
   
   // OnPage load
   /**
   $.get('notes/?q=get',function(data){
      var json_obj = JSON.parse(data);
      if (json_obj.status == 'success'){
          // $("#innermaster_wrap").html("<div><pre>"+data+" </pre></div>");
          // alert(data);
          for (i = 0; i < json_obj.entries.length; i++){
             $("#innermaster_wrap").html("<div><div class='entrybody'>"+json_obj.entries[i].entrybody+" </div><div class='created_on'>"+json_obj.entries[i].created_on+"</div> </div>");
          }
      }
      else {
        $("#innermaster_wrap").html("<div>No Notes</div>");
      }
   }); 
   **/
   
 });  
 
 
 


 
 
 
