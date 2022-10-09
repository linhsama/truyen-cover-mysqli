<?php session_start();
if(isset($_SESSION['user'])){
    unset($_SESSION['user']);
    session_destroy();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>

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
    
            if(isset($_POST['login'])){
                $ten_tai_khoan = $_POST['ten_tai_khoan'];
                $mat_khau = md5($_POST['mat_khau']);

                include_once(__DIR__ . '../../backend/dbconnect.php'); 
                $sql = <<<EOT
                    SELECT * FROM tai_khoan WHERE ten_tai_khoan = '$ten_tai_khoan' AND mat_khau='$mat_khau' AND trang_thai = '1'
EOT; 
                $status = mysqli_query($conn, $sql);
                $data = mysqli_fetch_array($status, MYSQLI_ASSOC);

                if(isset($data)){
                    if($data['phan_quyen'] == '0' || $data['phan_quyen'] == '1'){
                        $_SESSION["admin"] = $ten_tai_khoan;
                        echo "<script> location.href='../admin/index.php';</script>";


                    }else{
                        $_SESSION["user"] = $ten_tai_khoan;
                        $_SESSION["user_ten_hien_thi"] = $data['ten_hien_thi'];
                        $_SESSION["user_tai_khoan_id"] = $data['tai_khoan_id'];
                        echo "<script> location.href='../index.php';</script>";
                    }

                }else{
                    $check = false;
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
                            Thông tin đăng nhập không hợp lệ hoặc tài khoản đã bị khóa
                        </ul>
                    </div>
                    <?php endif?>

                    <div class="text-center">
                        <div class="user-title">ĐĂNG NHẬP</div>
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
                        <button type="submit" class="btn-lg btn-primary" style="text-align:center" name="login">Đăng
                            nhập</button>
                        </br>
                        </br>
                        Bạn đã chưa có tài khoản? <a href="./dang-ky.php"><b>Đăng ký</b></a>
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
    <script>
    var toast = new Toasty({
        progressBar: true,
        sounds: {
            info: "../assets/vendor/toasty/dist/sounds/info/2.mp3",
            success: "../assets/vendor/toasty/dist/sounds/success/2.mp3",
            warning: "../assets/vendor/toasty/dist/sounds/warning/2.mp3",
            error: "../assets/vendor/toasty/dist/sounds/error/3.mp3",
        },
        enableSounds: true
    });
    </script>
</body>
<?php 

    if(isset($_GET['status']) && ($_GET['status']=='success')){
            echo '<script> toast.success("Thao tác thành công",200);</script>';
        }
    if(isset($_GET['status']) && ($_GET['status']=='error')){
            echo '<script> toast.error("Thao tác thất bại",500);</script>';
        }
    
    ?>

</html>