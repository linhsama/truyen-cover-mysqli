<?php 
    if(isset($_GET['truyen_id'])){
        $truyen_id = $_GET['truyen_id'];
        echo "<script> location.href='index.php?direction=truyen-the-loai&truyen_id=$truyen_id&status=success';</script>";
    }
?>

