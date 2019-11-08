<?php
require_once 'top.php';

?>
    <div class="container">

        <h2>Sign up</h2>
        <div class="row">
            <form id="frmSignup" class="myForm" action="apis/api-signup" method="POST">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <input name="txtSignupName" class="form-control" type="text" placeholder="Name" value="">
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <input name="txtSignupEmail" class="form-control" type="text" placeholder="Email" value="">
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <input name="txtSignupPassword" class="form-control" type="password" placeholder="Password"
                           value="">
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <input name="txtSignupConfirmPassword" class="form-control" type="password"
                           placeholder="Confirm password" value="">
                </div>
                <br>
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <button type="button" class="btn btn-business">Sign up</button>
                </div>
                <br><br>
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <p>Already have an account?<br><a href="login">Log in</a></p>
                </div>
            </form>
        </div>

    </div>
<?php
$sLinkToScript = '<script src="js/signup.js"></script>';
require_once 'bottom.php';
?>