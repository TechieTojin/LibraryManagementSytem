<?php
session_start();
session_destroy();
// Redirect to the login page:
header('Location: studlogin.html');
exit(); // Make sure no code is executed after the redirect
?>
