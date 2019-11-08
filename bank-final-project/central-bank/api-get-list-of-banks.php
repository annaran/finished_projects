<?php

header('Access-Control-Allow-Origin: *');

$sVerifyKey = '1111-2222-3333';

if( $_GET['key'] != $sVerifyKey ){
  echo '{"status":0, "code":'.__LINE__.'}';
  exit;
}

echo file_get_contents('banks.json');
