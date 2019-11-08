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

//default status
if (!isset($_GET["status"])) {
    $_GET["status"] = 0;
}


?>





<?php
if ($_GET['status'] == 0) {
    echo "<h2>Loan requests avaiting approval</h2>";
}

if ($_GET['status'] == 1) {
    echo "<h2>Approved loan requests</h2>";
}

if ($_GET['status'] == 2) {
    echo "<h2>Rejected loan requests</h2>";
}
?>


<a href="admin_loan_requests?status=0">&#9744; Pending loans</a> &#10073;
<a href="admin_loan_requests?status=1">&#9745; Approved loans</a> &#10073;
<a href="admin_loan_requests?status=2">&#9746; Rejected loans</a><br><br>

<table>
    <thead>
    <tr>
        <td>PHONE</td>
        <td>FIRST NAME</td>
        <td>LAST NAME</td>
        <td>LOAN ID</td>
        <td>AMOUNT</td>
        <td>PAY BACK DATE</td>
        <td>APPROVAL STATUS</td>
        <td></td>

    </tr>
    </thead>
    <tbody id="lblLoans">

    <?php

    foreach ($jData->data as $sClientId => $jClient) {
        foreach ($jClient->loans as $sLoanId => $jLoan) {
            //by default display loan requests with status 0 (pending approval)
            if ($jLoan->status == $_GET['status'] ?? 0) {
                echo "
          <tr id='$sLoanId'>
            <td>$sClientId</td>
            <td>$jClient->name</td>
            <td>$jClient->lastName</td>
            <td>$sLoanId</td>
            <td>$jLoan->amountTotal</td>
            <td>$jLoan->paybackDate</td>       
            <td class='statusVal'>$jLoan->status</td>
            <td>
            <form method=\"post\">  
            <input type=\"button\" id=\"btn_approve\" value=\"Approve & transfer\" onclick=\"approveLoan('$sClientId','$sLoanId')\">            
            </form>           
            <form method=\"post\">  
            <input type=\"button\" id=\"btn_reject\" value=\"Reject\" onclick=\"rejectLoan('$sClientId','$sLoanId')\">            
            </form>
            </td>   
          </tr>
        ";
            }
        }
    }
    ?>

    </tbody>
</table>


<?php
$sLinkToScript = '<script src="js/admin-manage-loans.js"></script>';
require_once 'bottom.php';
?>

