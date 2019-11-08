function blockAccount(clientId, accountId) {
  $.ajax({
    type: "POST", //request type
    url : 'apis/api-update-account-status',
    data :  {
      "newStatus" : 2,
      "accountId" : accountId,
      "clientId" : clientId
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
     // $("#"+accountId).remove() 
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


function activateAccount(clientId,accountId) {
  $.ajax({
    type: "POST", //request type
    url : 'apis/api-update-account-status',
    cache : false,
    data :  {
      "newStatus" : 1,
      "accountId" : accountId,
      "clientId" : clientId

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
    $("#"+accountId).find(".statusVal")[0].innerHTML ="1";   
   // $("#"+accountId).remove() 
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


function topUpAccount1000(clientId,accountId) {
  $.ajax({
    type: "POST", //request type
    url : 'apis/api-topup-account',
    
    data :  {
      "amount" : 1000,
      "accountId" : accountId,
      "clientId" : clientId
    },
    cache : false,
    success:function(result){
      var resultVal = JSON.parse(result);
      $("#"+accountId).find(".balanceVal")[0].innerHTML = resultVal.currentBalance;

     console.log(result);
   }
 });
}

function topUpAccount100(clientId,accountId) {
  $.ajax({
    type: "POST", //request type
    url : 'apis/api-topup-account',
    data :  {
      "amount" : 100,
      "accountId" : accountId,
      "clientId" : clientId
    },
    success:function(result){
      var resultVal = JSON.parse(result);
      $("#"+accountId).find(".balanceVal")[0].innerHTML = resultVal.currentBalance;
     console.log(result);
   }
 });
}

function topUpAccount500(clientId,accountId,initialAmount) {
  $.ajax({
    type: "POST", //request type
    url : 'apis/api-topup-account',
    data :  {
      "amount" : 500,
      "accountId" : accountId,
      "clientId" : clientId
    },
    success:function(result){
      var resultVal = JSON.parse(result);
      $("#"+accountId).find(".balanceVal")[0].innerHTML = resultVal.currentBalance;
     console.log(result);
   }
 });
}

