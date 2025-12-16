<?php
session_start();

session_unset();
session_destroy();

header("Location: ../../admin/assets/loginAdmin.html");
exit();
?>
