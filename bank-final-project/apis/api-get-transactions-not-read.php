<?php

//TODO: Check if the user is logged
session_start();
ini_set('display_errors', 0);
$sUserId = $_SESSION['sUserId'];
$sData = file_get_contents('../data/clients.json');
$jData = json_decode($sData);
//TODO: Check if json is valid
$jInnerData = $jData->data;

$jTransactionsNotRead = $jInnerData->$sUserId->transactionsNotRead;

echo json_encode($jTransactionsNotRead);
// TODO: Delete what is inside the transactionsNotRead


