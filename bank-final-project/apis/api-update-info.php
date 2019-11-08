<?php

session_start();
if( !isset($_SESSION['sUserId'] ) ){
  header('Location: login');
}

ini_set('display_errors', 0);


if( empty( $_POST['txtUpdateInfoCurrentPassword'] ) ){ sendResponse(-1, __LINE__, 'Current password is missing'); }
if( empty( $_POST['txtUpdateInfoNewPassword'] ) ){ sendResponse(-1, __LINE__, 'New password is missing'); }
if( empty( $_POST['txtUpdateInfoRepeatNewPassword'] ) ){ sendResponse(-1, __LINE__, 'Repeated password is missing'); }


$sUserId = $_SESSION['sUserId'];
//$sUserId = '17444444';

// validate current password
$sCurrentPassword = $_POST['txtUpdateInfoCurrentPassword'] ?? '';
if( empty($sCurrentPassword) ){ sendResponse(0, __LINE__,'Password cannot be empty');  }
if( strlen($sCurrentPassword) < 4 ){ sendResponse(0, __LINE__,'Password has to be at least 4 characters long'); }
if( strlen($sCurrentPassword) > 50 ){ sendResponse(0, __LINE__,'Password too long'); }

// validate new password
$sNewPassword = $_POST['txtUpdateInfoNewPassword'] ?? '';
if( empty($sNewPassword) ){ sendResponse(0, __LINE__,'Password cannot be empty');  }
if( strlen($sNewPassword) < 4 ){ sendResponse(0, __LINE__,'Password has to be at least 4 characters long'); }
if( strlen($sNewPassword) > 50 ){ sendResponse(0, __LINE__,'Password too long'); }

// validate confirm new password
$sConfirmNewPassword = $_POST['txtUpdateInfoRepeatNewPassword'] ?? '';
if( empty($sConfirmNewPassword) ){ sendResponse(0, __LINE__, 'Confirm new pasword');  }
if( $sNewPassword != $sConfirmNewPassword ){ sendResponse(0, __LINE__,'Passwords do not match');  }

$sData = file_get_contents('../data/clients.json');
$jData = json_decode( $sData );

if( $jData == null){ sendResponse(-1, __LINE__, 'Cannot convert data to JSON');  }

$jInnerData = $jData->data;


if(!password_verify( $sCurrentPassword, $jInnerData->$sUserId->password ))
{
  sendResponse(0, __LINE__, 'The password you entered does not match the one in the database.');
}



$jInnerData->$sUserId->password = password_hash( $sNewPassword, PASSWORD_DEFAULT );
$sData = json_encode( $jData, JSON_PRETTY_PRINT );
if( $sData == null   ){ sendResponse(0, __LINE__,'sdata is null'); }
file_put_contents( '../data/clients.json', $sData );


sendResponse( 1, __LINE__ , 'Password changed successfuly');


// **************************************************
function sendResponse($iStatus, $iLineNumber, $sMessage){
  echo '{"status":'.$iStatus.', "code":'.$iLineNumber.',"message":"'.$sMessage.'"}';
  exit;
}

// **************************************************













