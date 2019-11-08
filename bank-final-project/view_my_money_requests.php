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

//default status
if (!isset($_GET["status"])) {
    $_GET["status"] = 0;
}


?>

<a href="manage_requests">&#9664;&#9664; Back to money request management</a><br><br>
<a href="request_money">&#128176; Request money from other person</a><br><br>


<?php
if ($_GET['status'] == 0) {
    echo "<h2>My requests avaiting approval</h2>";
}

if ($_GET['status'] == 1) {
    echo "<h2>My approved requests</h2>";
}

if ($_GET['status'] == 2) {
    echo "<h2>My rejected requests</h2>";
}
?>

<a href="view_my_money_requests?status=0">&#9744; Pending requests</a> &#10073;
<a href="view_my_money_requests?status=1">&#9745; Approved requests</a> &#10073;
<a href="view_my_money_requests?status=2">&#9746; Rejected requests</a><br><br>


<table>
    <thead>
    <tr>
        <td>REQUEST ID</td>
        <td>TO PHONE</td>
        <td>AMOUNT</td>
        <td>MESSAGE</td>
        <td>APPROVAL STATUS</td>


    </tr>
    </thead>
    <tbody id="lblRequests">

    <?php


    foreach ($jData->data as $sClientId => $jClient) {

        foreach ($jClient->moneyRequests as $sRequestId => $jRequest) {
            if ($jRequest->fromPhone == $sUserId) {
                if ($jRequest->status == $_GET['status'] ?? 0) {
                    echo "
          <tr >
            <td>$sRequestId</td>
            <td>$sClientId</td>
            <td>$jRequest->amount</td>
            <td>$jRequest->message</td>       
            <td class='statusVal'>$jRequest->status</td>            
            
            
          </tr>
        ";
                }
            }

        }
    }
    ?>

    </tbody>
</table>


<?php

require_once 'bottom.php';
?>

