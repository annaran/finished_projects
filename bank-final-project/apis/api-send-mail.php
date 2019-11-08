<?php

session_start();
if( !isset($_SESSION['sUserId'] ) ){
  header('Location: login');
}

ini_set('user_agent', 'any');
ini_set('display_errors', 0);


$sMessage = $_GET['message'] ?? '';
if( empty($sMessage) ){ sendResponse(0, __LINE__,'Message cannot be empty');  }

$sSubject = $_GET['subject'] ?? '';
if( empty($sSubject) ){ sendResponse(0, __LINE__,'Subject cannot be empty');  }




$sData = file_get_contents('../data/clients.json');
$jData = json_decode( $sData );

$msg = $sMessage;

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// send email
foreach($jData->data as $sClientId => $jClient)
      {

        mail($jClient->email,$sSubject,$msg);

      }


sendResponse( 1, __LINE__ , 'Emails have been sent' );


// **************************************************
function sendResponse($iStatus, $iLineNumber, $sMessage){
  echo '{"status":'.$iStatus.', "code":'.$iLineNumber.',"message":"'.$sMessage.'"}';
  exit;
}

// **************************************************













