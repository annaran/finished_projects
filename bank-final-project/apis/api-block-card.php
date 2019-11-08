<?php


session_start();
ini_set('display_errors', 0);
if( !isset($_SESSION['sUserId']) && $_SESSION['sUserId'] != '12345678' ){
  header('Location: login');
}

if( empty( $_POST['newStatus'] ) ){ sendResponse(-1, __LINE__, 'Status is missing'); }
if( empty( $_POST['cardId'] ) ){ sendResponse(-1, __LINE__, 'Card Id is missing'); }



$sUserId = $_SESSION['sUserId'];
//$sUserId = '17444444';


$sData = file_get_contents('../data/clients.json');
$jData = json_decode( $sData );

if( $jData == null){ sendResponse(-1, __LINE__, 'Cannot convert data to JSON');  }

$jInnerData = $jData->data;

$sCardId = $_POST['cardId'];


//check if card has status 'blocked'
$iCurrentCardStatus = $jInnerData->$sUserId->cards->$sCardId->status;
if($iCurrentCardStatus==2)
{
    sendResponse(0, __LINE__,'This card has already been blocked');
}


$jInnerData->$sUserId->cards->$sCardId->status = $_POST['newStatus']; 

$sData = json_encode( $jData, JSON_PRETTY_PRINT );
if( $sData == null   ){ sendResponse(-1, __LINE__,'sData is null'); }
file_put_contents( '../data/clients.json', $sData );


sendResponse( 1, __LINE__ , 'Card has been blocked');


// **************************************************
function sendResponse($iStatus, $iLineNumber, $sMessage){
  echo '{"status":'.$iStatus.', "code":'.$iLineNumber.',"message":"'.$sMessage.'"}';
  exit;
}

// **************************************************













