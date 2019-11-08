<?php


ini_set('display_errors', 0);

$sPhone = $_POST['txtSignupPhone'] ?? '';
if( empty($sPhone) ){ sendResponse(0, __LINE__,'Phone cannot be empty');  }
if( strlen($sPhone) != 8 ){ sendResponse(0, __LINE__,'Phone must be 8 digit long number'); }
if( intval($sPhone) < 10000000 ){ sendResponse(0, __LINE__,'Phone must be 8 digit long number'); }
if( intval($sPhone) > 99999999 ){ sendResponse(0, __LINE__,'Phone must be 8 digit long number'); }

// validate name
$sName = $_POST['txtSignupName'] ?? '';
if( empty($sName) ){ sendResponse(0, __LINE__,'Name cannot be empty');  }
if( strlen($sName) < 2 ){ sendResponse(0, __LINE__,'Name must be at least 2 characters long'); }
if( strlen($sName) > 20 ){ sendResponse(0, __LINE__,'Name is too long'); }

// validate last name
$sLastName = $_POST['txtSignupLastName'] ?? '';
if( empty($sLastName) ){ sendResponse(0, __LINE__,'Last name cannot be empty');  }
if( strlen($sLastName) < 2 ){ sendResponse(0, __LINE__,'Last name must be at least 2 characters long'); }
if( strlen($sLastName) > 20 ){ sendResponse(0, __LINE__,'Last name is too long'); }

// validate email
$sEmail = $_POST['txtSignupEmail'] ?? '';
if( empty($sEmail) ){ sendResponse(0, __LINE__,'Email cannot be empty');  }
if( !filter_var( $sEmail, FILTER_VALIDATE_EMAIL ) ){ sendResponse(0, __LINE__,'This is not a valid email address');  }

// validate password
$sPassword = $_POST['txtSignupPassword'] ?? '';
if( empty($sPassword) ){ sendResponse(0, __LINE__,'Password cannot be empty');  }
if( strlen($sPassword) < 4 ){ sendResponse(0, __LINE__,'Password must be at least 4 characters long'); }
if( strlen($sPassword) > 50 ){ sendResponse(0, __LINE__,'Password too long'); }

// validate confirm password
$sConfirmPassword = $_POST['txtSignupConfirmPassword'] ?? '';
if( empty($sConfirmPassword) ){ sendResponse(0, __LINE__,'Repeated password cannot be empty');  }
if( $sPassword != $sConfirmPassword ){ sendResponse(0, __LINE__,'Passwords do not match');  }


// CPR validate
$sCpr = $_POST['txtSignupCpr'] ?? '';
if( empty($sCpr) ){ sendResponse(0, __LINE__,'Cpr cannot be empty');  }
if( strlen($sCpr) != 10 ){ sendResponse(0, __LINE__,'Cpr must be 10 digits long'); }
if( !ctype_digit($sCpr)  ){ sendResponse(0, __LINE__,'Cpr can only contain numbers');  }

$sDateCprDay = substr($sCpr, 0, 2);
$sDateCprMonth = substr($sCpr, 2, 2);

//check if month or day are not too large
if($sDateCprDay>31 || $sDateCprMonth > 12)
{
    sendResponse(0, __LINE__,'Incorrect cpr format, must start with valid date');
}

//check if there are not too many days in specific months
$aShortMonth = array("04", "06", "09", "11");
$aLongMonth = array("01","03","05","07","08","10","12");

if (in_array( $sDateCprMonth,$aLongMonth) && intval($sDateCprDay)>31)
{
        sendResponse(0, __LINE__,'Incorrect cpr format, must start with valid date');
}

if (in_array( $sDateCprMonth,$aShortMonth) && intval($sDateCprDay)>30)
{
        sendResponse(0, __LINE__,'Incorrect cpr format, must start with valid date');
}

if($sDateCprMonth == "02" && $sDateCprDay>29)
{
    sendResponse(0, __LINE__,'Incorrect cpr format, must start with valid date');
}





$sData = file_get_contents('../data/clients.json');
$jData = json_decode($sData);
if( $jData == null ){ sendResponse(0, __LINE__,'sData is null'); }
$jInnerData = $jData->data;

//check if phone is already registered in the bank
if($jInnerData->$sPhone)
{
    sendResponse(0, __LINE__,'Phone is already registered');
}


//client data
$jClient = new stdClass(); // json empty
$jClient->name = $sName;
$jClient->lastName = $sLastName;
$jClient->email = $sEmail;
$jClient->password = password_hash( $sPassword, PASSWORD_DEFAULT );
$jClient->cpr = $sCpr;
$jClient->wrongLoginCounter = 0;
$jClient->timeBlocked = 0;
$jClient->balance = 0;
$jClient->admin = 0;

//accounts data
//client gets a standard account in dkk when creating profile 
$jClient->accounts = new stdClass();
$jAccount = new stdClass();
$jAccount->balance = 0;
$jAccount->type = 'standard';
$jAccount->currency = 'dkk';
$jAccount->status = 1;
$sAccountId = (string)rand ( 1000 , 9999 ).(string)rand ( 10000000 , 99999999 );
$jClient->accounts->$sAccountId = $jAccount;

//setting default account number for transfers
$jClient->defaultTransferAccount = $sAccountId;

//cards data
$jClient->cards = new stdClass();
$jCard = new stdClass();
$jCard->pin = rand ( 1000 , 9999 );
$jCard->cvv2 = rand ( 100 , 999 );
$jCard->cardType1 = 'debit';
$jCard->cardType2 = 'visa';
$jCard->expiryDate = date('d-m-Y', strtotime('+3 years'));
$jCard->status = 1;
$sCardNumber = (string)rand ( 10000000 , 99999999 ).(string)rand ( 10000000 , 99999999 );
$jClient->cards->$sCardNumber = $jCard; 

//loans 
$jClient->loans = new stdClass();

//money requests 
$jClient->moneyRequests = new stdClass();

//transactions not read
$jClient->transactionsNotRead = new stdClass();

//transactions
$jClient->transactions = new stdClass();

//messages
$jClient->messages = new stdClass();

$jInnerData->$sPhone = $jClient;

$sData = json_encode( $jData, JSON_PRETTY_PRINT );
if( $sData == null   ){ sendResponse(0, __LINE__,'sData is null'); }
file_put_contents( '../data/clients.json', $sData );

// SUCCESS
sendResponse(1, __LINE__,'Sign up successful');


// **************************************************

function sendResponse( $bStatus, $iLineNumber, $sMessage ){
  echo '{"status":'.$bStatus.', "code":'.$iLineNumber.', "message":"'.$sMessage.'"}';
  exit;
}






















