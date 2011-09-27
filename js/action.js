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
	   //alert("Saving ....");
	   $("#createnote_frm").submit();
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
 
 
 
