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
        <h2>Please select a car that suits your needs</h2>
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action flex-column align-items-start "
                   onclick="selectCar('Car 1')">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Car 1</h5>

                        <img src="images/iconfinder_beetle_285806.png" height="100%" width="100%" class="card-img"
                             alt="...">
                    </div>
                    <p class="mb-1">Car 1 specification.</p>
                    <small>Hour: 200 dkk</small>
                </a>
                <a href="#" class="list-group-item list-group-item-action flex-column align-items-start"
                   onclick="selectCar('Car 2')">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Car 2</h5>

                        <img src="images/iconfinder_truck_285813.png" height="100%" width="100%" class="card-img"
                             alt="...">
                    </div>
                    <p class="mb-1">Car 2 specification.</p>
                    <small class="text-muted">Hour: 300dkk</small>
                </a>
                <a href="#" class="list-group-item list-group-item-action flex-column align-items-start"
                   onclick="selectCar('Car 3')">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Car 3</h5>

                        <img src="images/iconfinder_SUV_285812.png" height="100%" width="100%" class="card-img"
                             alt="...">
                    </div>
                    <p class="mb-1">Car 3 specification.</p>
                    <small class="text-muted">Hour: 220 dkk</small>
                </a>
            </div>
        </div>

        <div class="col-sm-12 col-md-12 col-lg-12">
            <button type="button" class="btn btn-previous" id="btn-company-bk" onclick="goto_select_company()">&laquo;
                Change company
            </button>
            <button type="button" class="btn btn-next" id="btn-confirmation" onclick="goto_confirmation()">Confirm
                booking &raquo;
            </button>
        </div>
    </div>
<?php
$sLinkToScript = '<script src="js/functions.js"></script>';
require_once 'bottom.php';
?>