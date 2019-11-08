<?php


session_start();
if (!isset($_SESSION['sUserId']) && $_SESSION['sUserId'] != '12345678') {
    header('Location: login');
}

ini_set('display_errors', 0);


if (empty($_POST['newStatus'])) {
    sendResponse(-1, __LINE__, 'Status is missing');
}
if (empty($_POST['loanId'])) {
    sendResponse(-1, __LINE__, 'Account Id is missing');
}
if (empty($_POST['clientId'])) {
    sendResponse(-1, __LINE__, 'Client Id is missing');
}


$sUserId = $_SESSION['sUserId'];
//$sUserId = '17444444';


$sData = file_get_contents('../data/clients.json');
$jData = json_decode($sData);

if ($jData == null) {
    sendResponse(-1, __LINE__, 'Cannot convert data to JSON');
}

$jInnerData = $jData->data;

$sLoanId = $_POST['loanId'];
$sClientId = $_POST['clientId'];

//check if loan has status 'pending'
$iCurrentLoanStatus = $jInnerData->$sClientId->loans->$sLoanId->status;
if ($iCurrentLoanStatus != 0) {
    sendResponse(0, __LINE__, 'This loan has already been rejected or approved');
}


$jInnerData->$sClientId->loans->$sLoanId->status = $_POST['newStatus'];

//give money to client
if ($_POST['newStatus'] == 1) {
    $iRequestedLoan = $jInnerData->$sClientId->loans->$sLoanId->amountTotal;
    $sDefaultAccount = $jInnerData->$sClientId->defaultTransferAccount;
    $jInnerData->$sClientId->accounts->$sDefaultAccount->balance = $jInnerData->$sClientId->accounts->$sDefaultAccount->balance + $iRequestedLoan;


//add to transaction log
    $jTransaction->date = date("d-m-Y H:i:s");
    $jTransaction->amount = $iRequestedLoan;
    $jTransaction->fromPhone = 'Admin';
    $sTransactionUniqueId = uniqid();
    $jTransaction->message = 'Your loan request has been approved';
    $jInnerData->$sClientId->transactionsNotRead->$sTransactionUniqueId = $jTransaction;
    $jInnerData->$sClientId->transactions->$sTransactionUniqueId = $jTransaction;


}


$sData = json_encode($jData, JSON_PRETTY_PRINT);
if ($sData == null) {
    sendResponse(-1, __LINE__, 'sdata is null');
}
file_put_contents('../data/clients.json', $sData);


sendResponse(1, __LINE__, 'Loan status has been updated');


// **************************************************
function sendResponse($iStatus, $iLineNumber, $sMessage)
{
    echo '{"status":' . $iStatus . ', "code":' . $iLineNumber . ',"message":"' . $sMessage . '"}';
    exit;
}

// **************************************************













