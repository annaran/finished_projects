// ******************************************************
// ******************************************************
// ******************************************************


$('#frmTransfer').submit( function(){

  $.ajax({
    method : "GET",
    url : 'apis/api-transfer',
    data :  {
              "phone" : $('#txtTransferToPhone').val(),
              "amount" : $('#txtTransferAmount').val(), 
              "message" : $('#txtTransferMessage').val() 
            },
    cache: false,
    dataType:"JSON"    
  }).
  done( function(jData){
    if(jData.status == -1){
      console.log('*************')
      console.log(jData)
      swal({title:"FAIL", text: jData.message,   icon: "warning", });
    }

    if(jData.status == 2){
      console.log('*************')
      console.log(jData)
      swal({title:"FAIL", text: jData.message,   icon: "warning", });
    }

    if(jData.status == 0){
      console.log('*************')
      swal({title:"INFO", text: jData.message,   icon: "info", });
    } // end of 0 case

    if(jData.status == 1){
      console.log('*************')
      console.log(jData)
      // TODO: Continue with a local transfer
      swal({title:"SUCCESS", text: jData.message ,   icon: "success",  });
    }   
  }).
  fail( function(){
    console.log('FATAL ERROR')
  })


  return false
})









