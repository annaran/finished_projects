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
        <h2>When would you like to start your journey?</h2>
        <br>
        <div class="row">
            <form id="frmDatetime" class="myForm">
                <div style="overflow:visible;">
                    <div class="form-group">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>

                                <input type="text" id="datetimepicker" class="form-control" placeholder="">
                            </div>
                        </div>
                    </div>

                    <script type="text/javascript">
                        $(".form-control").datetimepicker({

                            minDate: new Date(),
                            defaultDate: new Date()
                        });
                    </script>
                </div>

                <br><br>

                <div class="col-sm-12 col-md-12 col-lg-12">
                    <button type="button" class="btn btn-previous" id="btn-location-bk" onclick="backto_location()">
                        &laquo; Change location
                    </button>
                    <button type="button" class="btn btn-next" id="btn-hours">Select hours &raquo;</button>
                </div>
            </form>
        </div>
    </div>

<?php
$sLinkToScript = '<script src="js/functions.js"></script>';
require_once 'bottom.php';
?>