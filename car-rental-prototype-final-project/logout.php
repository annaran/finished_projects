<?php
require_once 'top.php';

unset($_SESSION['sUserId']);
session_destroy();
header('Location: start.php');
?>

    <script type="text/javascript">
        window.location.href = "start.php";
    </script>
    <div class="undernav">
        <h2>You have been successfully logged out</h2>

    </div>
<?php

require_once 'bottom.php';
?>