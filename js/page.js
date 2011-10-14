 var Post = {
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
               $("#innermaster_wrap_content").html("<div id='entry_"+json_obj.entries[i].entryid+"'><div class='entrybody'> "+json_obj.entries[i].entrybody+" </div>" +
               		"<div class='created_on'>"+json_obj.entries[i].created_on+"</div> " +
               		"<ul><li data-entryid="+json_obj.entries[i].entryid+" class='entry_edit' onclick=\"Post.getPost('"+ json_obj.entries[i].entryid +"');   \" >edit</li> " +
               	    "<li data-entryid="+json_obj.entries[i].entryid+" class='entry_delete' onclick=\"javascript:if (confirm('Are you sure ?')) {Post.deletePost('"+json_obj.entries[i].entryid+"');}  ;\" >" +
               	    "delete</li> </ul></div>");
             }
             else {
                $("#innermaster_wrap_content").append("<div id='entry_"+json_obj.entries[i].entryid+"'><div class='entrybody'>"+json_obj.entries[i].entrybody +" </div>" +
                "<div class='created_on'>"+json_obj.entries[i].created_on+"</div>" +
                		"<ul><li data-entryid="+json_obj.entries[i].entryid+" class='entry_edit' onclick=\"Post.getPost('"+ json_obj.entries[i].entryid +"') \" >edit</li> " +
                		"<li data-entryid="+json_obj.entries[i].entryid+"  class='entry_delete' onclick=\"javascript:if (confirm('Are you sure ?')) {Post.deletePost('"+json_obj.entries[i].entryid+"');}\">delete</li>" +
                	 " </ul> </div>");
           
             }
          }
      }
      else {
        $("#innermaster_wrap").html("<div>No Notes</div>");
      }
   }); 
      
      
     // End 
   },
 
  deletePost : function(entryid){
	  //alert('deleting post...');
	  param_obj = {};
	  param_obj.action = 'deletepost';
	  param_obj.entryid = entryid;
	  try{
	    $.post('notes/',param_obj,function(data){
	      json_obj = JSON.parse(data);
	      if (json_obj.status != 'success'){
	    	alert('Could not delete Post');  
	      }
	      Post.updateEntries();
	    }); 
	  } catch(err){
		  alert('Delete post failed');
	  }
    },
    
 getPost : function(entryid){
	 param_obj = {};
	 param_obj.id = entryid;
	
	 $.get('notes/?q=get',param_obj,function(data){
		// alert(data);
		 var json_obj = JSON.parse(data);
		 //alert(json_obj.entries[0].entryid);
		 document.create_note.note_body.value = "";
		 document.create_note.note_body.value = ""+json_obj.entries[0].entrybody +"";
		 document.create_note.entid.value = ''+json_obj.entries[0].entryid +'';
		 document.create_note.action.value = "updatepost";
		 Menu.toggleModal('modal_wrapper','update');
		
		 //alert($('#node_body').val("" + json_obj.entries[0].entrybody + ""));
	 });
 }   
   
 };
 