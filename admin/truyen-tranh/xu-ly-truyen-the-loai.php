<?php session_start()?>

<?php if(!isset($_SESSION['admin'])){
		echo '<script> location.href="/truyen-cover/admin/auth/dang-nhap.php";</script>';
    }
?>
<?php 
    if(isset($_GET['truyen_id'])){
        $truyen_id = $_GET['truyen_id'];
        echo "<script> location.href='/truyen-cover/admin/truyen-tranh/truyen-the-loai.php?truyen_id=$truyen_id&result=success';</script>";
    }
?>

