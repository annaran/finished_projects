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

<a href="add_new_card">&#10010; Add new card</a><br><br>


<?php
if ($_GET['status'] == 1) {
    echo "<h2>Your active cards</h2>";
}

if ($_GET['status'] == 2) {
    echo "<h2>Your blocked cards</h2>";
}


?>

<a href="manage_cards?status=1">&#9745; Active cards</a> &#10073;
<a href="manage_cards?status=2">&#9746; Blocked cards</a><br><br>


<table>
    <thead>
    <tr>
        <td>CARD NUMBER</td>
        <td>EXPIRY DATE</td>
        <td>CARD TYPE 1</td>
        <td>CARD TYPE 2</td>
        <td>CVV2</td>
        <td>PIN</td>
        <td>STATUS</td>
        <td></td>
    </tr>
    </thead>
    <tbody id="lblCards">

    <?php
    foreach ($jClient->cards as $sCardId => $jCard) {
        //by default display cards with status 1
        if ($jCard->status == $_GET['status']) {
            echo "
                            <tr id='$sCardId'>
                              <td>$sCardId</td>
                              <td>$jCard->expiryDate</td>
                              <td>$jCard->cardType1</td>
                              <td>$jCard->cardType2</td>
                              <td>$jCard->cvv2</td>
                              <td>$jCard->pin</td>
                              <td class='statusVal'>$jCard->status</td>
                              <td>
                              <form method=\"post\">  
                              <input type=\"button\" id=\"btn_block\" value=\"Block\" onclick=\"blockCard('$sCardId')\">            
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
$sLinkToScript = '<script src="js/block-cards.js"></script>';
require_once 'bottom.php';
?>

