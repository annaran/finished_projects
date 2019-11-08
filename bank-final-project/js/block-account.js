function blockAccount(accountId) {
  $.ajax({
    type: "POST", //request type
    url : 'apis/api-block-account',
    data :  {
      "newStatus" : 2,
      "accountId" : accountId
    
    },
    dataType:'JSON'
  }).
  done( function(jData){
    if(jData.status == -1){
 
      console.log(jData)
      swal({title:"FAIL", text: jData.message,   icon: "warning", }); 
    }

    if(jData.status == 0){
     
      console.log(jData)
      swal({title:"INFO", text: jData.message,   icon: "info", });
    } // end of 0 case

    if(jData.status == 1){
      $("#"+accountId).find(".statusVal")[0].innerHTML ="2";   
      $("#"+accountId).remove() 
      console.log(jData)
      swal({title:"SUCCESS", text: jData.message,   icon: "success", });     
    return
      
    }   
  }).
  fail( function(){
    console.log('FATAL ERROR')
  })


  return false
}


