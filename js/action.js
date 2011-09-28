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
	   $.post("notes/?q=add",param_obj,function(data){alert(data)});
	   } catch(err){
		   alert("Post error "+ err.description);
	   }
   });
   
 })  
 
 
 
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
 
 
 
