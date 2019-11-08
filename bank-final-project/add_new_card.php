<?php

require_once 'top.php';


if (!isset($_SESSION['sUserId'])) {
    //header('Location: login');
    echo "
    <script type=\"text/javascript\"> 
  window.location.href=\"login.php\";
  </script>
  ";
}
$sUserId = $_SESSION['sUserId'];

$sData = file_get_contents('data/clients.json');
$jData = json_decode($sData);
if ($jData == null) {
    echo 'System update';
}
$jInnerData = $jData->data;
$jClient = $jInnerData->$sUserId;


?>

<a href="manage_cards?status=1">&#9664;&#9664; Back to card list</a><br><br>

<h2>Add card</h2>
<form id="frmAddCard">
    <input name="txtCardType1" id="txtCardType1" type="text" placeholder="debit/credit">
    <input name="txtCardType2" id="txtCardType2" type="text" placeholder="visa/mastercard">
    <br><br>
    <button>Add</button>
</form>


<?php
$sLinkToScript = '<script src="js/card-application.js"></script>';
require_once 'bottom.php';
?>

