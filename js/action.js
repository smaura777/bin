/**
 * Actions
 *
 */
 
 // Menu actions

 $(function(){
   
   // Menu events
   $(".add_entry").click(function(){
     menu_actions.toggleModal('modal_wrapper');
   });
   
   // Dismiss actions 
   $("#modal_wrapper").click(function(){
       menu_actions.toggleModal('modal_wrapper');
   });
   
   
   // Note form
   $("#postsave_bt").click(function(){
	   param_obj = {};
	   param_obj.note_body = document.create_note.note_body.value;
	   param_obj.note_tags = document.create_note.note_tags.value;
	   param_obj.docname = document.create_note.docname.value;
	   
	   //alert("Saving ...." + param_obj.note_body);
	   //$("#createnote_frm").submit();
	   try {
	   $.post("notes/?q=add",param_obj,function(data){
		   //alert(data);
		   json_obj = JSON.parse(data);
		   if (json_obj.status == 'success'){
			   param_obj = {};
			   param_obj.id = '1317349621-xp-958954';
			  //$.get('notes/?q=get',function(data){alert(data)}); 
			   menu_actions.toggleModal('modal_wrapper');
			   page_actions.updateEntries();
		   }
		   else {
		     alert(" post failute  " +json_obj.status);
		   }
		   
		   });
	   } catch(err){
		   alert("Post error "+ err.description);
	   }
   });
    
   page_actions.updateEntries();
   
  
   
   
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
 
 
 
 var menu_actions = {
   toggleModal: function(modalID){
       
       if ($("#"+modalID+"").css('display') == 'none'){
         testing.showModal('modal_wrapper');
         testing.showModal('dialog');
       }
       else {
         testing.hideModal('modal_wrapper');
         testing.hideModal('dialog');
       }    
       
       //alert("Hey...");
   }
 };
 
 var page_actions = {
   updateEntries: function(){
     // Start
     
     $.get('notes/?q=get',function(data){
      var json_obj = JSON.parse(data);
      if (json_obj.status == 'success'){
          // $("#innermaster_wrap").html("<div><pre>"+data+" </pre></div>");
          // alert(data);
         // alert(json_obj.entries.length);
          for (i = 0; i < json_obj.entries.length; i++){
             if (i == 0){
               $("#innermaster_wrap_content").html("<div><div class='entrybody'>"+json_obj.entries[i].entrybody+" </div><div class='created_on'>"+json_obj.entries[i].created_on+"</div> " +
               		"<ul><li data-entryid="+json_obj.entries[i].entryid+" class='entry_edit' onclick=\"menu_actions.toggleModal('modal_wrapper');\" >edit</li> <li data-entryid="+json_obj.entries[i].entryid+" class='entry_delete' onclick=\"javascript:if (confirm('Are you sure ?')) {alert('ok');}  ;\" >delete</li> </ul></div>");
             }
             else {
                $("#innermaster_wrap_content").append("<div id='entry_'"+json_obj.entries[i].entryid+"'><div class='entrybody'>"+json_obj.entries[i].entrybody +" </div><div class='created_on'>"+json_obj.entries[i].created_on+"</div>" +
                		"<ul><li data-entryid="+json_obj.entries[i].entryid+" class='entry_edit'>edit</li> <li data-entryid="+json_obj.entries[i].entryid+"  class='entry_delete'>delete</li> </ul> </div>");
           
             }
          }
      }
      else {
        $("#innermaster_wrap").html("<div>No Notes</div>");
      }
   }); 
      
      
     // End 
   }
   
 };
 
 
 
 
