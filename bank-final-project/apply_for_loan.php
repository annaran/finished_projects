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


?>


<a href="manage_loans">&#9664;&#9664; Back to loan list</a><br><br>

<h2>Loan application</h2>
<form id="frmLoanApplication">
    <input name="txtAmount" id="txtAmount" type="text" placeholder="loan amount">
    <input name="txtNoOfYears" id="txtNoOfYears" type="text" placeholder="number of years (1-30)">
    <br><br>
    <button>Apply</button>
</form>


<?php
$sLinkToScript = '<script src="js/loan-application.js"></script>';
require_once 'bottom.php';
?>

