<?php
session_start();

// Remove variables in session
session_unset();
session_destroy();

// Remove cookies
if (isset($_COOKIE)) {
    foreach ($_COOKIE as $key => $value) {
        setcookie($key, '', time() - 3600, '/'); // Set expiration to past
    }
}

header("Location: login.php");
exit();
?>
