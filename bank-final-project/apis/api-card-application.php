<?php

session_start();
if (!isset($_SESSION['sUserId'])) {
    header('Location: login');
}
ini_set('display_errors', 0);


if (empty($_GET['type1'])) {
    sendResponse(-1, __LINE__, 'Type1 is missing');
}
if (empty($_GET['type2'])) {
    sendResponse(-1, __LINE__, 'Type2 is missing');
}


$sUserId = $_SESSION['sUserId'];
//$sUserId = '17444444';

// validate type1
$sType1 = $_GET['type1'] ?? '';
if (empty($sType1)) {
    sendResponse(0, __LINE__, 'Type cannot be empty');
}
if (strtolower($sType1) != 'debit' && strtolower($sType1) != 'credit') {
    sendResponse(0, __LINE__, 'Card type must be either debit or credit');
}

// validate type2
$sType2 = $_GET['type2'] ?? '';
if (empty($sType2)) {
    sendResponse(0, __LINE__, 'Type cannot be empty');
}
if (strtolower($sType2) != 'visa' && strtolower($sType2) != 'mastercard') {
    sendResponse(0, __LINE__, 'Card type must be either visa or mastercard');
}


$sData = file_get_contents('../data/clients.json');
$jData = json_decode($sData);

if ($jData == null) {
    sendResponse(-1, __LINE__, 'Cannot convert data to JSON');
}

$jInnerData = $jData->data;

$jCard = new stdClass();
if ($sType1 == 'debit') {
    $jCard->pin = rand(1000, 9999);
} else {
    $jCard->pin = '';
}
$jCard->cvv2 = rand(100, 999);
$jCard->cardType1 = $sType1;
$jCard->cardType2 = $sType2;
$jCard->expiryDate = date('d-m-Y', strtotime('+3 years')); //cards are valid for 3 years
$jCard->status = 1;
$sCardNumber = (string)rand(10000000, 99999999) . (string)rand(10000000, 99999999);
$jInnerData->$sUserId->cards->$sCardNumber = $jCard;


$sData = json_encode($jData, JSON_PRETTY_PRINT);
if ($sData == null) {
    sendResponse(0, __LINE__, 'sData is null');
}
file_put_contents('../data/clients.json', $sData);


sendResponse(1, __LINE__, 'Your card has been added');


// **************************************************
function sendResponse($iStatus, $iLineNumber, $sMessage)
{
    echo '{"status":' . $iStatus . ', "code":' . $iLineNumber . ',"message":"' . $sMessage . '"}';
    exit;
}

// **************************************************













