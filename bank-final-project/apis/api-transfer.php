<?php
session_start();
if( !isset($_SESSION['sUserId'] ) ){
  header('Location: login');
}

ini_set('display_errors', 0);
ini_set('user_agent', 'any');

if( !isset($_SESSION['sUserId'] ) ){
  sendResponse(-1, __LINE__, 'You must login to use this api');
}



if( empty( $_GET['phone'] ) ){ sendResponse(-1, __LINE__, 'Phone missing'); }
if( empty( $_GET['amount'] ) ){ sendResponse(-1, __LINE__, 'Amount is missing'); }
if( empty( $_GET['message'] ) ){ sendResponse(-1, __LINE__, 'Message is missing'); }


// validate phone
$sPhone = $_GET['phone'] ?? '';
if( strlen($sPhone) != 8 ){ sendResponse(-1, __LINE__, 'Phone must be 8 characters in length'); }
if( !ctype_digit($sPhone)  ){ sendResponse(-1, __LINE__, 'Phone can only contain numbers');  }

// VALIDATE THE MESSAGE
$sMessage = $_GET['message'] ?? '';
if( empty($sMessage) ){ sendResponse(-1, __LINE__,'Message cannot be empty');  }

// Validate amount
$iAmount = $_GET['amount'] ?? '';
if( empty($iAmount) ){ sendResponse(-1, __LINE__,'Amount cannot be empty');  }
if( !ctype_digit($iAmount)  ){ sendResponse(-1, __LINE__,'Amount must be numeric');  }







$sData = file_get_contents('../data/clients.json');
$jData = json_decode( $sData );

$sUserId =  $_SESSION['sUserId'];
$jInnerData = $jData->data;

/* //determining main account number to make transfers
//
$jAccountList = $jInnerData->$sUserId->accounts;
foreach($jAccountList as $sKey => $jAccount)
{
  if($jAccount->type == 'standard')
  {
    $sMainAccount = $sKey;
  }
} */

$sDefaultAccount = $jInnerData->$sUserId->defaultTransferAccount;

if($jInnerData->$sUserId->accounts->$sDefaultAccount->status == 2)
{
    sendResponse(0, __LINE__,'Your default transfer account is blocked.');
}


if($jInnerData->$sUserId->accounts->$sDefaultAccount->balance < $iAmount)
{
  sendResponse(0, __LINE__,'You don\'t have enough money to do this.');
}




if( $jData == null){ sendResponse(-1, __LINE__, 'Cannot convert data to JSON');  }

// this is foreign transfer ************************************



if( !$jInnerData->$sPhone ){ 
  $jListOfBanks = fnjGetListOfBanksFromCentralBank();
  // loop through the list
  // connect to each bank
  foreach( $jListOfBanks as $sKey => $jBank )
  {
    // echo $jBank->url;
    // echo $jBank->key;
    $sUrl = $jBank->url.'/apis/api-handle-transaction?phone='.$sPhone.'&amount='.$iAmount.'&message='.$sMessage;                                       
    // echo $sUrl.'<br>';
    $sBankResponse =  file_get_contents($sUrl);
    $jBankResponse = json_decode($sBankResponse);
  

    if( $jBankResponse->status == 1 && 
        $jBankResponse->code && 
        $jBankResponse->message )
        { 
          //if transfer successful deduct money from logged user
          $jInnerData->$sUserId->accounts->$sDefaultAccount->balance = $jInnerData->$sUserId->accounts->$sDefaultAccount->balance - $iAmount;
          
          $jTransaction->date = date("d-m-Y H:i:s");
          $jTransaction->amount = -$iAmount;
          $jTransaction->message = $sMessage;
          $sTransactionUniqueId = uniqid();
          
          $jInnerData->$sUserId->transactionsNotRead->$sTransactionUniqueId = $jTransaction;
          $jInnerData->$sUserId->transactions->$sTransactionUniqueId = $jTransaction;
          
          $sData = json_encode( $jData, JSON_PRETTY_PRINT );
          if( $sData == null   ){ sendResponse(0, __LINE__,'sData is null'); }
          file_put_contents( '../data/clients.json', $sData );


          sendResponse( 1, __LINE__ , $jBankResponse->message );
        }

  }
  sendResponse( 2, __LINE__ , 'Phone does not exist' );
}



// Continue transfering the money
// Take money from the logged user
// Give it to the corresponding phone 


//echo $InnerData->$sPhone->accounts->$sReceiverDefaultAccount->balance;     
//echo $InnerData->$sUserId->accounts->$sDefaultAccount->balance;


//echo("<script>console.log('PHP: ".$a."');</script>");
//echo("<script>console.log('PHP: ".$b."');</script>");

$jTransactionFrom->date = date("d-m-Y H:i:s");
          $jTransactionFrom->amount = -$iAmount;
          $jTransactionFrom->message = $sMessage;
          $jTransactionTo->date = date("d-m-Y H:i:s");
          $jTransactionTo->amount = $iAmount;
          $jTransactionTo->message = $sMessage;
          $jTransactionTo->fromPhone = $sUserId;
          $sTransactionUniqueId = uniqid();
          
          $jInnerData->$sUserId->transactionsNotRead->$sTransactionUniqueId = $jTransactionFrom;
          $jInnerData->$sUserId->transactions->$sTransactionUniqueId = $jTransactionFrom;

          $jInnerData->$sPhone->transactionsNotRead->$sTransactionUniqueId = $jTransactionTo;
          $jInnerData->$sPhone->transactions->$sTransactionUniqueId = $jTransactionTo;
          

          $sReceiverDefaultAccount = $jInnerData->$sPhone->defaultTransferAccount;
          $iCurrentBalance = $jInnerData->$sUserId->accounts->$sDefaultAccount->balance;
          $iReceiverCurrentBalance = $jInnerData->$sPhone->accounts->$sReceiverDefaultAccount->balance;
          $jInnerData->$sUserId->accounts->$sDefaultAccount->balance = $iCurrentBalance - $iAmount;
          $jInnerData->$sPhone->accounts->$sReceiverDefaultAccount->balance = $iReceiverCurrentBalance + $iAmount;  



          $sData = json_encode( $jData, JSON_PRETTY_PRINT );
          if( $sData == null   ){ sendResponse(0, __LINE__,'sData is null'); }
          file_put_contents( '../data/clients.json', $sData );
          sendResponse( 1, __LINE__ , 'Phone registered locally, transfer successful');


/* 
$sResponse =  file_get_contents('http://localhost:8080/bank/apis/api-handle-transaction.php?phone='.$sPhone.'&amount='.$iAmount.'&message='.$sMessage);
    $jResponse = json_decode($sResponse);
    if( $jResponse->status == 1 && 
        $jResponse->code && 
        $jResponse->message )
        {
          $InnerData->$sUserId->balance = $InnerData->$sUserId->balance - $iAmount; 
          $jTransaction->date = date("d-m-Y H:i:s");
          $jTransaction->amount = -$iAmount;
          $jTransaction->message = $sMessage;
          $sTransactionUniqueId = uniqid();
          
          $jInnerData->$sUserId->transactionsNotRead->$sTransactionUniqueId = $jTransaction;
          $jInnerData->$sUserId->transactions->$sTransactionUniqueId = $jTransaction;
          
          $sData = json_encode( $jData, JSON_PRETTY_PRINT );
          if( $sData == null   ){ sendResponse(0, __LINE__,'sData is null'); }
          file_put_contents( '../data/clients.json', $sData );
          

          sendResponse( 1, __LINE__ , 'Phone registered locally, transfer successful'  );
        } else
        {
          sendResponse( 0, __LINE__ , 'Phone registered locally, failed to transfer'  );
        }
 */

// getListOfBanksFromCentralBank();

// **************************************************
function sendResponse($iStatus, $iLineNumber, $sMessage){
  echo '{"status":'.$iStatus.', "code":'.$iLineNumber.',"message":"'.$sMessage.'"}';
  exit;
}

// **************************************************
function fnjGetListOfBanksFromCentralBank(){
  // get the list of banks
  $sData = file_get_contents('https://ecuaguia.com/central-bank/api-get-list-of-banks.php?key=1111-2222-3333');
  return json_decode($sData);
}













