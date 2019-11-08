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


<a href="apply_for_loan">&#10010; Apply for loan</a><br><br>


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

<a href="manage_loans?status=0">&#9744; Pending requests</a> &#10073;
<a href="manage_loans?status=1">&#9745; Approved requests</a> &#10073;
<a href="manage_loans?status=2">&#9746; Rejected requests</a><br><br>


<table>
    <thead>
    <tr>
        <td>ID</td>
        <td>PAY BACK DATE</td>
        <td>AMOUNT</td>
        <td>AMOUNT LEFT TO PAY</td>
        <td>APPROVAL STATUS</td>
        <td>PAYBACK STATUS</td>

    </tr>
    </thead>
    <tbody id="lblLoans">

    <?php
    foreach ($jClient->loans as $sLoanId => $jLoan) {
        //by default display loan requests with status 0 (pending approval)
        if ($jLoan->status == $_GET['status'] ?? 0) {
            echo "
                      <tr>
                        <td>$sLoanId</td>
                        <td>$jLoan->paybackDate</td>
                        <td>$jLoan->amountTotal</td>
                        <td>$jLoan->amountLeftToPay</td>
                        <td>$jLoan->status</td>
                        <td>$jLoan->paybackStatus</td> 
                          
                      </tr>
                    ";
        }

    }

    ?>

    </tbody>
</table>

<?php

require_once 'bottom.php';
?>

