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
        <h2>Please pick which company you would like to rent from</h2>
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="list-group">
                <a href="#" id="company1" class="list-group-item list-group-item-action flex-column align-items-start "
                   onclick="selectCompany('Company 1')">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Company 1</h5>
                        <small>1.2 km away</small>
                    </div>
                    <p class="mb-1">Company 1 info</p>
                    <small>Company 1 address</small>
                </a>
                <a href="#" id="company2" class="list-group-item list-group-item-action flex-column align-items-start"
                   onclick="selectCompany('Company 2')">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Company 2</h5>
                        <small class="text-muted">2.2 km away</small>
                    </div>
                    <p class="mb-1">Company 2 info</p>
                    <small class="text-muted">Company 2 address</small>
                </a>
                <a href="#" id="company3" class="list-group-item list-group-item-action flex-column align-items-start"
                   onclick="selectCompany('Company 3')">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Company 3</h5>
                        <small class="text-muted">5.0 km away</small>
                    </div>
                    <p class="mb-1">Company 2 info</p>
                    <small class="text-muted">Company 3 address</small>
                </a>
            </div>
        </div>

        <div class="col-sm-12 col-md-12 col-lg-12">
            <button type="button" class="btn btn-previous" id="btn-hours-bk" onclick="gobackto_select_hours()">&laquo;
                Change hours
            </button>
            <button type="button" class="btn btn-next" id="btn-car" onclick="goto_select_car()">Select car &raquo;
            </button>
        </div>
    </div>
<?php
$sLinkToScript = '<script src="js/functions.js"></script>';
require_once 'bottom.php';
?>