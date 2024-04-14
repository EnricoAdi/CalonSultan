<?php
setcookie("user", "", time() - 86012, '/');
header("Location:../landingpage.php");
exit;
