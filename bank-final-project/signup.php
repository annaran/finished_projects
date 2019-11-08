<?php require_once 'top.php';

?>


    <h2>Sign up</h2>

    <form id="frmSignup" action="apis/api-signup" method="POST">
        <input name="txtSignupPhone" type="text" placeholder="phone" value="" maxlength="8">
        <input name="txtSignupName" type="text" placeholder="name" value="">
        <input name="txtSignupLastName" type="text" placeholder="last name" value="">
        <input name="txtSignupEmail" type="text" placeholder="email" value="">
        <input name="txtSignupCpr" type="text" placeholder="cpr" value="">
        <input name="txtSignupPassword" type="password" placeholder="password" value="">
        <input name="txtSignupConfirmPassword" type="password" placeholder="confirm password" value="">
        <br><br>
        <button>Sign up</button>
    </form>


<?php
$sLinkToScript = '<script src="js/signup.js"></script>';
require_once 'bottom.php';
?>