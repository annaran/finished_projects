<?php


ini_set('display_errors', 0);
ini_set('user_agent', 'any');

$sData = file_get_contents('../data/clients.json');
$jData = json_decode( $sData );
if( $jData == null ){ fnvSendResponse(-1, __LINE__, 'Cannot convert the data file to json'); }
$jInnerData = $jData->data;


$sPhone = $_GET['phone'];
if( strlen($sPhone) != 8 ){ sendResponse(-1, __LINE__, 'Phone must be 8 characters in length'); }
if( !ctype_digit($sPhone)  ){ sendResponse(-1, __LINE__, 'Phone can only contain numbers');  }

$iAmount = $_GET['amount'];
if( empty($iAmount) ){ sendResponse(0, __LINE__,'Amount cannot be empty');  }
if( !ctype_digit($iAmount)  ){ sendResponse(0, __LINE__,'Amount must be numeric');  }

$sMessage = $_GET['message'];
if( empty($sMessage) ){ sendResponse(0, __LINE__,'Message cannot be empty');  }



if( !$jInnerData->$sPhone ){   
  fnvSendResponse(0, __LINE__, 'Phone not registered in Anna\'s Bank');
}


// this is reception of transfer ************************************
$sDefaultAccount = $jInnerData->$sPhone->defaultTransferAccount;
$iBalance = $jInnerData->$sPhone->accounts->$sDefaultAccount->balance;

$iNewBalance = $iBalance + $iAmount;
$jInnerData->$sPhone->accounts->$sDefaultAccount->balance = $iNewBalance;


$jTransaction->date = date("d-m-Y H:i:s");
$jTransaction->amount = $iAmount;
$jTransaction->message = $sMessage;
$jTransaction->fromPhone = 'Transfer from foreign bank';
$sTransactionUniqueId = uniqid();

$jInnerData->$sPhone->transactionsNotRead->$sTransactionUniqueId = $jTransaction;
$jInnerData->$sPhone->transactions->$sTransactionUniqueId = $jTransaction;

$sData = json_encode( $jData, JSON_PRETTY_PRINT );
if( $sData == null   ){ sendResponse(0, __LINE__,'sData is null'); }
file_put_contents( '../data/clients.json', $sData );



fnvSendResponse(1, __LINE__, 'Transaction success from Anna\'s Bank');


// **************************************************
function fnvSendResponse( $iStatus, $iLineNumber, $sMessage ){
  echo '{"status":'.$iStatus.', "code":'.$iLineNumber.', "message":"'.$sMessage.'"}';
  exit;
}