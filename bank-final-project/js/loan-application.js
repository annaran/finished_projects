$('#frmLoanApplication').submit( function(){

    $.ajax({
      method : "GET",
      url : 'apis/api-loan-application',
      data :  {
                "amount" : $('#txtAmount').val(),
                "noOfYears" : $('#txtNoOfYears').val()
               

              },
      cache: false,
      dataType:"JSON"    
    }).
    done( function(jData){
      if(jData.status == -1){
        //console.log('*************')
        console.log(jData)
        swal({title:"FAIL", text: jData.message,   icon: "warning", }); 
        return
      }
  
      if(jData.status == 0){
        console.log('*************')
        console.log(jData)
        swal({title:"FAIL", text: jData.message,   icon: "warning", }); 
        return
      } // end of 0 case
  
      if(jData.status == 1){
        console.log('*************')
        console.log(jData)
        swal({title:"SUCCESS", text: jData.message,   icon: "success", });     
      return
        
      }   
    }).
    fail( function(){
      console.log('FATAL ERROR')
    })
  
  
    return false
  })