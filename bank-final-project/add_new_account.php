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
<a href="manage_accounts">&#9664;&#9664; Back to account list</a><br><br>

<h2>Add account</h2>
<form id="frmAddAccount">
    <input name="txtAccountType" id="txtAccountType" type="text" placeholder="savings/checking/standard">
    <input name="txtAccountCurrency" id="txtAccountCurrency" type="text" placeholder="dkk/usd">
    <br><br>
    <button>Add</button>
</form>


<?php
$sLinkToScript = '<script src="js/account-application.js"></script>';
require_once 'bottom.php';
?>

