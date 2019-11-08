<?php

require_once 'top.php';
//require_once 'connect.php';


if (!isset($_SESSION['sUserId'])) {
    //header('Location: login');
    echo "
      <script type=\"text/javascript\"> 
      window.location.href=\"login.php\";
      </script>
      ";
}


ini_set('display_errors', 0);

$sUserId = $_SESSION['sUserId'];

$sData = file_get_contents('data/data.json');
$jData = json_decode($sData);
if ($jData == null) {
    echo 'System update';
}
$jInnerData = $jData->data;
$jClient = $jInnerData->$sUserId;


?>


<div class="container">
    <div class="card">
        <div class="card-body">
            <br><br>
            <button type="button" class="btn btn-rent" onclick="goto_location_search()">Rent a car now</button>

        </div>
        <br><br>
        <img class="profilepic" src="images/l60Hf.png" alt="Profile picture">
        <div class="card-body">
            <h5 class="card-title">John Doe</h5>
            <p class="card-text">12 34 56 78</p>
            <p class="card-text">john@doe.com</p>
        </div>
        <ul class="list-group list-group-flush">

            <?php
            foreach ($jClient->rentals as $sRentalId => $jRental) {


                echo "
            
            <li class=\"list-group-item\">           

                <h5 class=\"card-title confrm\">$jRental->date</h5>
                 <h5 class=\"card-text confrm\">$jRental->location</h5>
                <h5 class=\"card-text confrm\">$jRental->company</h5>
                <h5 class=\"card-text confrm\">$jRental->car</h5>
                <h5 class=\"card-text confrm\">$jRental->hours</h5>
                <small class=\"text-muted\">$jRental->total DKK</small>

            </li>
            ";

            }
            ?>

        </ul>

    </div>
</div>
<?php
$sLinkToScript = '<script src="js/functions.js"></script>';
require_once 'bottom.php';
?>

