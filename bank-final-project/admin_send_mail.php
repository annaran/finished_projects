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


<h2>Send mail to all clients</h2>
<form id="frmSendMail">
    <input name="txtSubjectMailToAll" id="txtSubjectMailToAll" type="text" style="height:20px"
           placeholder="Your message subject"><br>
    <input name="txtMessageMailToAll" id="txtMessageMailToAll" style="height:200px" placeholder="Your message here">
    <br><br>
    <button>Send</button>
</form>


<?php
$sLinkToScript = '<script src="js/admin-send-mail.js"></script>';
require_once 'bottom.php';
?>

