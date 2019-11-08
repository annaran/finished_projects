function blockCard(cardId) {
    $.ajax({
        type: "POST", //request type
        url : 'apis/api-block-card',
        data :  {
            "newStatus" : 2,
            "cardId" : cardId

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
            $("#"+cardId).find(".statusVal")[0].innerHTML ="2"
            $("#"+cardId).remove()
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













/*


function blockCard(cardId) {
  $.ajax({
    type: "POST", //request type
    url : 'apis/api-block-card',
    data :  {
      "newStatus" : 2,
      "cardId" : cardId
    
    },
    success:function(result){
      $("#"+cardId).find(".statusVal")[0].innerHTML ="2";
        $("#"+cardId).remove()
      //location.reload(true);
     console.log(result);
   }
 });
}
*/


