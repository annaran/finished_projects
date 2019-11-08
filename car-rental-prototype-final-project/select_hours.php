<?php require_once 'top.php';

?>

    <div class="container-fluid">
        <h2>How many hours would you like to rent the car for?</h2>


        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="input-group number-spinner">
				<span class="input-group-btn">
					<button class="btn btn-default" data-dir="dwn"><span
                                class="glyphicon glyphicon-minus"></span></button>
				</span>
                    <input type="text" class="form-control text-center" id="hourpicker" value="1">
                    <span class="input-group-btn">
					<button class="btn btn-default" data-dir="up"><span
                                class="glyphicon glyphicon-plus"></span></button>
				</span>
                </div>
            </div>
        </div>

        <br><br>

        <div class="col-sm-12 col-md-12 col-lg-12">
            <button type="button" class="btn btn-previous" id="btn-date-bk" onclick="gobackto_select_date()">&laquo;
                Change date
            </button>
            <button type="button" class="btn btn-next" id="btn-company" onclick="goto_select_company()">Select company
                &raquo;
            </button>
        </div>

    </div>
<?php
$sLinkToScript = '<script src="js/functions.js"></script>';
require_once 'bottom.php';
?>