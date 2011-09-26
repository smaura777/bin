/**
 * 
 * FILE: test.js
 */
 
 
 /**
  * hideModal
  *
  */
  
  var testing = {
   
   err_msg: '',
   
  /**
   *  hideModal
   *
   */
   
   hideModal: function(modalID){
     try{
       $("#"+modalID+"").css('display','none');    
     }catch(err){
       err_text = "Error on page " + err.description;
       alert(err_text);
     }
   },
   
  showModal: function(modalID){
    try {
        $("#"+modalID+"").css('display','block');     
    } catch(err) {
      err_text = "Error on page " + err.description;
       alert(err_text);
    }
  }
  
  };
  
   
