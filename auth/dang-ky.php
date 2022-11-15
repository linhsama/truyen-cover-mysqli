<?php session_start();?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Truyện Cover</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="../assets/css/app.css" type="text/css" />
    <!-- toasty -->
    <link rel="stylesheet" href="../assets/vendor/toasty/dist/toasty.min.css" type="text/css" />
</head>

<body class="backgound">
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
                    $msg = "Tên hiển thị phải lớn hơn 3 ký tự";
                }elseif(strlen($ten_tai_khoan)<3){
                    $check = false;
                    $msg = "Tên tài khoản phải lớn hơn 3 ký tự";
                }elseif(strlen($_POST['mat_khau'])<6){
                    $check = false;
                    $msg = "Mật khẩu phải lớn hơn 6 ký tự";
                }else{
                    include_once(__DIR__ . '../../backend/dbconnect.php'); 
                    $sql_check = <<<EOT
                        SELECT * FROM tai_khoan WHERE ten_tai_khoan = '$ten_tai_khoan'
    EOT; 
                    $status_check = mysqli_query($conn, $sql_check);
                    $data_old = mysqli_fetch_array($status_check, MYSQLI_ASSOC);

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
                        $status = mysqli_query($conn, $sql);
                        echo "<script> location.href='./dang-nhap.php?status=success';</script>";
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
                        <input type="password" class="form-control" name="mat_khau" required=""></input>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn-lg btn-primary" style="text-align:center" name="signup">Đăng
                            ký</button>
                        </br>
                        </br>
                        Bạn đã chưa có tài khoản? <a href="./dang-nhap.php"><b>Đăng
                                nhập</b></a>
                    </div>
                </div>
            </div>
    </div>
    </form>
    </div>
    <!-- end body -->

    <!-- jQuery JS -->
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="../assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!-- toasty -->
    <script src="../assets/vendor/toasty/dist/toasty.min.js"></script>


</body>

</html>