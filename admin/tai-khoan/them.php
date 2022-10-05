<?php session_start()?>

<?php if(!isset($_SESSION['admin'])){
		echo '<script> location.href="/truyen-cover/admin/auth/dang-nhap.php";</script>';
    }
?><?php if($_SESSION['admin'] != 'admin'){
		echo '<script> location.href="/truyen-cover/admin/auth/dang-nhap.php";</script>';
    }
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm tài khoản</title>

    <!-- CSS dùng chung cho toàn bộ trang web -->
    <?php include_once(__DIR__ . '/../../frontend/layouts/admin-styles.php'); ?>
</head>

<body>
    <!-- Mở kết nối -->
    <?php include_once(__DIR__ . '/../../backend/dbconnect.php'); 

    // check validation hiển thị lỗi php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // kiểm tra có nhấn nút cập nhật chưa
    if (isset($_POST['btn_add_tai_khoan'])) {
        $ten_hien_thi = $_POST['ten_hien_thi'];
        $ten_tai_khoan = $_POST['ten_tai_khoan'];
        $mat_khau = $_POST['mat_khau'];
        $phan_quyen = $_POST['phan_quyen'];
        $trang_thai = $_POST['trang_thai'];

        // tạo biến chứa lỗi
        $errors = [];

        // check required và lenght
        if (empty($ten_hien_thi)) {
            $errors['$ten_hien_thi'][] = [
                'rule' => 'required',
                'rule_value' => true,
                'value' => $ten_hien_thi,
                'msg' => 'Vui lòng nhập tên hiển thị'
            ];
        } else if (!empty($ten_hien_thi) && strlen($ten_hien_thi) < 3) {
            $errors['$ten_hien_thi'][] = [
                'rule' => 'minlenght',
                'rule_value' => 3,
                'value' => $ten_hien_thi,
                'msg' => 'Tên hiển thị phải có ít nhất 3 ký tự'
            ];
        } else if (!empty($ten_hien_thi) && strlen($ten_hien_thi) > 50) {
            $errors['$truyen_ma'][] = [
                'rule' => 'maxlenght',
                'rule_value' => 50,
                'value' => $ten_hien_thi,
                'msg' => 'Tên hiển thị không được vượt quá ký tự'
            ];
        }

        if (empty($ten_tai_khoan)) {
            $errors['$ten_tai_khoan'][] = [
                'rule' => 'required',
                'rule_value' => true,
                'value' => $ten_tai_khoan,
                'msg' => 'Vui lòng nhập tên tài khoản'
            ];
        } else if (!empty($ten_tai_khoan) && strlen($ten_tai_khoan) < 3) {
            $errors['$ten_tai_khoan'][] = [
                'rule' => 'minlenght',
                'rule_value' => 3,
                'value' => $ten_tai_khoan,
                'msg' => 'Tên tài khoản phải có ít nhất 3 ký tự'
            ];
        } else if (!empty($ten_tai_khoan) && strlen($ten_tai_khoan) > 50) {
            $errors['$ten_tai_khoan'][] = [
                'rule' => 'maxlenght',
                'rule_value' => 50,
                'value' => $ten_tai_khoan,
                'msg' => 'Tên tài khoản không được vượt quá 50 ký tự'
            ];
        }

        if (empty($mat_khau)) {
            $errors['$mat_khau'][] = [
                'rule' => 'required',
                'rule_value' => true,
                'value' => $mat_khau,
                'msg' => 'Vui lòng nhập mật khẩu'
            ];
        } else if (!empty($mat_khau) && strlen($mat_khau) < 3) {
            $errors['$mat_khau'][] = [
                'rule' => 'minlenght',
                'rule_value' => 3,
                'value' => $mat_khau,
                'msg' => 'Mật khẩu phải có ít nhất 3 ký tự'
            ];
        } else if (!empty($mat_khau) && strlen($mat_khau) > 50) {
            $errors['$mat_khau'][] = [
                'rule' => 'maxlenght',
                'rule_value' => 50,
                'value' => $mat_khau,
                'msg' => 'Mật khẩu không được vượt quá ký tự'
            ];
        }
    } 
        // end check required và lenght
    ?>

    <!-- thêm thông tin -->
    <?php if(isset($_POST['btn_add_tai_khoan'])) : ?>
    <?php if( !isset($errors) OR (empty($errors))): 
    $sql = <<<EOT
		INSERT INTO tai_khoan(ten_hien_thi,ten_tai_khoan,mat_khau,phan_quyen,trang_thai) 
		VALUES ('$ten_hien_thi','$ten_tai_khoan','$mat_khau', '$phan_quyen', '$trang_thai');
EOT;
		mysqli_query($conn, $sql) or die ("<b>Có lỗi khi thực hiện câu lệnh SQL: </b> ". mysqli_error($conn). "<br/> <b>Câu lệnh vừa thực thi: </b> $sql");
		echo '<script> location.href="/truyen-cover/admin/tai-khoan/index.php?result=success";</script>';

    ?>
    <?php endif; ?>
    <?php endif; ?>
    <!-- end thêm thông tin -->

    <!-- navigation -->
    <?php include_once(__DIR__ . '/../../frontend/partials/admin-sidebar.php'); ?>
    <!-- end navigation -->

    <!-- content -->
    <section id="content">
        <nav>
            <i class='bx bx-menu'></i>
        </nav>
        <main>
            <div class="head-title">
                <div class="left">
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Quản lý tài khoản</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="/truyen-cover/admin/tai-khoan/index.php">Danh sách tài khoản</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="/truyen-cover/admin/tai-khoan/them.php">Thêm mới tài khoản</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="table-data">
                <div class="index">
                    <div class="head">
                        <h3>Thêm tài khoản</h3>
                    </div>
                    <div class="add-update">
                        <!-- vùng hiển thị lỗi -->

                        <?php if(isset($_POST['btn_add_tai_khoan'])) : ?>
                        <?php if( isset($errors) && (!empty($errors))): ?>

                        <div id="errors-container" class="alert alert-danger alert-dismissible fade show mt-2"
                            role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <ul>
                                <?php foreach($errors as $fields):?>
                                <?php foreach($fields as $field):?>
                                <li><?php echo $field['msg'] ?></li>
                                <?php endforeach; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                        <?php endif; ?>
                        <!-- end vùng hiển thị lỗi -->

                        <!-- form nhập liệu -->
                        <form class="add-update-list" id="frm_add_update_tai_khoan" action="" method="post">
                            <div class="col">
                                <label for="ten_hien_thi" class="form-label">Tên hiển thị</label>
                                <input type="text" class="form-control" id="ten_hien_thi" name="ten_hien_thi">
                            </div>
                            <div class="col">
                                <label for="ten_tai_khoan" class="form-label">Tên tài khoản</label>
                                <input type="text" class="form-control" id="ten_tai_khoan" name="ten_tai_khoan">
                            </div>
                            <div class="col">
                                <label for="mat_khau" class="form-label">Mật khẩu</label>
                                <input type="password" class="form-control" id="mat_khau" name="mat_khau">
                            </div>
                            <div class="col">
                                <label for="phan_quyen" class="form-label">Phân quyền</label>
                                <select class="form-select form-control" id="phan_quyen" name="phan_quyen">
                                    <option value="0">Admin</option>
                                    <option value="1">Mod</option>
                                    <option value="2">User</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="trang_thai" class="form-label">Trạng thái</label>
                                <select class="form-select form-control" id="trang_thai" name="trang_thai">
                                    <option value="1">Kích hoạt</option>
                                    <option value="2">Khóa</option>
                                </select>
                            </div>
                            <br />
                            <div class="col text-center">
                                <button type="submit" class="btn btn-primary" id="btn_add_tai_khoan"
                                    name="btn_add_tai_khoan"><i class="fa-solid fa-floppy-disk"></i> Lưu thông tin</button>
                            </div>
                            <!-- form nhập liệu -->

                    </div>
                </div>
        </main>
    </section>
    <!-- end content -->

    <!-- script -->
    <?php include_once(__DIR__ . '/../../frontend/layouts/admin-scripts.php'); ?>
    <!-- end script -->
</body>

</html>