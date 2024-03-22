<?php 
ob_start();
session_start();
unset($_SESSION['email']);
unset($_SESSION['cart_contents']);
echo '<script>alert("You have been loggedout") </script>';

header("location: ./login-page/login.html"); 
?>