$('#frmAddCard').submit( function(){

    $.ajax({
      method : "GET",
      url : 'apis/api-card-application',
      data :  {
                "type1" : $('#txtCardType1').val(),
                "type2" : $('#txtCardType2').val()
               

              },
      cache: false,
      dataType:"JSON"    
    }).
    done( function(jData){
      if(jData.status == -1){
        //console.log('*************')
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
        swal({title:"SUCCESS", text: jData.message,   icon: "success", })
        .then((value) => {window.location.replace=window.location.origin +'/manage_cards'});   
      return
        
      }   
    }).
    fail( function(){
      console.log('FATAL ERROR')
    })
  
  
    return false
  })



  function blockCard(cardId) {
    $.ajax({
      type: "POST", //request type
      url : 'apis/api-block-card',
      data :  {
        "newStatus" : 2,
        "cardId" : cardId
      
      },
      success:function(result){
        location.reload(true);
       console.log(result);
     }
   });
  }