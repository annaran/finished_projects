<?php

session_start();
if (!isset($_SESSION['sUserId'])) {
    header('Location: login');
}

ini_set('display_errors', 0);


if (empty($_POST['newStatus'])) {
    sendResponse(-1, __LINE__, 'Status is missing');
}
if (empty($_POST['moneyRequestId'])) {
    sendResponse(-1, __LINE__, 'Id is missing');
}


$sUserId = $_SESSION['sUserId'];
//$sUserId = '17444444';


$sData = file_get_contents('../data/clients.json');
$jData = json_decode($sData);

if ($jData == null) {
    sendResponse(-1, __LINE__, 'Cannot convert data to JSON');
}

$jInnerData = $jData->data;

$sMoneyRequestId = $_POST['moneyRequestId'];


//check if request has status 'pending'
$iCurrentRequestStatus = $jInnerData->$sUserId->moneyRequests->$sMoneyRequestId->status;
if ($iCurrentRequestStatus != 0) {
    sendResponse(0, __LINE__, 'This request has already been rejected or approved');
}


$jInnerData->$sUserId->moneyRequests->$sMoneyRequestId->status = $_POST['newStatus'];


//transfer money
if ($_POST['newStatus'] == 1) {
    $sDefaultAccount = $jInnerData->$sUserId->defaultTransferAccount;
    $iRequestedAmount = $jInnerData->$sUserId->moneyRequests->$sMoneyRequestId->amount;

    if ($jInnerData->$sUserId->accounts->$sDefaultAccount->balance < $iRequestedAmount) {
        sendResponse(0, __LINE__, 'You don\'t have enough money');
    }

    if ($jInnerData->$sUserId->accounts->$sDefaultAccount->status != "1") {
        sendResponse(0, __LINE__, 'Your account is not active');
    }

    $jInnerData->$sUserId->accounts->$sDefaultAccount->balance = $jInnerData->$sUserId->accounts->$sDefaultAccount->balance - $iRequestedAmount;
    $sPersonInNeed = $jInnerData->$sUserId->moneyRequests->$sMoneyRequestId->fromPhone;


    //add to transaction log
    $jTransaction->date = date("d-m-Y H:i:s");
    $jTransaction->amount = -$iRequestedAmount;
    $sTransactionUniqueId = uniqid();
    $jTransaction->message = 'You approved money request from ' . $sPersonInNeed;
    $jInnerData->$sUserId->transactionsNotRead->$sTransactionUniqueId = $jTransaction;
    $jInnerData->$sUserId->transactions->$sTransactionUniqueId = $jTransaction;

    $sPersonInNeedDefaultAccount = $jInnerData->$sPersonInNeed->defaultTransferAccount;
    $jInnerData->$sPersonInNeed->accounts->$sPersonInNeedDefaultAccount->balance += $iRequestedAmount;


    //add to transaction log of the requester, with the same transaction id
    $jTransaction2->date = date("d-m-Y H:i:s");
    $jTransaction2->amount = $iRequestedAmount;
    $jTransaction2->message = $sUserId . ' approved your money request';
    $jTransaction2->fromPhone = $sUserId;

    $jInnerData->$sPersonInNeed->transactionsNotRead->$sTransactionUniqueId = $jTransaction2;
    $jInnerData->$sPersonInNeed->transactions->$sTransactionUniqueId = $jTransaction2;

}

$sData = json_encode($jData, JSON_PRETTY_PRINT);
if ($sData == null) {
    sendResponse(0, __LINE__, 'sdata is null');
}
file_put_contents('../data/clients.json', $sData);


sendResponse(1, __LINE__, 'Your request status has been updated');


// **************************************************
function sendResponse($iStatus, $iLineNumber, $sMessage)
{
    echo '{"status":' . $iStatus . ', "code":' . $iLineNumber . ',"message":"' . $sMessage . '"}';
    exit;
}

// **************************************************













