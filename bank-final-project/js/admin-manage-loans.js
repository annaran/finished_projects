function approveLoan(clientId, loanId) {
  $.ajax({
    type: "POST", //request type
    url : 'apis/api-update-loan-status',
    data :  {
      "newStatus" : 1,
      "loanId" : loanId,
      "clientId" : clientId
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
      $("#"+loanId).find(".statusVal")[0].innerHTML ="1"
      $("#"+loanId).remove() 
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



function rejectLoan(clientId, loanId) {
  $.ajax({
    type: "POST", //request type
    url : 'apis/api-update-loan-status',
    data :  {
      "newStatus" : 2,
      "loanId" : loanId,
      "clientId" : clientId
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
      $("#"+loanId).find(".statusVal")[0].innerHTML ="2" 
      $("#"+loanId).remove()  
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



