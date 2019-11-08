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

<a href="manage_requests">&#9664;&#9664; Back to money request management</a><br><br>

<h2>Request money from other account</h2>
<form id="frmRequestMoney">
    <input name="txtRequestFromPhone" id="txtRequestFromPhone" type="text" placeholder="request from phone">
    <input name="txtRequestAmount" id="txtRequestAmount" type="text" placeholder="requested amount">
    <input name="txtRequestMessage" id="txtRequestMessage" type="text" placeholder="message">
    <br><br>
    <button>Send request</button>
</form>


<?php
$sLinkToScript = '<script src="js/request-money.js"></script>';
require_once 'bottom.php';
?>

