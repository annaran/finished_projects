<?php

session_start();
ini_set('display_errors', 0);
//require_once '../connect.php';

$sCar = $_GET['sCar'] ?? '';
//$iHours = $_GET['iHours'] ?? '';
if (empty($sCar)) {
    sendResponse(0, __LINE__, 'sCar is empty', '');
}




$sUserId = $_SESSION['sUserId'];
//$sUserId = '17444444';


$sData = file_get_contents('../data/data.json');
$jData = json_decode( $sData );

if( $jData == null){ sendResponse(-1, __LINE__, 'Cannot convert data to JSON','');  }

$jInnerData = $jData->data;

$iHours = $jInnerData->$sUserId->tempRental->hours;

if($sCar == 'Car 1')
{
    $iTotal = $iHours * 200;
}

if($sCar == 'Car 2')
{
    $iTotal = $iHours * 300;
}


if($sCar == 'Car 3')
{
    $iTotal = $iHours * 220;
}









$jInnerData->$sUserId->tempRental->car = $sCar;
$jInnerData->$sUserId->tempRental->total = $iTotal;

$sData = json_encode( $jData, JSON_PRETTY_PRINT );
if( $sData == null   ){ sendResponse(-1, __LINE__,'sData is null',''); }
file_put_contents( '../data/data.json', $sData );





sendResponse(1, __LINE__, 'car updated', '');


// **************************************************

function sendResponse($iStatus, $iLineNumber, $sMessage, $sEmail)
{
    echo '{"status":' . $iStatus . ', "code":' . $iLineNumber . ',"message":"' . $sMessage . '", "user":"' . $sEmail . '"}';
    exit;
}
























