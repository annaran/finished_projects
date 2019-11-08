$('#frmSendMail').submit( function(){

    $.ajax({
      method : "GET",
      url : 'apis/api-send-mail',
      data :  {
                "message" : $('#txtMessageMailToAll').val(),
                "subject" : $('#txtSubjectMailToAll').val()         
              },
      cache: false,
      dataType:"JSON"    
    }).
    done( function(jData){
      if(jData.status == -1){
        //console.log('*************')
        console.log(jData)
        console.log(jData)
        swal({title:"FAIL", text: jData.message,   icon: "warning", }); 

      }
  
      if(jData.status == 0){
        console.log('*************')
        console.log(jData)
        swal({title:"FAIL", text: jData.message,   icon: "warning", }); 
      } // end of 0 case
  
      if(jData.status == 1){
        console.log('*************')
        console.log(jData)
        swal({title:"SUCCESS", text: jData.message,   icon: "success", });     
      return
        
      }   

      location.reload(true);
    }).
    fail( function(){
      console.log('FATAL ERROR')
    })
  
  
    return false
  })