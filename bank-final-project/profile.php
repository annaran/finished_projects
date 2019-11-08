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


?>


<h2>Client profile</h2><br>
<div><b>Name: </b><?= $jClient->name; ?></div>
<div><b>Last Name: </b><?= $jClient->lastName; ?> </div>
<div><b>CPR: </b><?= $jClient->cpr; ?> </div>
<div><b>Email: </b><?= $jClient->email; ?> </div>
<div><b>Phone: </b><?= $sUserId; ?> </div>
<br><br><br>

<div class="profile_links">
    <a href="update_info">Update password</a><br>
    <a href="manage_accounts">Manage accounts</a> <br>
    <a href="manage_transactions">Manage transactions</a><br>
    <a href="manage_cards">Manage cards</a><br>
    <a href="manage_requests">Manage money requests</a><br>
    <a href="manage_loans">Manage loans</a><br>

</div>


<?php

require_once 'bottom.php';
?>

