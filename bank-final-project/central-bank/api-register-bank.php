<?php

exit;

$sData = file_get_contents('banks.json');
$jData = json_decode($sData);

$jBank = new stdClass();
$jBank->name = $_POST['name'];
$jBank->url = $_POST['url'];

$sBankId = uniqid();
$jData->$sBankId = $jBank;

$sData = json_encode($jData);
file_put_contents('banks.json', $sData);

echo '{"status":1, "code":'.__LINE__.', "message":"thank you"}';













