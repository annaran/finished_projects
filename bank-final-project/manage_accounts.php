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
    $_GET["status"] = 1;
}

?>

<a href="add_new_account">&#10010; Create a new account</a><br><br>


<?php
if ($_GET['status'] == 1) {
    echo "<h2>Your active accounts</h2>";
}

if ($_GET['status'] == 2) {
    echo "<h2>Your blocked accounts</h2>";
}


?>

<a href="manage_accounts?status=1">&#9745; Active accounts</a> &#10073;
<a href="manage_accounts?status=2">&#9746; Blocked accounts</a><br><br>


<table>
    <thead>
    <tr>
        <td>ACCOUNT NUMBER</td>
        <td>ACCOUNT TYPE</td>
        <td>BALANCE</td>
        <td>CURRENCY</td>
        <td>STATUS</td>
        <td></td>
    </tr>
    </thead>
    <tbody id="lblAccounts">

    <?php
    foreach ($jClient->accounts as $sAccountId => $jAccount) {
        //by default display cards with status 1
        if ($jAccount->status == $_GET['status']) {
            echo "
                                  <tr id='$sAccountId'>
                                    <td>$sAccountId</td>
                                    <td>$jAccount->type</td>
                                    <td>$jAccount->balance</td>
                                    <td>$jAccount->currency</td>
                                    <td class='statusVal'>$jAccount->status</td>
                                    <td>
                                    <form method=\"post\">  
                                    <input type=\"button\" id=\"btn_approve\" value=\"Block\" onclick=\"blockAccount('$sAccountId')\">            
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
$sLinkToScript = '<script src="js/block-account.js"></script>';
require_once 'bottom.php';
?>

