<?php

require_once 'top.php';


if( !isset($_SESSION['sUserId'] ) ){
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
if( $jData == null ){ echo 'System update'; }
$jInnerData = $jData->data;
$jClient = $jInnerData->$sUserId;

//default status
if (!isset($_GET["status"])) {
  $_GET["status"]=0;
}

?>


<a href="transfer_money"><b>&#10562;</b> Transfer money</a><br><br>

<?php
if ($_GET['status']==0){
echo "<h2>Outgoing transactions</h2>";
}

if ($_GET['status']==1){
  echo "<h2>Incoming transactions</h2>";
}

?>

 
<a href="manage_transactions?status=0"><b>&#8600;</b> Outgoing</a> &#10073;
<a href="manage_transactions?status=1"><b>&#8599;</b> Incoming</a>
<br>



<br>

  <table>
    <thead>
      <tr>
        <td>ID</td>
        <td>DATE</td>
        <td>AMOUNT</td>
        <td>FROM PHONE</td>
        <td>MESSAGE</td>
      </tr>
    </thead>
    <tbody id="lblTransactions">

      <?php
//incoming transactions
if($_GET['status'] == 1)
{
      foreach( $jClient->transactions as $sTransactionId => $jTransaction ){
        if($jTransaction->fromPhone != '')
        {

        echo "
          <tr>
            <td>$sTransactionId</td>
            <td>$jTransaction->date</td>
            <td>$jTransaction->amount</td>
            <td>$jTransaction->fromPhone</td>
            <td>$jTransaction->message</td>
          </tr>
        ";
        }
      }   
}

//outgoing transactions 
if($_GET['status'] == 0)
{
      foreach( $jClient->transactions as $sTransactionId => $jTransaction ){
        if($jTransaction->fromPhone == '')
        {

        echo "
          <tr>
            <td>$sTransactionId</td>
            <td>$jTransaction->date</td>
            <td>$jTransaction->amount</td>
            <td>$jTransaction->fromPhone</td>
            <td>$jTransaction->message</td>
          </tr>
        ";
        }
      }   
}
      ?>

    </tbody>
  </table>

<?php 

require_once 'bottom.php'; 
?>

