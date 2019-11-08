<?php
session_start();
if( !isset($_SESSION['sUserId'] ) ){
  header('Location: login');
}

ini_set('display_errors', 0);


if( empty( $_GET['amount'] ) ){ sendResponse(-1, __LINE__, 'Amount is missing'); }
if( empty( $_GET['noOfYears'] ) ){ sendResponse(-1, __LINE__, 'Years are missing'); }



$sUserId = $_SESSION['sUserId'];
//$sUserId = '17444444';

// validate amount
$iAmount = $_GET['amount'];
if( empty($iAmount) ){ sendResponse(0, __LINE__,'Amount cannot be empty');  }
if( !ctype_digit($iAmount)  ){ sendResponse(0, __LINE__,'Amount must be numeric');  }

// validate years
$iReturnDate = $_GET['noOfYears'];
if( empty($iReturnDate) ){ sendResponse(0, __LINE__,'Years cannot be empty');  }
if( !ctype_digit($iReturnDate)  ){ sendResponse(0, __LINE__,'Years must be numeric');  }
if( $iReturnDate < 1 ){ sendResponse(0, __LINE__,'Number of years must be between 1 and 30'); }
if( $iReturnDate > 30 ){ sendResponse(0, __LINE__, 'Number of years must be between 1 and 30'); }


$sData = file_get_contents('../data/clients.json');
$jData = json_decode( $sData );

if( $jData == null){ sendResponse(-1, __LINE__, 'Cannot convert data to JSON');  }

$jInnerData = $jData->data;

$jLoan = new stdClass();
$jLoan->amountTotal = $iAmount;
$jLoan->amountLeftToPay = $iAmount;
$jLoan->paybackDate = date('d-m-Y', strtotime('+'.$iReturnDate.' years'));
$jLoan->status = 0;
$jLoan->paybackStatus = 0;
$sLoanId = uniqid();
$jInnerData->$sUserId->loans->$sLoanId = $jLoan; 


$sData = json_encode( $jData, JSON_PRETTY_PRINT );
if( $sData == null   ){ sendResponse(0, __LINE__,'sdata is null'); }
file_put_contents( '../data/clients.json', $sData );


sendResponse( 1, __LINE__ , 'Your application has been sent');


// **************************************************
function sendResponse($iStatus, $iLineNumber, $sMessage){
  echo '{"status":'.$iStatus.', "code":'.$iLineNumber.',"message":"'.$sMessage.'"}';
  exit;
}

// **************************************************













