function rejectMoneyRequest(requestId) {
  $.ajax({
    type: "POST", //request type
    url : 'apis/api-update-money-request-status',
    data :  {
      "newStatus" : 2,
      "moneyRequestId" : requestId
    },
    dataType:'JSON',
    cache: false
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
      $("#"+requestId).find(".statusVal")[0].innerHTML ="2";   
      $("#"+requestId).remove() 
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



function approveMoneyRequest(requestId) {
  $.ajax({
    type: "POST", //request type
    url : 'apis/api-update-money-request-status',
    data :  {
      "newStatus" : 1,
      "moneyRequestId" : requestId
    },
    dataType:'JSON',
    cache:false
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
      $("#"+requestId).find(".statusVal")[0].innerHTML ="1";   
      $("#"+requestId).remove() 
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



