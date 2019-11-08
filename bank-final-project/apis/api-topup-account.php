<?php


session_start();
if( !isset($_SESSION['sUserId']) && $_SESSION['sUserId'] != '12345678' ){
  header('Location: login');
}

ini_set('display_errors', 0);


if( empty( $_POST['amount'] ) ){ sendResponse(0, __LINE__, 'Amount is missing',''); }
if( !ctype_digit($_POST['amount'])  ){ sendResponse(0, __LINE__,'Amount must be numeric','');  }
if( empty( $_POST['accountId'] ) ){ sendResponse(0, __LINE__, 'Account Id is missing',''); }
if( empty( $_POST['clientId'] ) ){ sendResponse(0, __LINE__, 'Client Id is missing',''); }


$sUserId = $_SESSION['sUserId'];
//$sUserId = '17444444';


$sData = file_get_contents('../data/clients.json');
$jData = json_decode( $sData );

if( $jData == null){ sendResponse(-1, __LINE__, 'Cannot convert data to JSON','');  }

$jInnerData = $jData->data;

$sAccountId = $_POST['accountId'];
$sClientId = $_POST['clientId'];
$jInnerData->$sClientId->accounts->$sAccountId->balance += $_POST['amount']; 
$iNewBalance = $jInnerData->$sClientId->accounts->$sAccountId->balance;

//add to list of transactions
$jTransaction->date = date("d-m-Y H:i:s");
$jTransaction->amount = $_POST['amount'];
$jTransaction->fromPhone = 'Admin';
$jTransaction->message = 'Admin sent you a gift!';
$sTransactionUniqueId = uniqid();

$jInnerData->$sClientId->transactionsNotRead->$sTransactionUniqueId = $jTransaction;
$jInnerData->$sClientId->transactions->$sTransactionUniqueId = $jTransaction;



$sData = json_encode( $jData, JSON_PRETTY_PRINT );
if( $sData == null   ){ sendResponse(0, __LINE__,'sdata is null',''); }
file_put_contents( '../data/clients.json', $sData );


sendResponse( 1, __LINE__ , 'Account top-up successful',$iNewBalance);


// **************************************************
function sendResponse($iStatus, $iLineNumber, $sMessage,$iNewBalance){
  echo '{"status":'.$iStatus.', "code":'.$iLineNumber.',"message":"'.$sMessage.'","currentBalance":'.$iNewBalance.'}';
  exit;
}

// **************************************************













