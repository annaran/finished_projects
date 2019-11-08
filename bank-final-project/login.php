<?php require_once 'top.php'; ?>


    <h2>Log in</h2>

    <form id="frmLogin">
        <input type="text" name="txtLoginPhone" placeholder="phone">
        <input type="password" name="txtLoginPassword" placeholder="password">
        <a href="reset_password">Forgot password?</a>
        <br><br>
        <button>Log in</button>
    </form>


<?php
$sLinkToScript = '<script src="js/login.js"></script>';
require_once 'bottom.php';
?>