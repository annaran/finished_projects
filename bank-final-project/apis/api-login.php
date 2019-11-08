<?php

session_start();
ini_set('display_errors', 0);

$sPhone = $_POST['txtLoginPhone'] ?? '';
if( empty($sPhone) ){ sendResponse(0, __LINE__,'Phone number is empty','');  }
if( strlen($sPhone) != 8 ){ sendResponse(0, __LINE__,'Phone must me 8 digit number',''); }
if( !ctype_digit($sPhone)  ){ sendResponse(0, __LINE__,'Phone must me 8 digit number','');  }

$sPassword = $_POST['txtLoginPassword'] ?? '';
if( empty($sPassword) ){ sendResponse(0, __LINE__,'Password is empty','');  }
if( strlen($sPassword) < 4 ){ sendResponse(0, __LINE__,'Password must be at least 4 characters long',''); }
if( strlen($sPassword) > 50 ){ sendResponse(0, __LINE__,'Password is too long',''); }

$sData = file_get_contents('../data/clients.json');
$jData = json_decode($sData);
if( $jData == null ){ sendResponse(0, __LINE__,'sData is null',''); }
$jInnerData = $jData->data;

//check if phone is registered in the bank
if(!$jInnerData->$sPhone)
{
    sendResponse(0, __LINE__,'Phone not registered','');
}

if( !password_verify( $sPassword, $jInnerData->$sPhone->password ) || $jInnerData->$sPhone->timeBlocked - time() + 15  > 0 ){

//if user failed to log in or is blocked for 60s
if( $jInnerData->$sPhone->wrongLoginCounter<3) 
{ 
  $jInnerData->$sPhone->wrongLoginCounter = $jInnerData->$sPhone->wrongLoginCounter + 1;   
  if($jInnerData->$sPhone->wrongLoginCounter>2)
  {
    $jInnerData->$sPhone->timeBlocked = time();
  }
  $sData = json_encode( $jData, JSON_PRETTY_PRINT );
  file_put_contents( '../data/clients.json', $sData );  
  sendResponse(0, __LINE__,'Failed to log in, attempt no '.$jInnerData->$sPhone->wrongLoginCounter,'');

 }  
 elseif( $jInnerData->$sPhone->wrongLoginCounter>2 && $jInnerData->$sPhone->timeBlocked - time() + 15  > 0 )
    {
    //if user failed to log in 3 times or more
      $sTimeRemaining = $jInnerData->$sPhone->timeBlocked - time() + 15;
      $sData = json_encode( $jData,JSON_PRETTY_PRINT );
      file_put_contents( '../data/clients.json', $sData );  
      sendResponse(0, __LINE__,'Login blocked, wait '.$sTimeRemaining. ' seconds to try again.','' );

    } else 
    {
      //if 60s passed after last failed log in attempt
      $jInnerData->$sPhone->wrongLoginCounter = $jInnerData->$sPhone->wrongLoginCounter + 1;
      $jInnerData->$sPhone->timeBlocked = time();
      $sTimeRemaining = $jInnerData->$sPhone->timeBlocked - time() + 15;
      $sData = json_encode( $jData, JSON_PRETTY_PRINT );
      file_put_contents( '../data/clients.json', $sData );
      sendResponse(0, __LINE__,'Login blocked, wait '.$sTimeRemaining. ' seconds to try again.','' );
    }
} else
{
  //if log in successful
  $jInnerData->$sPhone->wrongLoginCounter = 0;
  $jInnerData->$sPhone->timeBlocked = 0;
  $sData = json_encode( $jData, JSON_PRETTY_PRINT );
  file_put_contents( '../data/clients.json', $sData ); 
  $_SESSION['sUserId'] = $sPhone;
  sendResponse(1, __LINE__,'Login successful ',$sPhone);
}




// **************************************************

function sendResponse($iStatus, $iLineNumber, $sMessage,$sPhone){
  echo '{"status":'.$iStatus.', "code":'.$iLineNumber.',"message":"'.$sMessage.'", "user":"'.$sPhone.'"}';
  exit;
}
























