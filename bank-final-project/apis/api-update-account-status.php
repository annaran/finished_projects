<?php

session_start();
if( !isset($_SESSION['sUserId']) && $_SESSION['sUserId'] != '12345678' ){
  header('Location: login');
}

ini_set('display_errors', 0);

if( empty( $_POST['newStatus'] ) ){ sendResponse(-1, __LINE__, 'Status is missing'); }
if( empty( $_POST['accountId'] ) ){ sendResponse(-1, __LINE__, 'Account Id is missing'); }
if( empty( $_POST['clientId'] ) ){ sendResponse(-1, __LINE__, 'Client Id is missing'); }


$sUserId = $_SESSION['sUserId'];
//$sUserId = '17444444';


$sData = file_get_contents('../data/clients.json');
$jData = json_decode( $sData );

if( $jData == null){ sendResponse(-1, __LINE__, 'Cannot convert data to JSON');  }

$jInnerData = $jData->data;

$sAccountId = $_POST['accountId'];
$sClientId = $_POST['clientId'];

if($jInnerData->$sClientId->accounts->$sAccountId->status == $_POST['newStatus'] )
{
  sendResponse(0, __LINE__,'This account already has this status');
}

$jInnerData->$sClientId->accounts->$sAccountId->status = $_POST['newStatus']; 

$sData = json_encode( $jData, JSON_PRETTY_PRINT );
if( $sData == null   ){ sendResponse(-1, __LINE__,'sdata is null'); }
file_put_contents( '../data/clients.json', $sData );


sendResponse( 1, __LINE__ , 'Account status has been updated');


// **************************************************
function sendResponse($iStatus, $iLineNumber, $sMessage){
  echo '{"status":'.$iStatus.', "code":'.$iLineNumber.',"message":"'.$sMessage.'"}';
  exit;
}

// **************************************************













