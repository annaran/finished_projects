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
ini_set('display_errors', 0);
$sUserId = $_SESSION['sUserId'];

$sData = file_get_contents('data/clients.json');
$jData = json_decode($sData);
if ($jData == null) {
    echo 'System update';
}
$jInnerData = $jData->data;
$jClient = $jInnerData->$sUserId;


?>


    <h2>Update your password</h2>

    <form id="frmUpdateInfo">
        <input type="password" name="txtUpdateInfoCurrentPassword" placeholder="current password">
        <input type="password" name="txtUpdateInfoNewPassword" placeholder="new password">
        <input type="password" name="txtUpdateInfoRepeatNewPassword" placeholder="repeat new password">
        <br><br>
        <button>Update</button>
    </form>


<?php
$sLinkToScript = '<script src="js/update-info.js"></script>';
require_once 'bottom.php';
?>