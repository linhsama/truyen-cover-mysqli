<?php session_start()?>

<?php if(!isset($_SESSION['admin'])){
		echo '<script> location.href="/truyen-cover/admin/auth/dang-nhap.php";</script>';
    }
?><!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>

    <!-- CSS dùng chung cho toàn bộ trang web -->
    <?php include_once(__DIR__ . '/../../frontend/layouts/styles.php'); ?>
    <style>
    #user-dang-nhap {
        width: 100vw;
        height: 100vh;
        position: relative;

    }

    #user-center {
        width: 500px;
        height: 500px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .user-title {
        border-bottom: 3px red solid;
        margin: 20px;
        padding: 5px;
        font-weight: bold;
    }

    .box {
        border: 1px dotted;
        padding: 10px;
        box-shadow: 17px 19px 56px rgb(0 123 255 / 14%);
    }

    input.form-control {
        height: 40px !important;
        font-size: 14px;
    }
    </style>
</head>

<body>
    <!-- header -->
    <?php include_once(__DIR__ . '/../../frontend/partials/header.php'); ?>
    <!-- end header -->

    <!-- body -->
    <div class="main-container">
        <?php 
           // Hiển thị tất cả lỗi php
           ini_set('display_errors',1);
           ini_set('display_startup_errors',1);
           error_reporting(E_ALL);
            // kiểm tra sự kiện nhấn nút đăng nhập
            $check = true;
            $msg = "";
    
            if(isset($_POST['signup'])){
                $ten_hien_thi = $_POST['ten_hien_thi'];
                $ten_tai_khoan = $_POST['ten_tai_khoan'];
                $mat_khau = md5($_POST['mat_khau']);
                $trang_thai = '1';
                $phan_quyen = '2';


                if(strlen($ten_hien_thi)<3 || strlen($ten_hien_thi)>20){
                    $check = false;
                    $msg = "Tên hiển thị phải lớn hơn 3 và nhỏ hơn 20 ký tự";
                }elseif(strlen($ten_tai_khoan)<3 || strlen($ten_tai_khoan)>20){
                    $check = false;
                    $msg = "Tên tài khoản phải lớn hơn 3 và nhỏ hơn 20 ký tự";
                }elseif(strlen($_POST['mat_khau'])<6 || strlen($_POST['mat_khau'])>20){
                    $check = false;
                    $msg = "Mật khẩu phải lớn hơn 6 và nhỏ hơn 20 ký tự";
                }else{
                    include_once(__DIR__ . '/../../backend/dbconnect.php'); 
                    $sql_check = <<<EOT
                        SELECT * FROM tai_khoan WHERE ten_tai_khoan = '$ten_tai_khoan'
    EOT; 
                    $result_check = mysqli_query($conn, $sql_check);
                    $data_old = mysqli_fetch_array($result_check, MYSQLI_ASSOC);

                    if(isset($data_old)){
                        $check = false;
                        $msg = "Tài khoản đã tồn tại";
                    }else{
                        $sql = <<<EOT
                        INSERT INTO tai_khoan(ten_hien_thi, ten_tai_khoan, mat_khau, trang_thai, phan_quyen) 
                        VALUES (
                        '$ten_hien_thi', 
                        '$ten_tai_khoan',
                        '$mat_khau',
                        '$trang_thai',
                        '$phan_quyen')
    EOT; 
                        $result = mysqli_query($conn, $sql);
                        $data = mysqli_fetch_array($result, MYSQLI_ASSOC);

                        echo "<script> location.href='/truyen-cover/backend/auth/dang-nhap.php?result=success';</script>";
                    }
                }
            }
        ?>

        <form class="form-group" id="frm_login" method="post" action="">
            <div id="user-center">

                <div class="box">
                    <!-- Vùng hiển thị lỗi -->
                    <?php if($check == false): ?>
                    <div id="errors-container" class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <ul>
                            <?=$msg;?>
                        </ul>
                    </div>
                    <?php endif?>

                    <div class="text-center">
                        <div class="user-title">ĐĂNG KÝ</div>
                    </div>
                    <div class="mb-5">
                        <label for="ten_hien_thi" class="form-label">Tên hiển thị</label>
                        <input type="text" class="form-control" name="ten_hien_thi" required="">
                    </div>
                    <div class="mb-5">
                        <label for="ten_tai_khoan" class="form-label">Tên tài khoản</label>
                        <input type="text" class="form-control" name="ten_tai_khoan" required="">
                    </div>
                    <div class="mb-5">
                        <label for="mat_khau" class="form-label">Mật khẩu</label>
                        <input type="mat_khau" class="form-control" name="mat_khau" required=""></input>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn-lg btn-primary" style="text-align:center" name="signup">Đăng
                            ký</button>
                        </br>
                        </br>
                        Bạn đã chưa có tài khoản? <a href="/truyen-cover/admin/auth/dang-nhap.php"><b>Đăng
                                nhập</b></a>
                    </div>
                </div>
            </div>
    </div>
    </form>
    </div>
    <!-- end body -->

    <!-- footer -->
    <?php include_once(__DIR__ . '/../../frontend/partials/footer.php'); ?>
    <!-- end footer -->

    <!-- Nhúng file quản lý phần SCRIPT JAVASCRIPT -->
    <?php include_once(__DIR__ . '/../../frontend/layouts/scripts.php'); ?>



</body>

</html>