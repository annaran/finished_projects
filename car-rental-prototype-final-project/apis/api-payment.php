<?php

session_start();
ini_set('display_errors', 0);

$sUserId = $_SESSION['sUserId'];
$iCardNumber = $_POST['cardNumber'] ;
$iMonth = $_POST['expiryMonth'] ;
$iYear = $_POST['expiryYear'] ;
$iCv = $_POST['cvCode'] ;
$bRemember = $_POST['checkbox-remember'] ;




//validate
if( empty($iCardNumber) ){ sendResponse(0, __LINE__,'Card number cannot be empty','');  }
if( strlen($iCardNumber) != 16 ){ sendResponse(0, __LINE__,'Card number must be 16 digit long number',''); }
if( intval($iCardNumber) < 0000000000000001 ){ sendResponse(0, __LINE__,'Card number must be 16 digit long number',''); }
if( intval($iCardNumber) > 9999999999999999 ){ sendResponse(0, __LINE__,'Card number must be 16 digit long number',''); }


if( empty($iMonth) ){ sendResponse(0, __LINE__,'Month cannot be empty','');  }
if( strlen($iMonth) != 2 ){ sendResponse(0, __LINE__,'Month must be 2 digit long number',''); }
if( intval($iMonth) < 1 ){ sendResponse(0, __LINE__,'Month must be between 01 - 12',''); }
if( intval($iMonth) > 12 ){ sendResponse(0, __LINE__,'Month must be between 01 - 12',''); }
if(!is_numeric($iMonth)){ sendResponse(0, __LINE__,'Month must be numeric',''); }


if( empty($iYear) ){ sendResponse(0, __LINE__,'Year cannot be empty','');  }
if( strlen($iYear) != 2 ){ sendResponse(0, __LINE__,'Year must be 2 digit long number',''); }
if( intval($iYear) < 0 ){ sendResponse(0, __LINE__,'Year must be between 00 - 99',''); }
if( intval($iYear) > 99 ){ sendResponse(0, __LINE__,'Year must be between 00 - 99',''); }
if(!is_numeric($iYear)){ sendResponse(0, __LINE__,'Year must be numeric',''); }


if( empty($iCv) ){ sendResponse(0, __LINE__,'CV code cannot be empty','');  }
if( strlen($iCv) != 3 ){ sendResponse(0, __LINE__,'CV code must be 3 digit long number',''); }
if( intval($iCv) < 0 ){ sendResponse(0, __LINE__,'CV code must be 3 digit long number',''); }
if( intval($iCv) > 999 ){ sendResponse(0, __LINE__,'CV code must be 3 digit long number',''); }
if(!is_numeric($iCv)){ sendResponse(0, __LINE__,'CV code must be numeric',''); }



$sData = file_get_contents('../data/data.json');
$jData = json_decode($sData);
if( $jData == null ){ sendResponse(0, __LINE__,'sData is null',''); }
$jInnerData = $jData->data;


//save payment details if checkbox is checked
if(isset($_POST['checkbox-remember'])){

    $jInnerData->$sUserId->paymentDetails->cardNo = $iCardNumber;
    $jInnerData->$sUserId->paymentDetails->expirationMonth = $iMonth;
    $jInnerData->$sUserId->paymentDetails->expirationYear = $iYear;
    $jInnerData->$sUserId->paymentDetails->CVV = $iCv;

}


//load temp rental
$jTempRental = $jInnerData->$sUserId->tempRental;



// save new rental
$jRental = new stdClass();

$jRental->total = $jTempRental->total;
$jRental->hours = $jTempRental->hours;
$jRental->date = $jTempRental->date;
$jRental->car = $jTempRental->car; //cards are valid for 3 years
$jRental->company = $jTempRental->company;
$jRental->location = $jTempRental->location;
$sRentalId = (string)rand(10000000, 99999999);
$jInnerData->$sUserId->rentals->$sRentalId = $jRental;


//clear temp rental
$jTempRental->total = "";
$jTempRental->hours = "";
$jTempRental->date = "";
$jTempRental->car = "";
$jTempRental->company = "";
$jTempRental->location = "";




$sData = json_encode( $jData, JSON_PRETTY_PRINT );
if( $sData == null   ){ sendResponse(-1, __LINE__,'sData is null'); }
file_put_contents( '../data/data.json', $sData );


sendResponse(1, __LINE__, 'Payment successful ', '');


// **************************************************

function sendResponse($iStatus, $iLineNumber, $sMessage, $sEmail)
{
    echo '{"status":' . $iStatus . ', "code":' . $iLineNumber . ',"message":"' . $sMessage . '", "user":"' . $sEmail . '"}';
    exit;
}
























