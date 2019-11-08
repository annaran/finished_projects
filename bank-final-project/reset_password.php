<?php require_once 'top.php'; ?>


    <h2>Password reset</h2>

    <form id="frmResetPassword">
        <input type="text" id="txtLoginPhone" name="txtLoginPhone" placeholder="phone">
        <br><br>
        <button>Reset password</button>
    </form>


<?php
$sLinkToScript = '<script src="js/password_reset.js"></script>';
require_once 'bottom.php';
?>