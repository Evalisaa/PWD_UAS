<?php
session_start();

session_unset();
session_destroy();

header("Location: ../../frontend/assets/index.html");
exit();
?>
