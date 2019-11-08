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
    <div class="container">

        <div class="col-sm-12 col-md-12 col-lg-12">
            <h2>Your payment has been completed.</h2>
        </div>
        <div class="payment-success col-sm-12 col-md-12 col-lg-12">

            <a href="profile" style="text-align: center">Back to profile</a>

        </div>
    </div>
<?php

require_once 'bottom.php';
?>