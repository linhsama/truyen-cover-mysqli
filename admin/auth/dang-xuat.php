<?php include_once(__DIR__ . '/../check-auth.php'); ?>

<?php
session_start();
    unset($_SESSION["admin"]);
    session_destroy();
    header("location:/truyen-cover/admin/index.php");
?>