<?php

session_start();
ini_set('display_errors', 0);
//require_once '../connect.php';

$sCompany = $_GET['sCompany'] ?? '';
if (empty($sCompany)) {
    sendResponse(0, __LINE__, 'sCompany is empty', '');
}


$sUserId = $_SESSION['sUserId'];
//$sUserId = '17444444';


$sData = file_get_contents('../data/data.json');
$jData = json_decode( $sData );

if( $jData == null){ sendResponse(-1, __LINE__, 'Cannot convert data to JSON');  }

$jInnerData = $jData->data;





$jInnerData->$sUserId->tempRental->company = $sCompany;

$sData = json_encode( $jData, JSON_PRETTY_PRINT );
if( $sData == null   ){ sendResponse(-1, __LINE__,'sData is null'); }
file_put_contents( '../data/data.json', $sData );





sendResponse(1, __LINE__, 'company updated', '');


// **************************************************

function sendResponse($iStatus, $iLineNumber, $sMessage, $sEmail)
{
    echo '{"status":' . $iStatus . ', "code":' . $iLineNumber . ',"message":"' . $sMessage . '", "user":"' . $sEmail . '"}';
    exit;
}
























