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

//$location = "Roskilde";
$location = $_GET['sLocation'] ?? '';
?>
    <div class="container">
        <h2>Where would you like to start your journey?</h2><br>
        <div class="row">
            <!-- Search form -->
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="input-group">

                    <input type="text" class="form-control" id="locationpicker" placeholder="Search"
                           value='<?php echo isset($_GET['sLocation']) ? $_GET['sLocation'] : ''; ?>'>

                    <div class="input-group-btn">

                        <button class="btn btn-default" type="submit" id="btn-locationsearch"
                                onclick="search_location()">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>

                    </div>
                </div>
            </div>
            <br>
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div id="map-container-google-1" class="z-depth-1-half map-container" style="height: 500px">

                    <iframe src="https://maps.google.com/maps?q=<?= $location; ?>&t=&z=13&ie=UTF8&iwloc=&output=embed"
                            frameborder="0"
                            style="border:0" allowfullscreen></iframe>
                </div>
            </div>
            <br>

            <div class="col-sm-12 col-md-12 col-lg-12">
                <button type="button" class="btn btn-previous" id="btn-profile" onclick="goto_profile()">&laquo;
                    Profile
                </button>
                <button type="button" class="btn btn-next" id="btn-date" onclick="goto_select_date()">Select date
                    &raquo;
                </button>
            </div>
        </div>
    </div>
<?php
$sLinkToScript = '<script src="js/functions.js"></script>';
require_once 'bottom.php';
?>