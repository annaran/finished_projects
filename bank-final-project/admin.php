<?php
require_once 'top.php';


if (!isset($_SESSION['sUserId']) || $_SESSION['sUserId'] != '12345678') {
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


<h2>&#10026; Admin Panel</h2>

<a href="admin_loan_requests?status=0">Manage client loan requests</a><br>
<a href="admin_view_all_accounts">Manage client accounts</a><br>
<a href="admin_send_mail">Send mail to all clients</a><br>


<?php

require_once 'bottom.php';
?>

