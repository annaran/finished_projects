<?php


session_start();
ini_set('display_errors', 0);
if( !isset($_SESSION['sUserId']) && $_SESSION['sUserId'] != '12345678' ){
  header('Location: login');
}

if( empty( $_POST['newStatus'] ) ){ sendResponse(-1, __LINE__, 'Status is missing'); }
if( empty( $_POST['accountId'] ) ){ sendResponse(-1, __LINE__, 'Account Id is missing'); }



$sUserId = $_SESSION['sUserId'];
//$sUserId = '17444444';


$sData = file_get_contents('../data/clients.json');
$jData = json_decode( $sData );

if( $jData == null){ sendResponse(-1, __LINE__, 'Cannot convert data to JSON');  }

$jInnerData = $jData->data;

$sAccountId = $_POST['accountId'];

if($jInnerData->$sUserId->accounts->$sAccountId->status == 2)
{
  sendResponse(0, __LINE__, 'Account is already blocked');
}

$jInnerData->$sUserId->accounts->$sAccountId->status = $_POST['newStatus']; 

$sData = json_encode( $jData, JSON_PRETTY_PRINT );
if( $sData == null   ){ sendResponse(-1, __LINE__,'sData is null'); }
file_put_contents( '../data/clients.json', $sData );


sendResponse( 1, __LINE__ , 'Account has been blocked');


// **************************************************
function sendResponse($iStatus, $iLineNumber, $sMessage){
  echo '{"status":'.$iStatus.', "code":'.$iLineNumber.',"message":"'.$sMessage.'"}';
  exit;
}

// **************************************************













