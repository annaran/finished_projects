<?php
require_once 'top.php';

?>
    <div class="container">
        <h2>Log in</h2>
        <div class="row">

        <form id="frmLogin" class="myForm">
            <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="input-group" >
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <input type="text" name="txtLoginEmail" class="form-control" placeholder="Email">
            </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input type="password" name="txtLoginPassword" class="form-control" placeholder="Password">
                </div>
            </div>
                <br>
            <div class="col-sm-12 col-md-12 col-lg-12">
            <button class="btn btn-business" type="submit">Log in</button>
            </div>
            <br><br>
            <div class="col-sm-12 col-md-12 col-lg-12">
            <p>Don't have an account yet?<br><a href="signup">Sign up</a></p>
            </div>
        </form>


        </div>
    </div>
<?php
$sLinkToScript = '<script src="js/login.js"></script>';
require_once 'bottom.php';
?>