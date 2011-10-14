 

var Menu = {
   toggleModal: function(modalID,mode){
       
	   if(mode == 'update'){
		   $("#postclear_bt").css('display','none');
		   //$("#note_docname").attr('disabled','disabled');
		   $("#note_docname").css('display','none');
		   $("#postsave_bt").data('actiontype','edit');
	   }
	   else {
		   $("#note_docname").css('display','');
		   $("#postclear_bt").css('display','');
		   $("#postsave_bt").data('actiontype','new');
	   }
	   
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
 