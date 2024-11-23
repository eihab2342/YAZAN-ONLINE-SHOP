<?php
session_start();

//remove variables in session
session_unset();
session_destroy();

header("Location: ../users/login.php");
exit();
?>
