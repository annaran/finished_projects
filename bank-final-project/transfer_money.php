<?php


require_once 'top.php';

ini_set('display_errors', 0);
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
<a href="manage_transactions">&#9664;&#9664; Back to transaction list</a><br><br>

<h2>Transfer</h2>
<form id="frmTransfer">
    <input name="txtTransferToPhone" id="txtTransferToPhone" type="text" placeholder="transfer to phone">
    <input name="txtTransferAmount" id="txtTransferAmount" type="text" placeholder="transfer amount">
    <input name="txtTransferMessage" id="txtTransferMessage" type="text" placeholder="transfer message">
    <br><br>
    <button>Transfer</button>
</form>


<?php
$sLinkToScript = '<script src="js/transfer.js"></script>';
require_once 'bottom.php';
?>

