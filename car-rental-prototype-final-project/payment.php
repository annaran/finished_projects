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
$total = $jClient->tempRental->total;

?>

    <div class="container-fluid">
        <form id="frmPayment">

            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="panel panel-default">

                        <div class="panel-heading ">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <h3 class="panel-title">
                                    Payment Details

                                </h3>


                                <div class="checkbox pull-right ">
                                    <label>
                                        <input type="checkbox" name="checkbox-remember" id="checkbox-remember"
                                               checked="checked"/>
                                        Remember
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form role="form">
                                <div class="form-group">
                                    <label for="cardNumber">
                                        CARD NUMBER</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="cardNumber" id="cardNumber"
                                               placeholder="Valid Card Number"
                                        />
                                        <span class="input-group-addon"><span
                                                    class="glyphicon glyphicon-lock"></span></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-7 col-md-7">
                                        <div class="form-group">
                                            <label for="expiryMonth">
                                                EXPIRY MONTH</label>

                                            <div class="col-xs-6 col-lg-6 pl-ziro">
                                                <input type="text" class="form-control" name="expiryMonth"
                                                       id="expiryMonth" placeholder="MM"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="expiryYear">
                                                EXPIRY YEAR</label>
                                            <div class="col-xs-6 col-lg-6 pl-ziro">
                                                <input type="text" class="form-control" name="expiryYear"
                                                       id="expiryYear" placeholder="YY"/></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-md-5 pull-right">
                                        <div class="form-group">
                                            <label for="cvCode">
                                                CV CODE</label>
                                            <input type="password" class="form-control" name="cvCode" id="cvCode"
                                                   placeholder="CV"/>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <ul class="nav nav-pills nav-stacked">
                        <li class="active"><span class="badge pull-right"><span
                                        class="glyphicon glyphicon-xxx"></span><?php echo $total; ?></span> Amount</a>
                        </li>
                    </ul>
                    <br/>

                    <button class="btn btn-business btn-lg btn-block" type="submit">Pay</button>
                </div>
            </div>
        </form>
    </div>


<?php
$sLinkToScript = '<script src="js/functions.js"></script>';
require_once 'bottom.php';
?>