<?php
session_start();

unset($_SESSION['authenticated_regular']);
unset($_SESSION['authenticated_admin']);
unset($_SESSION['auth_user']);
header('Location: login.php');
?>