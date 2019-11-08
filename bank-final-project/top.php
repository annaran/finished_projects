<?php
session_start();
ini_set('display_errors', 0);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Anna's Bank</title>
    <link rel="stylesheet" href="css/app.css">
</head>
<body>

<img src="/bank/img/top4.png" class="logo"/>
<header></header>


<?php


if (isset($_SESSION['sUserId']) && ($_SESSION['sUserId']) != 12345678) {
    echo "
  <nav class=\"nav\">
  <a class=\"nav\" href=\"index\">Home</a>
  <a class=\"nav\" href=\"profile\">Profile</a>
  <a class=\"nav\" href=\"logout\">Log Out</a>
  <p class=\"welcome\">Welcome " . $_SESSION['sUserId'] . "!</p>
  </nav>
  
  ";
}

if (isset($_SESSION['sUserId']) && ($_SESSION['sUserId']) == 12345678) {
    echo "
  <nav class=\"nav\">
  <a class=\"nav\" href=\"index\">Home</a>
  <a class=\"nav\" href=\"admin\">Admin Panel</a>
  <a class=\"nav\" href=\"logout\">Log Out</a>
  <p class=\"welcome\">Welcome " . $_SESSION['sUserId'] . "!</p>
  </nav>
  
";
}

if (!isset($_SESSION['sUserId'])) {
    echo "
  <nav class=\"nav\">
  <a class=\"nav\" href=\"index\">Home</a>
  <a class=\"nav\" href=\"login\">Log In</a>    
  <a class=\"nav\" href=\"signup\">Sign Up</a>
  </nav>
  ";
}
?>

</body>