<?php


ini_set('user_agent', 'any');
ini_set('display_errors', 0);


if( empty( $_GET['phone'] ) ){ sendResponse(0, __LINE__, 'Phone missing'); }


$sPhone = $_GET['phone'] ?? '';
if( strlen($sPhone) != 8 ){ sendResponse(0, __LINE__, 'Phone must be 8 characters long'); }
if( !ctype_digit($sPhone)  ){ sendResponse(0, __LINE__, 'Phone can only contain numbers');  }


$sData = file_get_contents('../data/clients.json');
$jData = json_decode( $sData );

if( $jData == null){ sendResponse(0, __LINE__, 'Cannot convert data to JSON');  }

$jInnerData = $jData->data;

if( !$jInnerData->$sPhone ){ 
  sendResponse( 0, __LINE__ , 'Phone is not registered in this bank' );
}

$email = $jInnerData->$sPhone->email;



$sTempPassword = uniqid();
//$sTempPassword = "0000";
$msg = "Your new passowrd is ".$sTempPassword.". It is recommended that you change your password after successful log in.";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

$jInnerData->$sPhone->password = password_hash( $sTempPassword, PASSWORD_DEFAULT );
$sData = json_encode( $jData, JSON_PRETTY_PRINT );
if( $sData == null   ){ sendResponse(0, __LINE__,'sData is null'); }
file_put_contents( '../data/clients.json', $sData );


// send email
mail("annran.box@gmail.com","pass recovery",$msg);
mail($email,'You requested password reset',$msg);
sendResponse( 1, __LINE__ , 'Email with new password has been sent to '.$email );


// **************************************************
function sendResponse($iStatus, $iLineNumber, $sMessage){
  echo '{"status":'.$iStatus.', "code":'.$iLineNumber.',"message":"'.$sMessage.'"}';
  exit;
}

// **************************************************













