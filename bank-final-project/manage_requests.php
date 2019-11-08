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

<a href="view_my_money_requests"><b>&#128064;</b> View my money requests</a><br><br>


<?php
if ($_GET['status'] == 0) {
    echo "<h2>Money requests avaiting my approval</h2>";
}

if ($_GET['status'] == 1) {
    echo "<h2>Money requests approved by me</h2>";
}

if ($_GET['status'] == 2) {
    echo "<h2>Money requests rejected by me</h2>";
}
?>


<a href="manage_requests?status=0">&#9744; Pending requests</a> &#10073;
<a href="manage_requests?status=1">&#9745; Approved requests</a> &#10073;
<a href="manage_requests?status=2">&#9746; Rejected requests</a>

<br><br>


<table>
    <thead>
    <tr>
        <td>REQUEST ID</td>
        <td>REQUESTING PHONE</td>
        <td>AMOUNT</td>
        <td>MESSAGE</td>
        <td>APPROVAL STATUS</td>
        <td></td>
        <td></td>

    </tr>
    </thead>
    <tbody id="lblMoneyRequests">

    <?php
    foreach ($jClient->moneyRequests as $sRequestId => $jRequest) {
        if ($jRequest->status == $_GET['status'] ?? 0) {
            echo "
          <tr id='$sRequestId'>
            <td>$sRequestId</td>
            <td>$jRequest->fromPhone</td>
            <td>$jRequest->amount</td>
            <td>$jRequest->message</td>       
            <td class='statusVal'>$jRequest->status</td>            
            <td>
            <form method=\"post\">  
            <input type=\"button\" id=\"btn_reject\" value=\"Approve and transfer\" onclick=\"approveMoneyRequest('$sRequestId')\">            
            </form>
            </td>
            <td>
            <form method=\"post\">  
            <input type=\"button\" id=\"btn_approve\" value=\"Reject\" onclick=\"rejectMoneyRequest('$sRequestId')\">            
            </form>
            </td>
            
          </tr>
        ";
        }
    }

    ?>

    </tbody>
</table>


<?php
$sLinkToScript = '<script src="js/manage-requests.js"></script>';
require_once 'bottom.php';
?>

