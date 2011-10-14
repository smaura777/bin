var Form = {
	clearForm: function(form_name){
		switch(form_name){
		  case 'create_note':
			  try {
			  document.create_note.note_body.value = '';
			  document.create_note.note_tags.value = '';
			  document.create_note.docname.value = '';
			  }
			  catch(err){
				return -1;  
			  }
			  return 0;
		  break;
		  
		  default: 
			  alert('unknowed form ');
		}
	}
};