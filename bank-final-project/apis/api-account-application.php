<?php

session_start();
if (!isset($_SESSION['sUserId'])) {
    header('Location: login');
}

ini_set('display_errors', 0);


if (empty($_GET['type'])) {
    sendResponse(-1, __LINE__, 'Type is missing');
}
if (empty($_GET['currency'])) {
    sendResponse(-1, __LINE__, 'Currency is missing');
}


$sUserId = $_SESSION['sUserId'];
//$sUserId = '17444444';

// validate type1
$sType = $_GET['type'] ?? '';
if (empty($sType)) {
    sendResponse(0, __LINE__, 'Type is missing');
}
if (strtolower($sType) != 'savings' && strtolower($sType) != 'checking' && strtolower($sType) != 'standard') {
    sendResponse(0, __LINE__, 'Type must be standard, savings or checking');
}


// validate type2
$sCurrency = $_GET['currency'] ?? '';
if (empty($sCurrency)) {
    sendResponse(0, __LINE__, 'Currency is missing');
}
if (strtolower($sCurrency) != 'usd' && strtolower($sCurrency) != 'dkk') {
    sendResponse(0, __LINE__, 'Currency must be dkk or usd');
}


$sData = file_get_contents('../data/clients.json');
$jData = json_decode($sData);

if ($jData == null) {
    sendResponse(-1, __LINE__, 'Cannot convert data to JSON');
}

$jInnerData = $jData->data;

$jAccount = new stdClass();
$jAccount->balance = 0;
$jAccount->type = $sType;
$jAccount->currency = $sCurrency;
$jAccount->status = 1;
$sAccountId = (string)rand(1000, 9999) . (string)rand(10000000, 99999999);
$jInnerData->$sUserId->accounts->$sAccountId = $jAccount;


$sData = json_encode($jData, JSON_PRETTY_PRINT);
if ($sData == null) {
    sendResponse(0, __LINE__, 'sData is null');
}
file_put_contents('../data/clients.json', $sData);


sendResponse(1, __LINE__, 'Your account has been added');


// **************************************************
function sendResponse($iStatus, $iLineNumber, $sMessage)
{
    echo '{"status":' . $iStatus . ', "code":' . $iLineNumber . ',"message":"' . $sMessage . '"}';
    exit;
}

// **************************************************













