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


<h2>Accounts</h2>
<table>
    <thead>
    <tr>
        <td>PHONE</td>
        <td>FIRST NAME</td>
        <td>LAST NAME</td>
        <td>ACCOUNT NUMBER</td>
        <td>ACCOUNT TYPE</td>
        <td>BALANCE</td>
        <td>CURRENCY</td>
        <td>STATUS</td>
        <td></td>
        <td></td>


    </tr>
    </thead>
    <tbody id="lblAccounts">

    <?php


    foreach ($jData->data as $sClientId => $jClient) {

        foreach ($jClient->accounts as $sAccountId => $jAccount) {
            echo "
        <tr id='$sAccountId'>
            <td>$sClientId</td>
            <td>$jClient->name</td>
            <td>$jClient->lastName</td>
            <td>$sAccountId</td>
            <td>$jAccount->type</td>
            <td class='balanceVal'>$jAccount->balance</td>
            <td>$jAccount->currency</td>
            <td class='statusVal'>$jAccount->status</td>
            <td>
            <form method=\"post\">  
            <input type=\"button\" class=\"button\" id=\"btn_activate\" value=\"Activate\" onclick=\"activateAccount('$sClientId','$sAccountId')\">            
            </form>            
            <form method=\"post\">  
            <input type=\"button\" class=\"button\" id=\"btn_block\" value=\"Block\" onclick=\"blockAccount('$sClientId','$sAccountId')\">            
            </form>
            </td>
            <td>
            <form method=\"post\">              
            <input type=\"button\" class=\"button\" id=\"btn_topup\" value=\"TopUp100\" onclick=\"topUpAccount100('$sClientId','$sAccountId')\">         
            </form>           
            <form method=\"post\">              
            <input type=\"button\" class=\"button\" id=\"btn_topup\" value=\"TopUp500\" onclick=\"topUpAccount500('$sClientId','$sAccountId')\">         
            </form>
            <form method=\"post\">              
            <input type=\"button\" class=\"button\" id=\"btn_topup\" value=\"TopUp1000\" onclick=\"topUpAccount1000('$sClientId','$sAccountId')\">         
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
$sLinkToScript = '<script src="js/admin-manage-accounts.js"></script>';
require_once 'bottom.php';
?>

