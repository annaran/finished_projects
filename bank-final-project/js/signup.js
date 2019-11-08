$('#frmSignup').submit( function(){
  
  $.ajax({
    method:"POST",
    url:"apis/api-signup",
    data: $('#frmSignup').serialize(),
    dataType:"JSON"
  }).
  done(function(jData){
    console.log(jData)
    if(jData.status == 1)
    {      
      swal({title:"CONGRATS", text: jData.message,   icon: "success", }); 
      location.href = 'signup_success'    
    
    }
    else{
      swal({title:"FAIL", 
            text: jData.message,
            //text:"System is under maintainance code:"+jData.code,   
            icon: "warning", });      
    }
    
    return
  }).
  fail(function(){
    console.log('error')
  })
  
  
  
  return false
})