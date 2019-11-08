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

$sData = file_get_contents('data/data.json');
$jData = json_decode($sData);
if ($jData == null) {
    echo 'System update';
}
$jInnerData = $jData->data;
$jClient = $jInnerData->$sUserId;
$jRental = $jClient->tempRental;


?>
    <div class="container">
        <h2>Please make sure that all the details are correct before you continue</h2><br>
        <div class="card mb-3" style="max-width: 540px; text-align: left;">
            <div class="row no-gutters">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <img src="images/iconfinder_beetle_285806.png" height="100%" width="100%" class="card-img"
                         alt="...">
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="card-body">

                        <?php

                        echo "
                                  <h5 class=\"card-title confrm\">Company:</h5> <h6 class=\"card-text confrm\">$jRental->company</h6>
                        <h5 class=\"card-title confrm\">Location:</h5> <h6 class=\"card-text confrm\">$jRental->location</h6>
                        <h5 class=\"card-title confrm\">Car:</h5><h6 class=\"card-text confrm\">$jRental->car</h6>
                        <h5 class=\"card-title confrm\">Date:</h5><h6 class=\"card-text confrm\">$jRental->date</h6>
                        
                        <h5 class=\"card-title confrm\">Duration:</h5><h6 class=\"card-text confrm\">$jRental->hours hours</h6>
                        <h5 class=\"card-title confrm\">Total price:</h5><h6 class=\"card-text confrm\">$jRental->total dkk</h6>
                        ";


                        ?>


                    </div>
                    <br><br>

                </div>

                <div class="col-sm-12 col-md-12 col-lg-12">
                    <button type="button" class="btn btn-previous" id="btn-car-bk" onclick="gobackto_select_car()">
                        &laquo; Change car
                    </button>
                    <button type="button" class="btn btn-next" id="btn-payment" onclick="goto_payment()">Confirm & pay
                        &raquo;
                    </button>
                </div>
            </div>
        </div>

    </div>
<?php
$sLinkToScript = '<script src="js/functions.js"></script>';
require_once 'bottom.php';
?>