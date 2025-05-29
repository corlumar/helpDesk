<?php
session_start();
session_unset();
session_destroy();
header("Location: login.php"); // o "index.php", según como se llame tu login
exit();
?>

