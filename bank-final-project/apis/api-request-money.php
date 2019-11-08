<?php

session_start();
if( !isset($_SESSION['sUserId'] ) ){
  header('Location: login');
}

ini_set('display_errors', 0);


if( empty( $_GET['requestFromPhone'] ) ){ sendResponse(-1, __LINE__, 'Phone number is missing'); }
if( empty( $_GET['requestAmount'] ) ){ sendResponse(-1, __LINE__, 'Amount is missing'); }
if( empty( $_GET['requestMessage'] ) ){ sendResponse(-1, __LINE__, 'Message is missing'); }


$sUserId = $_SESSION['sUserId'];
//$sUserId = '17444444';


// validate phone
$sPhone = $_GET['requestFromPhone'] ?? '';
if( empty($sPhone) ){ sendResponse(0, __LINE__,'Phone cannot be empty');  }
if( strlen($sPhone) != 8 ){ sendResponse(0, __LINE__,'Phone must be a 8 digit number'); }
if( intval($sPhone) < 10000000 ){ sendResponse(0, __LINE__,'Phone must be a 8 digit number'); }
if( intval($sPhone) > 99999999 ){ sendResponse(0, __LINE__,'Phone must be a 8 digit number'); }



// validate amount
$iAmount = $_GET['requestAmount'] ?? '';
if( empty($iAmount) ){ sendResponse(0, __LINE__,'Amount cannot be empty');  }
if( !ctype_digit($iAmount)  ){ sendResponse(0, __LINE__,'Amount must be numeric');  }

// validate message
$sMessage = $_GET['requestMessage'] ?? '';
if( empty($sMessage) ){ sendResponse(0, __LINE__,'Message cannot be empty');  }


$sData = file_get_contents('../data/clients.json');
$jData = json_decode( $sData );

if( $jData == null){ sendResponse(-1, __LINE__, 'Cannot convert data to JSON');  }

$jInnerData = $jData->data;

if( !$jInnerData->$sPhone ){ 
  sendResponse( 0, __LINE__ , 'Phone not registered in Anna\'s Bank'  );
}

$jMoneyRequest = new stdClass();
$jMoneyRequest->amount = $iAmount;
$jMoneyRequest->fromPhone = $sUserId;
$jMoneyRequest->message = $sMessage;
$jMoneyRequest->status = 0;
$sMoneyRequestId = uniqid();
$jInnerData->$sPhone->moneyRequests->$sMoneyRequestId = $jMoneyRequest; 


$sData = json_encode( $jData, JSON_PRETTY_PRINT );
if( $sData == null   ){ sendResponse(0, __LINE__,'sData is null'); }
file_put_contents( '../data/clients.json', $sData );


sendResponse( 1, __LINE__ , 'Your money request has been sent');


// **************************************************
function sendResponse($iStatus, $iLineNumber, $sMessage){
  echo '{"status":'.$iStatus.', "code":'.$iLineNumber.',"message":"'.$sMessage.'"}';
  exit;
}

// **************************************************













