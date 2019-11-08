<?php

session_start();
ini_set('display_errors', 0);

$sEmail = $_POST['txtLoginEmail'] ?? '';
// validate email

if (empty($sEmail)) {
    sendResponse(0, __LINE__, 'Email cannot be empty','');
}
if (!filter_var($sEmail, FILTER_VALIDATE_EMAIL)) {
    sendResponse(0, __LINE__, 'This is not a valid email address','');
}


$sPassword = $_POST['txtLoginPassword'] ?? '';
if( empty($sPassword) ){ sendResponse(0, __LINE__,'Password is empty','');  }
if( strlen($sPassword) < 4 ){ sendResponse(0, __LINE__,'Password must be at least 4 characters long',''); }
if( strlen($sPassword) > 50 ){ sendResponse(0, __LINE__,'Password is too long',''); }

$sData = file_get_contents('../data/data.json');
$jData = json_decode($sData);
if( $jData == null ){ sendResponse(0, __LINE__,'sData is null',''); }
$jInnerData = $jData->data;

//check if phone is registered in the bank
if(!$jInnerData->$sEmail)
{
    sendResponse(0, __LINE__,'Email not registered','');
}

if( !password_verify( $sPassword, $jInnerData->$sEmail->password ) ){
    sendResponse(0, __LINE__,'Password incorrect','');

//if user failed to log in or is blocked for 60s

} else
{
    //if log in successful

    $_SESSION['sUserId'] = $sEmail;
    sendResponse(1, __LINE__,'Login successful ','');
}




// **************************************************

function sendResponse($iStatus, $iLineNumber, $sMessage,$sEmail){
    echo '{"status":'.$iStatus.', "code":'.$iLineNumber.',"message":"'.$sMessage.'", "user":"'.$sEmail.'"}';
    exit;
}
























